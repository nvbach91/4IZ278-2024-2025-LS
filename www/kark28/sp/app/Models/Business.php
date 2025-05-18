<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
}
