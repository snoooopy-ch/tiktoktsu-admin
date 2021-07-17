<?php

namespace App\Models;

use DB;
use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;
	protected $connection = 'mysql';
    protected $table = 'tbl_user';
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

    public function getRecordByUser($user_login) {
        $records = DB::connection($this->connection)
            ->table($this->table)
            ->where('user_login', $user_login)
            ->select('*')
            ->get();
        
        if (!isset($records) || count($records) == 0) {
            return -1;
        }

        return $records[0]->id;
    }

    public function getRecordInfoById($id) {
        $records = DB::connection($this->connection)
            ->table($this->table)
            ->where('id', $id)
            ->select('*')
            ->get();
        
        return $records[0];
    }

    public function getRecordInfoByUserLogin($user_login) {
        $records = DB::connection($this->connection)
            ->table($this->table)
            ->where('user_login', $user_login)
            ->select('*')
            ->get();
        
        return $records[0];
    }

    public function deleteRecord($id) {
        $records = DB::connection($this->connection)
            ->table($this->table)
            ->where('id', $id)
            ->delete();
        
        return [
            'error' => 0,
            'detail' => null,
        ];
    }

    public function deleteRecords($selected) {
        $records = DB::connection($this->connection)
            ->table($this->table)
            ->whereIn('id', $selected)
            ->delete();
        
        return [
            'error' => 0,
            'detail' => null,
        ];
    }

    

    public function updateRecordById($id, $info) {
        $result = DB::connection($this->connection)
            ->table($this->table)
            ->where('id', $id)
            ->update($info);

        return $result;
    }

    public function insertRecord($user_login, $info) {
        $id = $this->getRecordByUser($user_login);
        if ($id == -1) {
            $ret = DB::connection($this->connection)
                ->table($this->table)
                ->insert($info);

            return $ret;
        }

        return $this->updateRecordById($id, $info);
    }

    public function getAllUsers() {
        $records = DB::connection($this->connection)
            ->table($this->table)
            ->select('*')
            ->get();

        $result = array();
        foreach ($records as $record) {
            $result[] = $record->user_login;
        }
        
        return $result;
    }

    public function getAllForDatatable($params) {
        $selector = DB::table($this->table);

        // filtering
        $totalCount = $selector->count();

        if (isset($params['columns'][2]['search']['value'])
            && $params['columns'][2]['search']['value'] !== ''
        ) {
            $selector->where('user_login', 'like', '%' . $params['columns'][2]['search']['value'] . '%');
        }
        if (isset($params['columns'][4]['search']['value'])
            && $params['columns'][4]['search']['value'] !== ''
        ) {
            $selector->where('user_name', 'like', '%' . $params['columns'][4]['search']['value'] . '%');
        }

        $selector->select($this->table . '.*');

        // number of filtered records
        $recordsFiltered = $selector->count();

        // sort
        foreach ($params['order'] as $order) {
            $field = $params['columns'][$order['column']]['data'];
            $selector->orderBy($field, $order['dir']);
        }

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

}
