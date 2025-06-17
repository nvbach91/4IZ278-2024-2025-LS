<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $casts = [
        'is_admin' => 'bool',
    ];

    protected $fillable = [
        'id',
        'name',
        'email',
        'password_hash',
        'is_admin',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function business_managers()
    {
        return $this->hasMany(BusinessManager::class, 'user_id', 'id');
    }

    public function hasRoleAtBusiness(Business|int $business, array $roles): bool
    {
        $businessId = $business instanceof Business ? $business->id : $business;

        return $this->business_managers()
                    ->where('business_id', $businessId)
                    ->whereIn('permission_level', $roles)
                    ->exists();
    }
    
    public function ownedBusiness()
    {
        $manager = $this->business_managers()
            ->where('permission_level', 'owner')
            ->first();

        return $manager?->business;
    }

    public function ownedBusinesses()
    {
        return Business::whereHas('business_managers', function($q) {
            $q->where('user_id', $this->id)
              ->where('permission_level', 'owner');
        })->get();
    }

    public function managedBusinesses()
    {
        return Business::whereHas('business_managers', function($q) {
            $q->where('user_id', $this->id)
              ->where('permission_level', 'manager');
        })->get();
    }

    public function isOwnerOf(Business|int $business): bool
    {
        $businessId = $business instanceof Business ? $business->id : $business;
        return $this->business_managers()
                    ->where('business_id', $businessId)
                    ->where('permission_level', 'owner')
                    ->exists();
    }

    public function isManagerOf(Business|int $business): bool
    {
        $businessId = $business instanceof Business ? $business->id : $business;
        return $this->business_managers()
                    ->where('business_id', $businessId)
                    ->where('permission_level', 'manager')
                    ->exists();
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
