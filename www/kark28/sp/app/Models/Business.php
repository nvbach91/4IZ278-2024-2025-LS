<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Business
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * 
 * @property Collection|BusinessManager[] $business_managers
 * @property Collection|Review[] $reviews
 * @property Collection|Service[] $services
 *
 * @package App\Models
 */
class Business extends Model
{
	protected $table = 'businesses';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'description'
	];

	public function business_managers()
	{
		return $this->hasMany(BusinessManager::class);
	}

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}

	public function services()
	{
		return $this->hasMany(Service::class);
	}

	public function canEdit(?User $user): string|false
    {
        if (! $user) {
            return false;
        }

        $mgr = $this->business_managers
                    ->firstWhere('user_id', $user->id);

        if (! $mgr) {
            return false;
        }

        return match($mgr->permission_level) {
            'owner'   => 'owner',
            'manager' => 'manager',
            default   => false,
        };
    }

	public function scopeFilter(Builder $query, array $filters): Builder
	{
		return $query
			->when($filters['search'] ?? false, function ($query, $search) {
				$query->where('name', 'like', '%' . $search . '%')
					->orWhere('description', 'like', '%' . $search . '%');
			})
			->when($filters['sort'] ?? false, function ($query, $sort) {
				if ($sort === 'name_asc') {
					$query->orderBy('name', 'asc');
				} elseif ($sort === 'name_desc') {
					$query->orderBy('name', 'desc');
				} elseif ($sort === 'rating_desc') {
					$query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
				} elseif ($sort === 'newest') {
					$query->orderBy('created_at', 'desc');
				}
			});
	}

public function reservations()
{
    return $this->hasManyThrough(
        \App\Models\Reservation::class,
        \App\Models\Timeslot::class,    
        'service_id',                  
        'timeslot_id',                  
        'id',                           
        'id'                           
    )->join('services', 'timeslots.service_id', '=', 'services.id')
     ->where('services.business_id', $this->id)
     ->select('reservations.*'); // Avoid duplicate columns
}
}
