<?php

namespace App\Http\Controllers;

use App\MailManager;
use Auth;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Hash;

class CustomersController extends Controller
{
    function index() {
        return view('users');
    }

    function register() {
        return view('users-register');
    }

    function addUsers( Request $request) {
        $content = $request->get('content');
        $users = explode('||', $content);
        $customerModel = new Customer();

        foreach($users as $index => $user) {
            $user_data = explode(',', $user);
            if ($index == 0) continue;
            if (count($user_data) != 10) continue;

            $userLogin = trim($user_data[0]);
            $userPass = trim($user_data[1]);
            $userEmail = trim($user_data[2]);
            $userName = trim($user_data[3]);
            $bankNumber = trim($user_data[4]);
            $shopNumber = trim($user_data[5]);
            $depoistKind = trim($user_data[6]);
            $accountNumber = trim($user_data[7]);
            $accountName = trim($user_data[8]);
            $userNumber = trim($user_data[9]);

            // If it's already registered, the user is skipped.
            $ret = $customerModel->insertRecord($user_data[0], array(
                'user_login'        => $userLogin,
                'raw_password'      => $userPass,
                'password'          => Hash::make($userPass),
                'user_name'         => $userName,
                'user_email'        => $userEmail,
                'user_number'       => $userNumber,
                'bank_number'       => $bankNumber,
                'shop_number'       => $shopNumber,
                'deposit_kind'      => $depoistKind,
                'account_number'    => $accountNumber,
                'account_name'      => $accountName
            ));

            // 登録メール発信
            // $this->sendEmail('ユーザー登録されました', $userName, $userEmail, 'パスワード：' . $userPass);
        }
    }

    public function randomPassword($len = 8) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function sendEmail($title, $name, $email, $message) {
        $ret = MailManager::send_register(array(
            'name'      => $name,
            'subject'   => $title,
            'msg'       => $message,
            'email'     => $email,
        ));
    }

    public function ajax_getUserList(Request $request) {

        $params = $request->all();

        $tbl = new Customer();
        $ret = $tbl->getAllForDatatable($params);

        return response()->json($ret);
    }

    public function getuser(Request $request, $id) {
        $customerModel = new Customer();

        $result = $customerModel->getRecordInfoById($id);
        return response()->json($result);
    }

    public function deleteuser(Request $request, $id) {
        $customerModel = new Customer();

        $result = $customerModel->deleteRecord($id);
        return response()->json($result);
    }

    public function deleteusers(Request $request) {
        $selected = $request->get('content');
        $customerModel = new Customer();
        $result = $customerModel->deleteRecords($selected);
        return;
    }

    public function modifyuser(Request $request, $id) {
        $users = $request->get('content');
        $customerModel = new Customer();
        $result = $customerModel->insertRecord($users['user_login'], array(
            'user_login'        => $users['user_login'],
            'raw_password'        => $users['raw_password'],
            'password'          => Hash::make($users['raw_password']),
            'user_name'         => $users['user_name'],
            'user_email'        => $users['user_email'],
            'user_number'       => $users['user_number'],
            'bank_number'       => $users['bank_number'],
            'shop_number'       => $users['shop_number'],
            'deposit_kind'      => $users['deposit_kind'],
            'account_number'    => $users['account_number'],
            'account_name'      => $users['account_name']
        ));

        return response()->json($result);
    }

    public function staffSales($user_login) {
        $customer = new Customer();
        $ret = $customer->getRecordInfoByUserLogin($user_login);

        return view('user-sale', [
            'user' => $ret,
        ]);
    }

    public function ajax_getSaleList(Request $request, $id) {
        $params = $request->all();
        $order = new Order();
        $ret = $order->getUserSales($params, $id);

        return response()->json($ret);
    }
}
