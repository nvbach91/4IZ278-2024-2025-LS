<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Business;
use Illuminate\Http\Request;


class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $user = auth()->user();

        if (!$user) {
            abort(403, 'You must be logged in to submit a review.');
        }

        // Check if user has a completed reservation for that business
        $hasReservation = $user->reservations()
            ->whereHas('timeslot.service.business', function ($query) use ($request) {
                $query->where('id', $request->business_id);
            })
            ->whereHas('timeslot', function ($query) {
                $query->where('start_time', '<', now());
            })
            ->where('status', 'completed')
            ->exists();

        if (!$hasReservation) {
            abort(403, 'You can only review businesses you have visited.');
        }

        // Prevent duplicate reviews
        $alreadyReviewed = $user->reviews()->where('business_id', $request->business_id)->exists();

        if ($alreadyReviewed) {
            return redirect()->back()->withErrors('You have already reviewed this business.');
        }

        // Create the review
        \App\Models\Review::create([
            'user_id' => $user->id,
            'business_id' => $request->business_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);


        return redirect()->route('user.profile')
            ->with('success', 'Review submitted successfully.');
    }



    public function create($business_id)
    {
        $business = Business::findOrFail($business_id);
        return view('reviews.create', compact('business'));
    }
}
