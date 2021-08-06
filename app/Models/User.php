<?php

namespace App\Models;

use DB;
use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
	protected $table = 'tbl_admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_login', 'password'
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
    ];


    public function getForDatatable($params) {
        $selector = DB::table($this->table)
            ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', $this->table . '.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->groupBy($this->table . '.id');

        // filtering
        $totalCount = $selector->count();

        $selector->select(DB::raw($this->table . '.*, group_concat(roles.name) as role'));

        // number of filtered records
        $recordsFiltered = $selector->count();

        // offset & limit
        if (!empty($params['start']) && $params['start'] > 0) {
            $selector->skip($params['start']);
        }

        if (!empty($params['length']) && $params['length'] > 0) {
            $selector->take($params['length']);
        }

        // get records
        $records = $selector->get();

        return [
            'draw' => $params['draw']+0,
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $recordsFiltered,
            'data' => $records,
            'error' => 0,
        ];
    }

    public function createRecord($params) {
        $id = DB::table($this->table)
            ->insertGetId([
                'user_login'    => $params['user_login'],
                'password'      => $params['password']
            ]);

        if (isset($params['customCheck']) && !empty($params['customCheck'])) {
            foreach ($params['customCheck'] as $role) {
                $user = User::findOrFail($id);
                $user->assignRole($role);
            }
        }
        return;
    }

    public function deleteRecordById($id) {
        $records = DB::connection($this->connection)
            ->table($this->table)
            ->where('id', $id)
            ->delete();
        
        return [
            'error' => 0,
            'detail' => null,
        ];
    }

}
