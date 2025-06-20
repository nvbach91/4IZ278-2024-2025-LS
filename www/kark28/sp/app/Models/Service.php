<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * 
 * @property int $id
 * @property int|null $business_id
 * @property string $name
 * @property string|null $description
 * @property int $duration_minutes
 * @property float|null $price
 * 
 * @property Business|null $business
 * @property Collection|Timeslot[] $timeslots
 *
 * @package App\Models
 */
class Service extends Model
{
	protected $table = 'services';
	public $timestamps = false;

	protected $casts = [
		'business_id' => 'int',
		'duration_minutes' => 'int',
		'price' => 'float'
	];

	protected $fillable = [
		'business_id',
		'name',
		'description',
		'duration_minutes',
		'price'
	];

	public function business()
	{
		return $this->belongsTo(Business::class);
	}

	public function timeslots()
	{
		return $this->hasMany(Timeslot::class);
	}
}
