<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Response;
use PDF;
use DateTime;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    function index() {
        return view('sale');
    }

    function ajax_getSalesList(Request $request) {
        $params = $request->all();

        $tbl = new Order();
        $ret = $tbl->getAllSalesForDatatable($params);

        return response()->json($ret);
    }

    
    function csv_download(Request $request) {
        $params = $request->all();
        $tbl = new Order();
        $records = $tbl->csvdownload($params);

        $csv = '';
        $headers = [
            'サービス区分',
            '実行日',
            '受取人銀行番号',
            '受取人支店番号',
            '受取人預金種目',
            '受取人口座番号',
            '受取人口座名',
            '金額',
            '顧客番号',
            '登録者ユーザID',
            '登録者氏名'
        ];
        for ($i = 0; $i < count($headers); $i ++) {
            $csv .= $headers[$i] . ',';
        }

        $strip = '="' . (new DateTime($params['tradeDay']))->format('md') . '"';

        $csv .= "\n";
        foreach ($records as $index => $record) {
            $bank_number        = '="' . (sprintf('%04d', $record->bank_number)) . '"';
            $shop_number        = '="' . (sprintf('%03d', $record->shop_number)) . '"';
            $account_number     = '="' . (sprintf('%07d', $record->account_number)) . '"';

            $csv .= '3,';
            $csv .= $strip . ',';
            $csv .= $bank_number. ',';
            $csv .= $shop_number . ',';
            $csv .= $record->deposit_kind . ',';
            $csv .= $account_number. ',';
            $csv .= $record->account_name . ',';
            $csv .= $record->order_price . ',';
            $csv .= $record->user_number . ',';
            $csv .= $record->user_login . ',';
            $csv .= $record->user_name . ',';
            
            $csv .= "\n";
        }

        $date = date('Ymdhis', time());
        $filename = 'temp/' . $date . '.csv';
        file_put_contents($filename, "\xEF\xBB\xBF".  $csv);

        return response()->download($filename);
    }

    // Generate PDF
    public function pdf_download(Request $request) {
        $params = $request->all();
        $tbl = new Order();
        $ret = $tbl->csvdownload($params);

        $strip = (new DateTime($params['tradeDay']))->format('md');

        $pdf = App()->make('dompdf.wrapper');
        $pdf = PDF::loadView('sale-pdfview', [
            'allData' => $ret,
            'tradeDay' => $strip,
		])->setPaper('a4', 'portrait');

        $date = date('Ymdhis', time());
        $filename = $date . '.pdf';

        return $pdf->download($filename);
    }

    
}
