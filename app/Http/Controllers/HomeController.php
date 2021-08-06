<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\TikTok;
use App\Models\TikTokCategory;
use Hash;

class HomeController extends Controller
{
    public function index() {
        $categories = TikTokCategory::all();
        $cate = array();
        foreach ($categories as $index => $category)
            $cate[$category['id']][] = $category->name;
        return view('tiktok.list', [
            'categories'    => $cate,
        ]);
    }

    public function modifyUserCategory(Request $request, $id) {
        $params = $request->only('category', 'status');
        $tiktok = TikTok::where('id', $id)->first();
        $tiktok->category = $params['category'];
        $tiktok->status = $params['status'];
        $tiktok->save();

        return response()->json([
            'success'   => 'success'
        ], 200);
    }

    public function category() {
        return view('tiktok.category');
    }

    public function addCagegory(Request $request) {
        $params = $request->all();
        $categoryName = $params['add-category'];

        $this->validate($request, [
            'add-category'  => 'required'
        ]);

        $tiktokCategory = new TikTokCategory();
        $tiktokCategory->name = $params['add-category'];
        $tiktokCategory->save();

        return redirect()->back()->with('flash_message', 'カテゴリーが追加されました');
    }

    public function tiktokusers(Request $request) {
        $params = $request->all();

        $tbl = new TikTok();
        $ret = $tbl->getAllForDatatable($params);

        return response()->json($ret);
    }

    public function deletetiktok(Request $request, $id) {
        $tiktokModel = new TikTok();
        $result = $tiktokModel->deleteRecord($id);
        return response()->json($result);
    }

    public function getcategories(Request $request) {
        $params = $request->all();

        $tbl = new TikTokCategory();
        $ret = $tbl->getAllForDatatable($params);

        return response()->json($ret);
    }

    public function deleteCategory(Request $request, $id) {
        $tiktokModel = TikTokCategory::where('id', $id);
        $result = $tiktokModel->delete();
        return response()->json($result);
    }

    public function modifyCategory(Request $request, $id) {
        $name = $request->only('name');
        $tiktokModel = TikTokCategory::where('id', $id)->first();
        $tiktokModel->name = $name['name'];
        $tiktokModel->save();
        return response()->json([
            'success'   => 'success'
        ], 200);
    }



























    
    // public function register() {
    //     // Send mail test
    //     return view('home-register');
    // }
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // /**
    //  * Show the application dashboard.
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */

    // function addOrders( Request $request) {
    //     $content = $request->get('content');
    //     $orders = explode('||', $content);

    //     $goodCode = array();
    //     $userCode = array();

    //     foreach($orders as $index => $tmp) {
    //         $order = explode(',', $tmp);

    //         if ($index == 0) continue;
    //         if (empty($order) || count($order) != 3) continue;

    //         $codeSegs = explode('-', $order[1]);
    //         $unuse = array_pop($codeSegs);
    //         $user_login = implode('-', $codeSegs);
            
    //         //retrive all user list from csv
    //         if (!in_array($user_login, $userCode)) {
    //             $userCode[] = $user_login;
    //         }

    //         // retrive all good_code from CSV
    //         if (!in_array($order[1], $goodCode)) {
    //             $goodCode[] = $order[1];
    //         }
    //     }

    //     $warning = array();
    //     // check where user is registered or not
    //     $customerModel = new Customer();
    //     $customers = $customerModel->getAllUsers();
    //     foreach ($userCode as $code) {
    //         if (!in_array($code, $customers)) {
    //             $warning[] = 'ユーザーID「' . $code . '」は存在しません';
    //         }
    //     }

    //     // check where user is registered or not
    //     $goodModel = new Good();
    //     $goods = $goodModel->getAllGoodCodes();
    //     foreach ($goodCode as $code) {
    //         if (!in_array($code, $goods)) {
    //             $warning[] = '商品コード「' . $code . '」は存在しません';
    //         }
    //     }

    //     $tiktokModel = new Order();

    //     foreach($orders as $index => $tmp) {
    //         $order = explode(',', $tmp);

    //         if ($index == 0) continue;
    //         if (empty($order) || count($order) != 3) continue;

    //         $saleDate = trim($order[0]);
    //         $goodCode = trim($order[1]);
    //         $goodCount = trim($order[2]);

    //         $goodInfo = $goodModel->getRecordInfoByGoodCode($goodCode);
            
    //         $ret = $tiktokModel->insertRecord(array(
    //             'order_date'            => $saleDate,
    //             'good_code'             => $goodCode,
    //             'order_count'           => $goodCount,
    //             'order_price'           => is_null($goodInfo)? '0' : $goodInfo->good_price,
    //             'good_seller'           => is_null($goodInfo)? '' : $goodInfo->good_seller,
    //         ));
    //     }

    //     $message = '';
    //     array_filter($warning);
    //     if (count($warning) == 0) {
    //         $message = '入力成功しました';
    //     }

    //     return [
    //         'errors' => $warning,
    //         'message' => $message,
    //     ];
    // }

    // public function ajax_getOrderList(Request $request) {
    //     $params = $request->all();

    //     $tbl = new Order();
    //     $ret = $tbl->getAllForDatatable($params);

    //     return response()->json($ret);
    // }

    

    

    // public function deleteorders(Request $request) {
    //     $selected = $request->get('content');
    //     $tiktokModel = new Order();
    //     $result = $tiktokModel->deleteRecords($selected);
    //     return;
    // }

    // public function modifyorder(Request $request, $id) {
    //     $order = $request->get('content');
    //     $tiktokModel = new Order();
    //     $result = $tiktokModel->updateRecordById($id, array(
    //         'order_date'         => $order['order_date'],
    //         'good_code'         => $order['good_code'],
    //         'order_count'        => $order['order_count'],
    //     ));

    //     return response()->json($result);
    // }

    // public function deletesales(Request $request) {
    //     $selected = $request->get('content');
    //     $tiktokModel = new Order();

    //     $result = $tiktokModel->deleteRecords($selected);
    //     return response()->json($result);
    // }
}
