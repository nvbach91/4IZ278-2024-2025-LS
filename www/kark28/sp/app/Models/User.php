<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

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
        return $this->hasMany(BusinessManager::class, 'user_id', 'id');
    }

    public function ownedBusiness()
    {
        $manager = $this->business_managers()
            ->where('permission_level', 'owner')
            ->first();

        return $manager?->business;
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
