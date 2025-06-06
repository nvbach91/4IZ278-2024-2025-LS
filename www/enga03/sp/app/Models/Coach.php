<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coach extends Authenticatable
{
    use HasFactory, Notifiable;

    /** Tabulka je už v dumpu */
    protected $table = 'z_coaches';

    protected $fillable = ['name','email','password',
                           'oauth_provider','profile_picture'];

    protected $hidden   = ['password','remember_token'];

    public function courses()
    {
        return $this->hasMany(
            Course::class,    // cílový model
            'coach_id',       // sloupec v z_courses
            'id'              // primární klíč
        );
    }
}
