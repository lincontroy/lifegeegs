<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Userplan;
use Exception;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class CronController extends Controller
{
    public function fraudcheckAdmin()
    {

        ini_set('max_execution_time', '0');

        $orders = Order::with('getwaywithfraudcheck')->whereHas('getwaywithfraudcheck')->select('id', 'getway_id', 'payment_id')->where('status', 1)->get();

        if ($orders->count() == 0) {
            return false;
        }

        foreach ($orders as $i => $order) {
            $data[$i]['id'] = $order->id;
            $data[$i]['namespace'] = $order->getwaywithfraudcheck->namespace;
            foreach (json_decode($order->getwaywithfraudcheck->data) as $k => $creds) {
                if ($order->getwaywithfraudcheck->test_mode == 0) {
                 $data[$i]['creds'][$k] = $creds;
                 $data[$i]['creds']['payment_id'] = $order->payment_id;
                 $data[$i]['creds']['is_test'] = $order->getwaywithfraudcheck->test_mode;
                }
                
            }
        }

        $ids = [];
        if ($data) {
            foreach ($data as $key => $value) {
                $status = $value['namespace']::isfraud($value['creds']);
                if ($status == 0) {
                    array_push($ids, $value['id']);
                }
            }
        }
        if (count($ids) > 0) {
            DB::beginTransaction();
            try {
                Order::whereIn('id', $ids)->update(array('status' => 0));
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }
        }
    }

    public function fraudcheckMerchant()
    {

        ini_set('max_execution_time', '0');

        $activeusers = Userplan::where('fraud_check', 1)->pluck('user_id')->toArray();
        $payments = Payment::with('getway_info', 'request_is_test')->whereIn('user_id', $activeusers)->whereHas('getway_info')->select('id', 'getway_id', 'trx_id', 'request_id')->where('status', 1)->get();

        
        if ($payments->count() == 0) {
            return false;
        }

        $data = [];
        foreach ($payments as $i => $payment) {
            $data[$i]['id'] = $payment->id;
            $data[$i]['namespace'] = $payment->getway_info->namespace;
            foreach (json_decode($payment->getway_info->usercreds->production) as $k => $creds) {
                if ($payment->request_is_test->is_test == 0) {
                    $data[$i]['creds'][$k] = $creds;
                    $data[$i]['creds']['payment_id'] = $payment->trx_id;
                    $data[$i]['creds']['is_test'] = $payment->request_is_test->is_test;
                }
                
            }
        }
        $ids = [];
        if ($data) {
            foreach ($data as $value) {
                $status = $value['namespace']::isfraud($value['creds']);
                if ($status == 0) {
                    array_push($ids, $value['id']);
                }
            }
        }

        if (count($ids) > 0) {
            DB::beginTransaction();
            try {
                Payment::whereIn('id', $ids)->update(array('status' => 0));
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }
        }
    }
}
