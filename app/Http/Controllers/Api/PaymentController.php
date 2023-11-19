<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\paymentHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Api\BaseController as BaseController;

class PaymentController extends BaseController
{
    public function detail(Request $request) {
        $paymentData = paymentHistory::where('id',$request->id)->where('status', '2')->first();
        if($paymentData) {
            return $this->sendResponse($paymentData, Lang::get('messages.RECORD_FOUND'));
        }
        return $this->sendResponse((Object)[], Lang::get('messages.NO_RECORD_FOUND'));
    }

    public function paymentHistory(Request $request) {
        $paymentData = paymentHistory::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        if($paymentData) {
            return $this->sendResponse($paymentData, Lang::get('messages.RECORD_FOUND'));
        }
        return $this->sendResponse([], Lang::get('messages.NO_RECORD_FOUND'));
    }
}
