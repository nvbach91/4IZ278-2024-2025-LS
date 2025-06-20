<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * 
 * @property string $user_id
 * @property int $business_id
 * @property int $rating
 * @property string|null $comment
 * @property Carbon|null $created_at
 * 
 * @property User $user
 * @property Business $business
 *
 * @package App\Models
 */
class Review extends Model
{
	protected $table = 'reviews';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'business_id' => 'int',
		'rating' => 'int'
	];

	protected $fillable = [
		'user_id',
		'business_id',
		'rating',
		'comment',
	];


	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function business()
	{
		return $this->belongsTo(Business::class);
	}
}
