<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Order;
class User extends Authenticatable implements JWTSubject
{
    //use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    use SoftDeletes;
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'phone_number', 'role', 'user_id', 'status', 'username',
        'city', 'pin', 'last_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['created_at', 'modified_at'];
    

    // public function address(){
    //   return $this->hasMany('App\Model\UserAddress', 'user_id', 'id');
    // }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function users()
    {
        return $this->hasMany('App\User', 'user_id', 'id');
    }

   
}
