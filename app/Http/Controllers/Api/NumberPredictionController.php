<?php

namespace App\Http\Controllers\Api;

use Lang;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\GamePrediction;
use App\Models\NumberPrediction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class NumberPredictionController extends BaseController
{
    public function create(Request $request) {
        try {
            $validator = Validator::make($request->all(),
            [
                'game_id' => 'required|exists:game_predictions,id',
                'user_id' => 'required|exists:users,id',
                'game_number' => 'required',
                'amount' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }

            $wallet = Wallet::where('user_id', $request->user_id)->first();

            if($wallet) {
                $availableBalace = $wallet->amount >= $request->amount;
                if($availableBalace) {
                    $numberGame = NumberPrediction::create([
                        'game_id' => $request->game_id,
                        'user_id' => $request->user_id,
                        'game_number' => $request->game_number,
                        'amount' => $request->amount,
                    ]);
                    return $this->sendResponse($numberGame, Lang::get('messages.GAME_START_MESSAGE'));
                }
            }
            return $this->sendError(Lang::get('messages.NO_BALANCE'), []);

        } catch (\Exception $ex)
        {
            return $this->sendError(Lang::get('messages.SOMTHING_WENT_WRONG'), []);
        }
    }

    public function endGame(Request $request) {
        $validator = Validator::make($request->all(),
        [
            'game_id' => 'required|exists:game_predictions,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $gameNumber = GamePrediction::find($request->game_id);

        if($gameNumber->status != 2) {
            // $gameNumber->update(['status' => '2']);
            if($gameNumber && empty($gameNumber->result_color)) {

                $allNumberGame = NumberPrediction::where('game_id', $request->game_id)->get()->toArray();
                $count = count($allNumberGame);

                if ($count == 1) {
                    do {
                        $randomNumber = rand(1, 10);
                    } while ($randomNumber == (int) $allNumberGame[0]['game_number']);
                    $gameNumber->update(['result_color' => $randomNumber]);
                    NumberPrediction::where('game_id', $request->game_id)->update(['result_number' =>  $randomNumber]);
                }

                if ($count == 2) {
                    do {
                        $randomNumber = rand(1, 10);
                    } while ($randomNumber == (int) $allNumberGame[0]['game_number'] || $randomNumber == (int) $allNumberGame[1]['game_number']);
                    $gameNumber->update(['result_color' => $randomNumber]);
                    NumberPrediction::where('game_id', $request->game_id)->update(['result_number' =>  $randomNumber]);
                }

                if ($count > 2) {
                    $userNumbers = [];
                    foreach ($allNumberGame as $gameData) {
                        $userNumbers[] = [
                            'number' => (int) $gameData['game_number'],
                            'amount' => (int) $gameData['amount'],
                        ];
                    }

                    $outputArray = [];

                    foreach ($userNumbers as $item) {
                        $number = $item['number'];
                        $amount = $item['amount'];

                        if (isset($outputArray[$number])) {
                            // If the number already exists in the output array, add the amount to it
                            $outputArray[$number]['amount'] += $amount;
                        } else {
                            // If the number doesn't exist in the output array, create a new entry
                            $outputArray[$number] = ['number' => $number, 'amount' => $amount];
                        }
                    }

                    usort($outputArray, function ($a, $b) {
                        return $a['amount'] - $b['amount'];
                    });

                    $lowestAmountNumber = $outputArray[0]['number'];
                    $gameNumber->update(['result_color' => $lowestAmountNumber]);
                    NumberPrediction::where('game_id', $request->game_id)->update(['result_number' =>  $lowestAmountNumber]);
                }
            } else {
                NumberPrediction::where('game_id', $request->game_id)->whereNull('result_number')->update(['result_number' =>  $gameNumber->result_color]);
            }

            $numberGame = NumberPrediction::where('game_id', $request->game_id)->where('user_id', $request->user_id)->orderBy('id', 'DESC')->first();

            $walletData = Wallet::where('user_id', $request->user_id)->first();
            if($walletData) {
                if($numberGame->game_number == $numberGame->result_number) {
                    $totalAmount = $walletData->amount + (($numberGame->amount * 9) - $numberGame->amount);
                } else {
                    $totalAmount = $walletData->amount - $numberGame->amount;
                }
            }

            $walletData->update([
                "amount" => $totalAmount
            ]);

            $numberGame['final_amount'] = $totalAmount;
            return $this->sendResponse($numberGame, Lang::get('messages.GAME_END_MESSAGE'));
        }
        return $this->sendResponse([], 'Game Ended');
    }

    public function history(Request $request) {
       $numberData = NumberPrediction::where('user_id', Auth::user()->id)->with(['game_prediction'])->orderBy('id', 'DESC')->get();
       return $this->sendResponse($numberData, Lang::get('messages.RECORD_FOUND'));
    }
}
