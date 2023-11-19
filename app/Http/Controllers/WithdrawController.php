<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WithdrawController extends Controller
{
    public function index(Request $request) {
        $withdrawData = new Withdraw;
        $withdrawData = $withdrawData->orderBy('id', 'DESC')->sortable()->paginate(env('ITEMS_PER_PAGE'));
        return view('withdraw.withdraw-list',
        [
            'withdrawData' => $withdrawData,
            'uri' => \Request::route()->uri
       ]);
    }

    public function withdrawDetail(Request $request) {
        $withdrawData = Withdraw::find($request->id);
        if($withdrawData) {

            $users = User::where('id', $withdrawData->user_id)->first();
            $wallet = Wallet::where('user_id', $withdrawData->user_id)->first();
            return view('withdraw.withdraw-detail',
            [
                'withdrawData' => $withdrawData,
                'user' => $users,
                'walletAmount' => isset($wallet) && !empty($wallet->amount) ? $wallet->amount : 0,
                'uri' => \Request::route()->uri
           ]);
        }
    }

    public function updateWithdraw(Request $request) {

        $withdrawData = Withdraw::find($request->id);

        if($withdrawData && $withdrawData->status == 1) {

            $withdrawData->update(['status' => $request->status]);
            $wallet = Wallet::where('user_id', $withdrawData->user_id)->first();
            if($request->status == 2) {
                if($wallet && $wallet->amount >= $withdrawData->amount) {
                    $wallet->update(['amount' => ($wallet->amount - $withdrawData->amount)]);
                    Session::flash('message', 'Withdraw Payment Verified');
                    return back();
                }

                Session::flash('message', 'Amount can not withdraw more then balance wallet');
                return back();
            } elseif($request->status == 3) {
                Session::flash('message', 'Withdraw Payment Declined');
                return back();
            }

        }
        Session::flash('message', 'You can not update the status after verified or declined');
        return back();
    }
}
