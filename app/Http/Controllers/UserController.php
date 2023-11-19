<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Cow;
use App\Models\User;
use App\Models\CowLot;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\paymentHistory;
use App\Models\ColorPrediction;
use App\Models\NumberPrediction;

class UserController extends Controller
{
    /**
     * User Listing
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userData = new User;
        if (!empty($request->search)) {
            $userData = $userData->where(function ($query) use ($request) {
                $query->orWhere('first_name', 'LIKE', '%'. $request->search. '%')
                        ->orWhere('last_name', 'LIKE', '%'. $request->search. '%')
                        ->orWhere('email', 'LIKE', '%'. $request->search. '%')
                        ->orWhere('username', 'LIKE', '%'. $request->search. '%')
                        ->orWhere('mobile_number', 'LIKE', '%'. $request->search. '%');
            });
        }

        $userData = $userData->sortable()->where('role', '!=' , config('enums.USER_TYPE.ADMIN'))->orderBy('id', 'DESC')->paginate(env('ITEMS_PER_PAGE'));
        return view('user.index',
        [
            'users' => $userData,
            'searchData' => $request->search,
            'uri' => \Request::route()->uri
       ]);
    }

    public function userDetail(Request $request) {
        $user = User::find($request->id);
        $wallet = Wallet::where('user_id', $user->id)->first();
        $paymentHistory = paymentHistory::where('user_id', $user->id)->orderBy('id', 'DESC')->sortable()->paginate(8);
        $colorPrediction = ColorPrediction::where('user_id', $user->id)->orderBy('id', 'DESC')->sortable()->paginate(5);
        $numberPrediction = NumberPrediction::where('user_id', $user->id)->orderBy('id', 'DESC')->sortable()->paginate(5);
        return view('user.user_detail',
        [
            'user' => $user,
            'paymentHistories' => $paymentHistory,
            'colorPrediction' => $colorPrediction,
            'numberPrediction' => $numberPrediction,
            'walletAmount' => isset($wallet) && !empty($wallet->amount) ? $wallet->amount : 0,
            'uri' => \Request::route()->uri
        ]);
    }
}
