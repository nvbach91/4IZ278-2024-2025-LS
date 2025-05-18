<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Timeslot
 * 
 * @property int $id
 * @property int|null $service_id
 * @property string|null $provider_id
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property bool|null $available
 * 
 * @property Service|null $service
 * @property User|null $user
 * @property Collection|Reservation[] $reservations
 *
 * @package App\Models
 */
class Timeslot extends Model
{
	protected $table = 'timeslots';
	public $timestamps = false;

	protected $casts = [
		'service_id' => 'int',
		'start_time' => 'datetime',
		'end_time' => 'datetime',
		'available' => 'bool'
	];

	protected $fillable = [
		'service_id',
		'provider_id',
		'start_time',
		'end_time',
		'available'
	];

	public function service()
	{
		return $this->belongsTo(Service::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'provider_id');
	}

	public function reservations()
	{
		return $this->hasMany(Reservation::class);
	}
}
