<?php

namespace App\Http\Controllers\Api;

use Lang;
use App\Models\Wallet;
use App\Models\ReferenceBonus;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\paymentHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class WalletController extends BaseController
{
    public function add(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'user_id' => 'required|exists:users,id',
            'amount' => 'required',
            'payment_mode' => 'required',
            'user_payment_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $paymentHistory = paymentHistory::create([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'user_payment_id' => $request->user_payment_id,
            'status' => '1',
        ]);

        // Add Reference Bonus
        $referenceUserData = User::where('reference_code',  Auth::user()->by_reference_code)->first();
        if(!empty($referenceUserData) && isset($referenceUserData))
        {
            $referenceBonus = ReferenceBonus::where('user_id', Auth::user()->id)->first();
            // dd($referenceUserData ,$referenceBonus);
            if (!empty($referenceBonus) && isset($referenceBonus)) {
                $referenceBonus->amount = $referenceBonus->amount + ($request->amount * 10) / 100;
                $referenceBonus->save();
            }
        }

        return $this->sendResponse($paymentHistory, Lang::get('messages.WALLET_ADD'));
    }

    public function detail(Request $request) {
        $walletData = Wallet::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->first();
        if($walletData) {
            return $this->sendResponse($walletData, Lang::get('messages.RECORD_FOUND'));
        }
        return $this->sendResponse([], Lang::get('messages.NO_RECORD_FOUND'));
    }

    public function  referenceDetail() {
        $referenceData = ReferenceBonus::selectRaw("reference_user_id, IFNULL(SUM(amount), 0.00) as total_amount")
                    ->where('reference_user_id', Auth::user()->id)
                    ->groupBy('reference_user_id')
                    ->get();
        if($referenceData) {
            return $this->sendResponse($referenceData, Lang::get('messages.RECORD_FOUND'));
        }
        return $this->sendResponse([], Lang::get('messages.NO_RECORD_FOUND'));
    }
}
