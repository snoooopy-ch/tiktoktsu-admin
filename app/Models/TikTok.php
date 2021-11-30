<?php

namespace App\Models;

use DB;
use Auth;
use Response;
use App\Models\Customer;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Litipk\BigNumbers\Decimal;

class TikTok extends Authenticatable
{
    use Notifiable;
	protected $connection = 'mysql';
    protected $table = 'tbl_user';
    protected $dailyTable = 'tbl_user_daily';
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

    // In both of front and admin page, this is called.
    public function getAllForDatatable($params) {
        $selector = DB::table($this->dailyTable)
            ->leftJoin($this->table, $this->table . '.id', '=', $this->dailyTable . '.user_id')
            ->groupBy($this->table . '.id')
            ->whereNotNull($this->table . '.uniqueId')
            ->select(
                $this->table . '.*',
                DB::raw('sum(tbl_user_daily.follercount_grow) as follercount_grow'),
                DB::raw('sum(tbl_user_daily.followingcount_grow) as followingcount_grow'),
                DB::raw('sum(tbl_user_daily.diggcount_grow) as diggcount_grow'),
                DB::raw('sum(tbl_user_daily.heart_grow) as heart_grow'),
                DB::raw('sum(tbl_user_daily.videocount_grow) as videocount_grow'),
                DB::raw('tbl_user_daily.created_at as period')
            );

        if (isset($params['columns'][2]['search']['value']) && $params['columns'][2]['search']['value'] !== '' ) {
            $selector->where('tbl_user.uniqueId', 'like', '%' . $params['columns'][2]['search']['value'] . '%');
        }

        if (isset($params['columns'][10]['search']['value']) && $params['columns'][10]['search']['value'] !== '' ) {
            $selector->where('tbl_user.status', $params['columns'][10]['search']['value']);
        }

        if (isset($params['status']) && $params['status'] != null && $params['status'] != '') {
            $selector->where('tbl_user.status', $params['status']);
        }

        if (isset($params['user']) && $params['user'] != null && $params['user'] != '') {
            $selector->where('tbl_user.uniqueId', 'like', '%' . $params['user'] . '%');
        }

        if (isset($params['category']) && $params['category'] != null && $params['category'] != '') {
            $selector->where('tbl_user.category', $params['category']);
        }

        // filtering
        $totalCount = $selector->get()->count();

        $key = '';
        if (isset($params['key']) && $params['key'] !== null && $params['key'] !== '') {
            switch ($params['key']) {
                case 'follower':
                    $key = 'follercount';
                    if (isset($params['period']) && $params['period'] !== null && $params['period'] !== '') {
                        $key = 'follercount_grow';
                    }
                break;
                case 'heart':
                    $key = 'heart';
                    if (isset($params['period']) && $params['period'] !== null && $params['period'] !== '') {
                        $key = 'heart_grow';
                    }
                break;
                case 'music':
                    $key = 'videocount';
                    if (isset($params['period']) && $params['period'] !== null && $params['period'] !== '') {
                        $key = 'videocount_grow';
                    }
                break;
            }
        }

        $period = '';
        if (isset($params['period'])
            && $params['period'] !== null && $params['period'] !== '') {
            $period = $params['period'];
            $first = '';
            $last = '';
            if ($period === 'week') {
                $first = date('Y-m-d', strtotime('last Sunday'));
                $last = date('Y-m-d', strtotime('next Saturday'));
            } else if($period === 'month') {
                $first = date('Y-m-01', strtotime('now'));
                $last = date('Y-m-t', strtotime('now'));
            }
            $selector->whereBetween($this->dailyTable . '.created_at', [$first, $last]);
        }
        
        if ($key !== ''){
            $selector->orderBy($key, 'desc');
        } else {
            if (isset($params['order']) && $params['order'] != null && $params['order'] != '') {
                
            }
            else {
                $selector->orderBy('tbl_user.follercount', 'desc');
            }
        }

        if (isset($params['order']) && $params['order'] != null && $params['order'] != '') {
            $selector->orderBy($params['order'], 'desc');
        }

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
        foreach($records as $index => $record) {
            if (isset($params['period']) && $params['period'] !== null && $params['period'] !== '') {
                $records[$index]->grow = $records[$index]->{$key};
            } else {
                $records[$index]->grow = 0;
            }
        }

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
    
    public function getUserInfoById($id) {
        $records = DB::table($this->table)
            ->where('id', $id)
            ->select('*')
            ->get();
        if (!isset($records) || count($records) == 0) {
            return null;
        }
        
        return $records[0];
    }

    public static function trends($id, $start, $end) {
        $records = DB::table('tbl_user_daily')
            ->where('user_id', $id)
            ->whereBetween('tbl_user_daily.created_at', [$start, $end])
            ->groupBy('day')
            ->select(
                DB::raw('sum(follercount_grow) as foller'),
                DB::raw('sum(heart_grow) as heart'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as day")
            )
            ->orderBy('created_at', 'asc')
            ->take(30)
            ->get();
        
        if (!isset($records) || $records === null ||count($records) === 0) {
            return [];
        }

        return $records;
    }

    public static function getSurge($start, $end) {
        $recentCount = Setting::where('name', 'recent_count')->first();
        
        $records = DB::table('tbl_user')
            ->leftJoin('tbl_user_daily', 'tbl_user.id', '=', 'tbl_user_daily.user_id')
            ->whereBetween('tbl_user_daily.created_at', [$start, $end])
            ->where('tbl_user.status', 1)
            ->groupBy('tbl_user.id')
            ->select(
                'tbl_user.*',
                DB::raw('sum(tbl_user_daily.follercount_grow) as follercount_grow'),
            )
            ->orderBy('follercount_grow', 'desc')
            ->take($recentCount->value)
            ->get();

        if (!isset($records) || count($records) == 0) {
            return [];
        }

        foreach ($records as $index => $record) {
            if ($record->heart == 0) {
                $records[$index]->rate_up = '0';
            } else {
                $records[$index]->rate_up = Decimal::create($record->follercount_grow)->div(Decimal::create($record->heart))->mul(Decimal::create(100))->__toString();
            }
            
        }

        return $records;
    }

    public function getHistoryForDatatable($params) {
        $selector = DB::table($this->table)
            ->leftJoin($this->dailyTable, $this->table . '.id', '=', $this->dailyTable . '.user_id')
            ->where($this->table . '.id', $params['id'])
            ->whereBetween($this->dailyTable . '.created_at', $params['period'])
            ->groupBy(
                DB::raw('Year(tbl_user_daily.created_at), Month(tbl_user_daily.created_at), Day(tbl_user_daily.created_at)')
            )
            ->select(
                $this->table . '.*',
                DB::raw("DATE_FORMAT(tbl_user_daily.created_at, '%Y-%m-%d') as date"),
                DB::raw('sum(tbl_user_daily.follercount_grow) as follercount_grow'),
                DB::raw('sum(tbl_user_daily.heart_grow) as heart_grow'),
                DB::raw('sum(tbl_user_daily.videocount_grow) as videocount_grow'),
            );

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

        $week = array('日', '月', '火', '水', '木', '金', '土');
        foreach ($records as $index => $record) {
            $date = date('Y-m-d', strtotime($records[$index]->date));
            $w = date('w', strtotime($records[$index]->date));
            $records[$index]->date = $date . ' （' . $week[$w] . '）';
        }

        return [
            'draw' => $params['draw']+0,
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $recordsFiltered,
            'data' => $records,
            'error' => 0,
        ];
    }























    // public function getRecordByGoodCode($good_code) {
    //     $records = DB::connection($this->connection)
    //         ->table($this->table)
    //         ->where('good_code', $good_code)
    //         ->select('*')
    //         ->get();
        
    //     if (!isset($records) || count($records) == 0) {
    //         return -1;
    //     }

    //     return $records[0]->id;
    // }

    // public function insertRecord($info) {
    //     $ret = DB::connection($this->connection)
    //         ->table($this->table)
    //         ->insert($info);

    //     return $ret;
    // }

    

    

    // public function deleteRecords($selected) {
    //     $records = DB::connection($this->connection)
    //         ->table($this->table)
    //         ->whereIn('id', $selected)
    //         ->delete();
        
    //     return [
    //         'error' => 0,
    //         'detail' => null,
    //     ];
    // }

    // public function updateRecordById($id, $info) {
    //     $result = DB::connection($this->connection)
    //         ->table($this->table)
    //         ->where('id', $id)
    //         ->update($info);

    //     return $result;
    // }

    // public function updateRecordPrice($good) {
    //     $result = DB::connection($this->connection)
    //         ->table($this->table)
    //         ->where([
    //             ['order_price', '=', '0'],
    //             ['good_code', 'like', $good[0]],
    //         ])
    //         ->update([
    //             'order_price'   => $good[2],
    //             'good_seller'   => $good[3]
    //         ]);

    //     return $result;
    // }

    

    // public function getAllSalesForDatatable($params) {
        
    //     $selector = DB::table($this->customerTable)
    //         ->leftJoin($this->table, function($join) {
    //             $join->where(DB::raw('STRCMP(tbl_user.user_login, tbl_order.good_seller)'), '=', 0);
    //         })
    //         ->leftJoin('tbl_good', 'tbl_good.good_code', '=', 'tbl_order.good_code')
    //         ->select('*');
        
    //     if (isset($params['columns'][2]['search']['value']) && $params['columns'][2]['search']['value'] !== '') {
    //         $amountRange = preg_replace('/[\$\,]/', '', $params['columns'][2]['search']['value']);
    //         $elements = explode(':', $amountRange);

    //         if ($elements[0] != "" || $elements[1] != "") {
    //             $elements[0] .= ' 00:00:00';
    //             $elements[1] .= ' 23:59:59';
    //             $selector->whereBetween($this->table . '.order_date', $elements);
    //         }
    //     } else {
    //         $elements = array();
    //         $elements[0] = date('Y-m-01', strtotime(date('Y-m')." -1 month")) . ' 00:00:00';
    //         $elements[1] = date('Y-m-t', strtotime(date('Y-m')." -1 month")) . ' 23:59:59';
    //         $selector->whereBetween($this->table . '.order_date', $elements);
    //     }

    //     if (isset($params['columns'][11]['search']['value'])
    //         && $params['columns'][11]['search']['value'] !== ''
    //     ) {
    //         $selector->where('tbl_user.user_login', 'like', '%' . $params['columns'][11]['search']['value'] . '%');
    //     }
        
        
    //     // filtering
    //     $totalCount = $selector->count();

    //     $selector->select($this->table . '.order_date',
    //         $this->customerTable . '.user_login', 
    //         $this->customerTable . '.user_name', 
    //         $this->customerTable . '.user_number',
    //         $this->customerTable . '.bank_number',
    //         $this->customerTable . '.shop_number',
    //         $this->customerTable . '.deposit_kind',
    //         $this->customerTable . '.account_number',
    //         $this->customerTable . '.account_name',
    //         $this->table . '.order_count',
    //         'tbl_good.good_name',
    //         $this->table . '.order_price',
    //     );

    //     // number of filtered records
    //     $recordsFiltered = $selector->count();

    //     // offset & limit
    //     if (!empty($params['start']) && $params['start'] > 0) {
    //         $selector->skip($params['start']);
    //     }

    //     if (!empty($params['length']) && $params['length'] > 0) {
    //         $selector->take($params['length']);
    //     }

    //     $records = $selector->get();

    //     return [
    //         'draw' => $params['draw']+0,
    //         'recordsTotal' => $totalCount,
    //         'recordsFiltered' => $recordsFiltered,
    //         'data' => $records,
    //         'error' => 0,
    //     ];
    // }

    // public function csvdownload($params) {
    //     $selector = DB::table($this->customerTable)
    //         ->leftJoin($this->table, function($join) {
    //             $join->where(DB::raw('STRCMP(tbl_user.user_login, tbl_order.good_seller)'), '=', 0);
    //         })
    //         ->leftJoin('tbl_good', 'tbl_good.good_code', 'like', 'tbl_order.good_code')
    //         ->select('*');

    //     if (isset($params['orderDates']) && $params['orderDates'] !== '') {
    //         $amountRange = preg_replace('/[\$\,]/', '', $params['orderDates']);
    //         $elements = explode(':', $amountRange);

    //         if ($elements[0] != "" || $elements[1] != "") {
    //             $elements[0] .= ' 00:00:00';
    //             $elements[1] .= ' 23:59:59';
    //             $selector->whereBetween($this->table . '.order_date', $elements);
    //         }
    //     } else {
    //         $elements = array();
    //         $elements[0] = date('Y-m-01', strtotime(date('Y-m')." -1 month")) . ' 00:00:00';
    //         $elements[1] = date('Y-m-t', strtotime(date('Y-m')." -1 month")) . ' 23:59:59';
    //         $selector->whereBetween($this->table . '.order_date', $elements);
    //     }

    //     $selector->groupBy('tbl_user.user_login')
    //         ->select([
    //             DB::raw('sum(tbl_order.order_count * tbl_order.order_price) as order_price, 
    //             tbl_order.order_date as order_date,
    //             tbl_user.user_login as user_login, 
    //             tbl_user.user_name as user_name, 
    //             tbl_user.user_number as user_number,
    //             tbl_user.bank_number as bank_number,
    //             tbl_user.shop_number as shop_number,
    //             tbl_user.deposit_kind as deposit_kind,
    //             tbl_user.account_number as account_number,
    //             tbl_user.account_name as account_name,
    //             tbl_good.good_name as good_name')
    //         ])
    //         ->pluck('order_price', 'tbl_user.user_login');

    //     $records = $selector->get();

    //     return $records;
    // }

    // public function getUserSales($params, $user_login) {
    //     $selector = DB::table($this->table)
    //         ->leftJoin('tbl_good', 'tbl_good.good_code', '=', 'tbl_order.good_code')
    //         ->where('tbl_order.good_seller', 'like', $user_login)
    //         ->select('*');
        
    //     if (isset($params['columns'][1]['search']['value']) && $params['columns'][1]['search']['value'] !== '') {
    //         $amountRange = preg_replace('/[\$\,]/', '', $params['columns'][1]['search']['value']);
    //         $elements = explode(':', $amountRange);

    //         if ($elements[0] != "" || $elements[1] != "") {
    //             $elements[0] .= ' 00:00:00';
    //             $elements[1] .= ' 23:59:59';
    //             $selector->whereBetween($this->table . '.order_date', $elements);
    //         }
    //     } else {
    //         $elements = array();
    //         $elements[0] = date('Y-m-01', strtotime(date('Y-m')." -1 month")) . ' 00:00:00';
    //         $elements[1] = date('Y-m-t', strtotime(date('Y-m')." -1 month")) . ' 23:59:59';
    //         $selector->whereBetween($this->table . '.order_date', $elements);
    //     }

    //     $selector->select(DB::raw('SUM(tbl_order.order_price * tbl_order.order_count) as price'));
    //     $sum = $selector->get();
        


    //     if (isset($params['columns'][2]['search']['value'])
    //         && $params['columns'][2]['search']['value'] !== ''
    //     ) {
    //         $selector->where('tbl_order.good_code', 'like', '%' . $params['columns'][2]['search']['value'] . '%');
    //     }

    //     if (isset($params['columns'][3]['search']['value'])
    //         && $params['columns'][3]['search']['value'] !== ''
    //     ) {
    //         $selector->where('tbl_good.good_name', 'like', '%' . $params['columns'][3]['search']['value'] . '%');
    //     }
        
    //     // filtering
    //     $totalCount = $selector->count();

    //     $selector->select($this->table . '.order_date',
    //         $this->table . '.good_code', 
    //         'tbl_good.good_name', 
    //         $this->table . '.order_price',
    //         $this->table . '.order_count',
    //     );

    //     // number of filtered records
    //     $recordsFiltered = $selector->count();

    //     // offset & limit
    //     if (!empty($params['start']) && $params['start'] > 0) {
    //         $selector->skip($params['start']);
    //     }

    //     if (!empty($params['length']) && $params['length'] > 0) {
    //         $selector->take($params['length']);
    //     }

    //     $records = $selector->get();

    //     return [
    //         'draw' => $params['draw']+0,
    //         'recordsTotal' => $totalCount,
    //         'recordsFiltered' => $recordsFiltered,
    //         'data' => $records,
    //         'error' => 0,
    //         'price' => $sum[0]->price,
    //     ];
    // }
}
