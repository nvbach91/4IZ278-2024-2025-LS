<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BusinessManager
 * 
 * @property int $id
 * @property int|null $business_id
 * @property string|null $user_id
 * @property string $permission_level
 * 
 * @property Business|null $business
 * @property User|null $user
 *
 * @package App\Models
 */
class BusinessManager extends Model
{
	protected $table = 'business_managers';
	public $timestamps = false;

	protected $casts = [
		'business_id' => 'int',
		
	];

	protected $fillable = [
		'business_id',
		'user_id',
		'permission_level'
	];

	public function business()
	{
		return $this->belongsTo(Business::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public static function availableRoles(): array
	{
		return [
			// changing to owner is disabled due to not defined logic with multiple owners
			//'owner' => 'Vlastník',
			'manager' => 'Manažer',
			'worker' => 'Personál',
		];
	}



}
