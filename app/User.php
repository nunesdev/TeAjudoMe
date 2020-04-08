<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','phone','whatsapp','password','slug','city_id','address','lat','lng','image','type','options','status','campaign'
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

    public static function nearby($options){
    	$query = "SELECT
					ROUND(
						6371.0 * ACOS(
							SIN( ".$options['lat']."*PI()/180 ) * SIN( u.lat*PI()/180 )
							+ COS( ".$options['lat']."*PI()/180 ) * COS( u.lat*PI()/180 )  *  COS( (u.lng*PI()/180) - (".$options['lng']."*PI()/180) )   )
					, 1)
					AS distance,
					u.*
				FROM
					users u";

     $query .= " WHERE u.status = 'a'";

     if(isset($options['campaign']))
      $query .= " AND u.campaign = '{$options['campaign']}'";

      $query .=	" HAVING
					distance < ".$options['distance']."
				ORDER BY
					distance ASC
				LIMIT 0, ".$options['limit'];
  
    	$users = DB::select($query);

    	return $users;
    }
}
