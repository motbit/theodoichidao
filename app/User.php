<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function validate($input) {

        $rules = array(
            'username' => 'Required|Min:6|Max:80|Alpha|Unique:user',
            'fullname'     => 'Required|Between:3,64',
            'password'  =>'Required|AlphaNum|Between:4,8'
        );

        return Validator::make($input, $rules);
    }
}
