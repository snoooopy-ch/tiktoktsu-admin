<?php

namespace App\Models;

use DB;
use Auth;
use Response;
use App\Models\Customer;
use App\Models\Good;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Order extends Authenticatable
{
    use Notifiable;
	protected $connection = 'mysql';
    protected $table = 'tbl_order';
    protected $customerTable = 'tbl_user';
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

    public function getRecordByGoodCode($good_code) {
        $records = DB::connection($this->connection)
            ->table($this->table)
            ->where('good_code', $good_code)
            ->select('*')
            ->get();
        
        if (!isset($records) || count($records) == 0) {
            return -1;
        }

        return $records[0]->id;
    }

    public function insertRecord($info) {
        $ret = DB::connection($this->connection)
            ->table($this->table)
            ->insert($info);

        return $ret;
    }

    public function getRecordInfoById($id) {
        $records = DB::connection($this->connection)
            ->table($this->table)
            ->where('id', $id)
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

    public function updateRecordPrice($good) {
        $result = DB::connection($this->connection)
            ->table($this->table)
            ->where([
                ['order_price', '=', '0'],
                ['good_code', 'like', $good[0]],
            ])
            ->update([
                'order_price'   => $good[2],
                'good_seller'   => $good[3]
            ]);

        return $result;
    }

    public function getAllForDatatable($params) {
        $selector = DB::table($this->table);

        // filtering
        $totalCount = $selector->count();

        if (isset($params['columns'][3]['search']['value'])
            && $params['columns'][3]['search']['value'] !== ''
        ) {
            $selector->where('good_code', 'like', '%' . $params['columns'][3]['search']['value'] . '%');
        }
        if (isset($params['columns'][2]['search']['value'])
            && $params['columns'][2]['search']['value'] !== ''
        ) {
            $amountRange = preg_replace('/[\$\,]/', '', $params['columns'][2]['search']['value']);
            $elements = explode(':', $amountRange);

            if ($elements[0] != "" || $elements[1] != "") {
                $elements[0] .= ' 00:00:00';
                $elements[1] .= ' 23:59:59';
                $selector->whereBetween($this->table . '.order_date', $elements);
            }
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

    public function getAllSalesForDatatable($params) {
        
        $selector = DB::table($this->customerTable)
            ->leftJoin($this->table, function($join) {
                $join->where(DB::raw('STRCMP(tbl_user.user_login, tbl_order.good_seller)'), '=', 0);
            })
            ->leftJoin('tbl_good', 'tbl_good.good_code', '=', 'tbl_order.good_code')
            ->select('*');
        
        if (isset($params['columns'][2]['search']['value']) && $params['columns'][2]['search']['value'] !== '') {
            $amountRange = preg_replace('/[\$\,]/', '', $params['columns'][2]['search']['value']);
            $elements = explode(':', $amountRange);

            if ($elements[0] != "" || $elements[1] != "") {
                $elements[0] .= ' 00:00:00';
                $elements[1] .= ' 23:59:59';
                $selector->whereBetween($this->table . '.order_date', $elements);
            }
        } else {
            $elements = array();
            $elements[0] = date('Y-m-01', strtotime(date('Y-m')." -1 month")) . ' 00:00:00';
            $elements[1] = date('Y-m-t', strtotime(date('Y-m')." -1 month")) . ' 23:59:59';
            $selector->whereBetween($this->table . '.order_date', $elements);
        }

        if (isset($params['columns'][11]['search']['value'])
            && $params['columns'][11]['search']['value'] !== ''
        ) {
            $selector->where('tbl_user.user_login', 'like', '%' . $params['columns'][11]['search']['value'] . '%');
        }
        
        
        // filtering
        $totalCount = $selector->count();

        $selector->select($this->table . '.order_date',
            $this->customerTable . '.user_login', 
            $this->customerTable . '.user_name', 
            $this->customerTable . '.user_number',
            $this->customerTable . '.bank_number',
            $this->customerTable . '.shop_number',
            $this->customerTable . '.deposit_kind',
            $this->customerTable . '.account_number',
            $this->customerTable . '.account_name',
            $this->table . '.order_count',
            'tbl_good.good_name',
            $this->table . '.order_price',
        );

        // number of filtered records
        $recordsFiltered = $selector->count();

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

    public function csvdownload($params) {
        $selector = DB::table($this->customerTable)
            ->leftJoin($this->table, function($join) {
                $join->where(DB::raw('STRCMP(tbl_user.user_login, tbl_order.good_seller)'), '=', 0);
            })
            ->leftJoin('tbl_good', 'tbl_good.good_code', 'like', 'tbl_order.good_code')
            ->select('*');

        if (isset($params['orderDates']) && $params['orderDates'] !== '') {
            $amountRange = preg_replace('/[\$\,]/', '', $params['orderDates']);
            $elements = explode(':', $amountRange);

            if ($elements[0] != "" || $elements[1] != "") {
                $elements[0] .= ' 00:00:00';
                $elements[1] .= ' 23:59:59';
                $selector->whereBetween($this->table . '.order_date', $elements);
            }
        } else {
            $elements = array();
            $elements[0] = date('Y-m-01', strtotime(date('Y-m')." -1 month")) . ' 00:00:00';
            $elements[1] = date('Y-m-t', strtotime(date('Y-m')." -1 month")) . ' 23:59:59';
            $selector->whereBetween($this->table . '.order_date', $elements);
        }

        $selector->groupBy('tbl_user.user_login')
            ->select([
                DB::raw('sum(tbl_order.order_count * tbl_order.order_price) as order_price, 
                tbl_order.order_date as order_date,
                tbl_user.user_login as user_login, 
                tbl_user.user_name as user_name, 
                tbl_user.user_number as user_number,
                tbl_user.bank_number as bank_number,
                tbl_user.shop_number as shop_number,
                tbl_user.deposit_kind as deposit_kind,
                tbl_user.account_number as account_number,
                tbl_user.account_name as account_name,
                tbl_good.good_name as good_name')
            ])
            ->pluck('order_price', 'tbl_user.user_login');

        $records = $selector->get();

        return $records;
    }

    public function getUserSales($params, $user_login) {
        $selector = DB::table($this->table)
            ->leftJoin('tbl_good', 'tbl_good.good_code', '=', 'tbl_order.good_code')
            ->where('tbl_order.good_seller', 'like', $user_login)
            ->select('*');
        
        if (isset($params['columns'][1]['search']['value']) && $params['columns'][1]['search']['value'] !== '') {
            $amountRange = preg_replace('/[\$\,]/', '', $params['columns'][1]['search']['value']);
            $elements = explode(':', $amountRange);

            if ($elements[0] != "" || $elements[1] != "") {
                $elements[0] .= ' 00:00:00';
                $elements[1] .= ' 23:59:59';
                $selector->whereBetween($this->table . '.order_date', $elements);
            }
        } else {
            $elements = array();
            $elements[0] = date('Y-m-01', strtotime(date('Y-m')." -1 month")) . ' 00:00:00';
            $elements[1] = date('Y-m-t', strtotime(date('Y-m')." -1 month")) . ' 23:59:59';
            $selector->whereBetween($this->table . '.order_date', $elements);
        }

        $selector->select(DB::raw('SUM(tbl_order.order_price * tbl_order.order_count) as price'));
        $sum = $selector->get();
        


        if (isset($params['columns'][2]['search']['value'])
            && $params['columns'][2]['search']['value'] !== ''
        ) {
            $selector->where('tbl_order.good_code', 'like', '%' . $params['columns'][2]['search']['value'] . '%');
        }

        if (isset($params['columns'][3]['search']['value'])
            && $params['columns'][3]['search']['value'] !== ''
        ) {
            $selector->where('tbl_good.good_name', 'like', '%' . $params['columns'][3]['search']['value'] . '%');
        }
        
        // filtering
        $totalCount = $selector->count();

        $selector->select($this->table . '.order_date',
            $this->table . '.good_code', 
            'tbl_good.good_name', 
            $this->table . '.order_price',
            $this->table . '.order_count',
        );

        // number of filtered records
        $recordsFiltered = $selector->count();

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
            'price' => $sum[0]->price,
        ];
    }
}
