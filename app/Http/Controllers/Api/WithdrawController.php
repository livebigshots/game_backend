<?php

namespace App\Http\Controllers\Api;

use App\Models\Wallet;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class WithdrawController extends BaseController
{
    public function add(Request $request) {

        $validator = Validator::make($request->all(),
        [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required',
            'user_payment_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $wallet=Wallet::where('user_id', $request->user_id)->first();
        if($wallet) {
            if($wallet->amount >= $request->amount) {
                $paymentHistory = Withdraw::create([
                    'user_id' => $request->user_id,
                    'amount' => $request->amount,
                    'user_payment_id' => $request->user_payment_id,
                    'account_number' => $request->account_number,
                    'bank_mobile_number' => $request->bank_mobile_number,
                    'bank_name' => $request->bank_name,
                    'ifsc_code' => $request->ifsc_code,
                    'status' => '1',
                ]);
                return $this->sendResponse($paymentHistory, 'Withdraw Request Created');
            }
            return $this->sendError('Your can not withdraw more then '. $wallet->amount, []);
        }
        return $this->sendError('You have no wallet amount', );
    }

    public function history(Request $request) {
        $withdraw = Withdraw::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return $this->sendResponse($withdraw, Lang::get('messages.RECORD_FOUND'));
    }
}
