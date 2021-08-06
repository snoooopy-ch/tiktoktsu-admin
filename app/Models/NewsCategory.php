<?php

namespace App\Models;

use DB;
use Auth;
use Response;
use App\Models\Customer;
use App\Models\Good;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class NewsCategory extends Model
{
    use Notifiable;
    protected $table = 'tbl_news_category';
    protected $newsTable = 'tbl_news';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function getAllForDatatable($params) {
        $selector = DB::table($this->table)
            ->leftJoin($this->newsTable, $this->table . '.id', '=', $this->newsTable . '.category')
            ->groupBy($this->table . '.id')
            ->select(
                $this->table . '.*',
                DB::raw('count(tbl_news.id) as count')
            );

        // filtering
        $totalCount = $selector->get()->count();
        $selector->orderBy('created_at', 'desc');

        // number of filtered records
        $recordsFiltered = $selector->get()->count();

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

    public function deleteRecord($id) {
        $records = DB::table($this->table)
            ->where('id', $id)
            ->delete();
        
        return [
            'error' => 0,
            'detail' => null,
        ];
    }

    public function getUsers() {
        $records = DB::table($this->table)
            ->select('*')
            ->get();
        if (!isset($records) || count($records) == 0) {
            return [];
        }

        return $records;
    }

}
