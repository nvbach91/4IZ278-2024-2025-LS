<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reservation
 * 
 * @property int $id
 * @property string|null $user_id
 * @property int|null $timeslot_id
 * @property string|null $status
 * @property Carbon|null $created_at
 * 
 * @property User|null $user
 * @property Timeslot|null $timeslot
 *
 * @package App\Models
 */
class Reservation extends Model
{
	protected $table = 'reservations';
	public $timestamps = false;

	protected $casts = [
		'timeslot_id' => 'int',
		'created_at' => 'datetime'

	];

	protected $fillable = [
		'user_id',
		'timeslot_id',
		'status'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function timeslot()
	{
		return $this->belongsTo(Timeslot::class);
	}
}
