<?php

namespace App\Models;

use DB;
use Auth;
use Response;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class TikTokDaily extends Authenticatable
{
    use Notifiable;
	protected $connection = 'mysql';
    protected $table = 'tbl_user_daily';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

}
