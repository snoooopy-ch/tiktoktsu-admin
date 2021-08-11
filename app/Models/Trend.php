<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trend extends Model
{
    use HasFactory;
    protected $table = 'tbl_trending';

    public static function getAllForDatatable($params) {
        $table = 'tbl_trending';

        $selector = DB::table($table)
            ->select('*')
            ->orderBy('created_at', 'desc')
            ->take(20);

        // filtering
        $totalCount = $selector->get()->count();

        // number of filtered records
        $recordsFiltered = $selector->get()->count();

        // offset & limit
        if (!empty($params['start']) && $params['start'] > 0) {
            $selector->skip($params['start']);
        }

        if (!empty($params['length']) && $params['length'] > 0) {
            $selector->take($params['length']);
        }

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
