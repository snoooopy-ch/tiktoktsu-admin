<?php

namespace App\Models;

use DB;
use Auth;
use Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class News extends Model
{
    use HasFactory;
    use Notifiable;
	protected $connection = 'mysql';
    protected $table = 'tbl_news';
    protected $categoryTable = 'tbl_news_category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function getAllForDatatable($params) {
        $selector = DB::table($this->table);

        // filtering
        $totalCount = $selector->count();

        if (isset($params['columns'][1]['search']['value'])
            && $params['columns'][1]['search']['value'] !== ''
        ) {
            $selector->where('title', 'like', '%' . $params['columns'][1]['search']['value'] . '%');
        }
        if (isset($params['columns'][3]['search']['value'])
            && $params['columns'][3]['search']['value'] !== ''
        ) {
            $amountRange = preg_replace('/[\$\,]/', '', $params['columns'][3]['search']['value']);
            $elements = explode(':', $amountRange);

            if ($elements[0] != "" || $elements[1] != "") {
                $elements[0] .= ' 00:00:00';
                $elements[1] .= ' 23:59:59';
                $selector->whereBetween($this->table . '.created_at', $elements);
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

    public function deleteRecord($id) {
        $records = DB::table($this->table)
            ->where('id', $id)
            ->delete();
        
        return [
            'error' => 0,
            'detail' => null,
        ];
    }

    public function insertNews($params) {
        $ret = DB::table($this->table)
            ->insert($params);

        return $ret;
    }

    public function famouseNews() {
        $records = DB::table($this->table)
            ->orderBy('read', 'desc')
            ->take(5)
            ->get();
        
        if (!isset($records) || count($records) == 0) {
            return [];
        }
    
        foreach($records  as $index => $item) {
            preg_match('/(<)([img])(\w+)([^>]*>)/', $item->content, $match);
            if (count($match) != 0) {
                $image = $match[0];
                $array = array();
                preg_match('/<img[^>]* src=\"([^\"]*)\"[^>]*>/', $image, $array );
                $item->thumb = $array[1];
            }
            else {
                $item->thumb = '';
            } 

            $item->content = preg_replace('/(<)([img])(\w+)([^>]*>)/', '', $item->content); 
            preg_match('/^(.*)$/m', $item->content, $match);
            $item->content = $match[0];

            preg_match('/^(.*)$/m', $item->title, $match);
            $item->title = $match[0];
        }

        return $records;
    }

    public function increaseReadAndGet($id) {
        DB::table($this->table)
            ->where('id', $id)
            ->increment('read', 1);
        $records = DB::table($this->table)
            ->leftJoin($this->categoryTable, $this->table . '.category', '=', $this->categoryTable . '.id')
            ->where($this->table . '.id', $id)
            ->select(
                $this->table . '.id',
                $this->table . '.title',
                $this->table . '.content',
                $this->table . '.created_at',
                $this->table . '.updated_at',
                $this->categoryTable . '.category as category')
            ->get();

        if (!isset($records) || count($records) == 0)
            return [];
        
        return $records[0];
    }

    
}
