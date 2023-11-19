<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\paymentHistory;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    public function index(Request $request) {
        $paymentData = new paymentHistory;
        if (!empty($request->search)) {
            $paymentData = $paymentData->where(function ($query) use ($request) {
                $query->orWhere('id', 'LIKE', '%'. $request->search. '%');
            });
        }

        $paymentData = $paymentData->orderBy('id', 'DESC')->sortable()->paginate(env('ITEMS_PER_PAGE'));
        return view('payment_history.payment-list',
        [
            'paymentData' => $paymentData,
            'searchData' => $request->search,
            'uri' => \Request::route()->uri
       ]);
    }

    public function paymentDetail(Request $request) {
        $paymentData = paymentHistory::find($request->id);
        if($paymentData) {

            $users = User::where('id', $paymentData->user_id)->first();
            $wallet = Wallet::where('user_id', $paymentData->user_id)->first();
            return view('payment_history.payment-detail',
            [
                'paymentData' => $paymentData,
                'user' => $users,
                'walletAmount' => isset($wallet) && !empty($wallet->amount) ? $wallet->amount : 0,
                'searchData' => $request->search,
                'uri' => \Request::route()->uri
           ]);
        }
    }

    public function updatePayment(Request $request) {

        $paymentData = paymentHistory::find($request->id);
        if($paymentData && $paymentData->status == 1) {

            $paymentData->update(['status' => $request->status]);
            if($request->status == 2) {
                $wallet = Wallet::where('user_id', $paymentData->user_id)->first();
                if(!$wallet) {

                    Wallet::create([
                        'user_id' => $paymentData->user_id,
                        'amount' => $paymentData->amount,
                        'payment_mode' => $paymentData->payment_mode,
                        'user_payment_id' => $paymentData->user_payment_id,
                    ]);
                } else {
                    $wallet->update(['amount' => ($wallet->amount + (int)$paymentData->amount)]);
                }
                Session::flash('message', 'Payment Verified Successfully');
                return back();
            } elseif($request->status == 3) {
                $wallet = Wallet::where('user_id', $paymentData->user_id)->first();
                if(!$wallet) {

                    Wallet::create([
                        'user_id' => $paymentData->user_id,
                        'amount' => 0,
                        'payment_mode' => $paymentData->payment_mode,
                        'user_payment_id' => $paymentData->user_payment_id,
                    ]);
                }
                Session::flash('message', 'Payment Declined Successfully');
                return back();
            }
        }
        Session::flash('message', 'You can not update the status after verified or declined');
        return back();
    }
}
