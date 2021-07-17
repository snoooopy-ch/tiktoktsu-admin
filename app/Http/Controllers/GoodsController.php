<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\Order;

class GoodsController extends Controller
{
    function index() {
        return view('goods');
    }

    function register() {
        return view('goods-register');
    }

    function addGoods( Request $request) {
        $goodModel = new Good();
        $orderModel = new Order();

        $content = $request->get('content');
        $goods = explode('||', $content);

        foreach($goods as $index => $tmp) {
            $good = explode(',', $tmp);

            if ($index == 0) continue;
            if (count($good) != 4) continue;

            $ret = $goodModel->insertRecord($good[0], array(
                'good_code'          => trim($good[0]),
                'good_name'          => trim($good[1]),
                'good_price'         => trim($good[2]),
                'good_seller'        => trim($good[3]),
            ));

            $orderModel->updateRecordPrice($good);
        }
    }

    public function ajax_getGoodList(Request $request) {

        $params = $request->all();

        $tbl = new Good();
        $ret = $tbl->getAllForDatatable($params);

        return response()->json($ret);
    }

    public function getgood(Request $request, $id) {
        $goodModel = new Good();

        $result = $goodModel->getRecordInfoById($id);
        return response()->json($result);
    }

    public function deletegood(Request $request, $id) {
        $goodModel = new Good();

        $result = $goodModel->deleteRecord($id);
        return response()->json($result);
    }

    public function deletegoods(Request $request) {
        $selected = $request->get('content');
        $goodModel = new Good();

        $result = $goodModel->deleteRecords($selected);
        return response()->json($result);
    }

    public function modifygood(Request $request, $id) {
        $good = $request->get('content');
        $goodModel = new Good();
        $result = $goodModel->updateRecordById($id, array(
            'good_code'         => $good['good_code'],
            'good_name'         => $good['good_name'],
            'good_price'        => $good['good_price'],
            'good_seller'       => $good['good_seller'],
        ));

        return response()->json($result);
    }
}
