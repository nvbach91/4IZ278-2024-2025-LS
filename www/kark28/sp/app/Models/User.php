<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property string $role
 * @property bool|null $is_admin
 * 
 * @property Collection|BusinessManager[] $business_managers
 * @property Collection|Reservation[] $reservations
 * @property Collection|Review[] $reviews
 * @property Collection|Timeslot[] $timeslots
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'is_admin' => 'bool'
	];

	protected $fillable = [
		'name',
		'email',
		'password_hash',
		'is_admin'
	];

	public function business_managers()
	{
		return $this->hasMany(BusinessManager::class);
	}

	public function reservations()
	{
		return $this->hasMany(Reservation::class);
	}

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}

	public function timeslots()
	{
		return $this->hasMany(Timeslot::class, 'provider_id');
	}
}
