<?php

namespace App\Http\Controllers\Api;

use Lang;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\GamePrediction;
use App\Models\ColorPrediction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class ColorPredictionController extends BaseController
{
    public function create(Request $request) {
        try {
            $validator = Validator::make($request->all(),
            [
                'game_id' => 'required|exists:game_predictions,id',
                'user_id' => 'required|exists:users,id',
                'game_color' => 'required',
                'amount' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }

            $wallet = Wallet::where('user_id', $request->user_id)->first();

            if($wallet) {
                $availableBalace = $wallet->amount >= $request->amount;
                if($availableBalace) {
                    $colorGame = ColorPrediction::create([
                        'game_id' => $request->game_id,
                        'user_id' => $request->user_id,
                        'game_color' => $request->game_color,
                        'amount' => $request->amount,
                    ]);

                    return $this->sendResponse($colorGame, Lang::get('messages.GAME_START_MESSAGE'));
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

        $gameColor = GamePrediction::find($request->game_id);

        if($gameColor->status != 2) {
            // $gameColor->update(['status' => '2']);
            if($gameColor && empty($gameColor->result_color)) {
                // $randomColor = $gameColor->randomColor();
                // $gameColor->update(['result_color' => $randomColor]);

                    $allColorGame = ColorPrediction::where('game_id', $request->game_id)->get()->toArray();
                    $count = count($allColorGame);

                    if ($count == 1) {
                        do {
                            $randomColor = ['red', 'violet', 'green', 'orange'][array_rand([0, 1, 2, 3])];
                        } while ($randomColor == $allColorGame[0]['game_color']);
                        $gameColor->update(['result_color' => $randomColor]);
                        ColorPrediction::where('game_id', $request->game_id)->update(['result_color' => $randomColor]);
                    }

                    if ($count == 2) {
                        do {
                            $randomColor = ['red', 'violet', 'green', 'orange'][array_rand([0, 1, 2, 3])];
                        } while ($randomColor == $allColorGame[0]['game_color'] || $randomColor == $allColorGame[1]['game_color']);
                        $gameColor->update(['result_color' => $randomColor]);
                        ColorPrediction::where('game_id', $request->game_id)->update(['result_color' => $randomColor]);
                        // dd($randomColor, $allColorGame[0]['game_color'], $allColorGame[1]['game_color']);
                    }

                    if ($count > 2) {
                        $userColors = [];
                        foreach ($allColorGame as $gameData) {
                            $userColors[] = [
                                'color' => $gameData['game_color'],
                                'amount' => (int) $gameData['amount'],
                            ];
                        }

                        $outputArray = [];

                        foreach ($userColors as $item) {
                            $color = $item['color'];
                            $amount = $item['amount'];

                            if (isset($outputArray[$color])) {
                                // If the color already exists in the output array, add the amount to it
                                $outputArray[$color]['amount'] += $amount;
                            } else {
                                // If the color doesn't exist in the output array, create a new entry
                                $outputArray[$color] = ['color' => $color, 'amount' => $amount];
                            }
                        }

                        usort($outputArray, function ($a, $b) {
                            return $a['amount'] - $b['amount'];
                        });

                        $lowestAmountColor = $outputArray[0]['color'];
                        $gameColor->update(['result_color' => $lowestAmountColor]);
                        ColorPrediction::where('game_id', $request->game_id)->update(['result_color' => $lowestAmountColor]);
                    }
                // ColorPrediction::where('game_id', $request->game_id)->update(['result_color' =>  $randomColor]);
            } else {
                ColorPrediction::where('game_id', $request->game_id)->update(['result_color' =>  $gameColor->result_color]);
            }

            $colorGame = ColorPrediction::where('game_id', $request->game_id)->where('user_id', $request->user_id)->orderBy('id', 'DESC')->first();

            $walletData = Wallet::where('user_id', $request->user_id)->first();
            if($walletData) {
                if($colorGame->game_color == $colorGame->result_color) {
                    $totalAmount = $walletData->amount + (($colorGame->amount * 3) - $colorGame->amount);;
                } else {
                    $totalAmount = $walletData->amount - $colorGame->amount;
                }
            }

            $walletData->update([
                "amount" => $totalAmount
            ]);

            $colorGame['final_amount'] = $totalAmount;
            return $this->sendResponse($colorGame, Lang::get('messages.GAME_END_MESSAGE'));
        }
        return $this->sendResponse([], 'Game Ended');
    }

    public function history(Request $request) {
        $numberData = ColorPrediction::where('user_id', Auth::user()->id)->with(['game_prediction'])->orderBy('id', 'DESC')->get();
        return $this->sendResponse($numberData, Lang::get('messages.RECORD_FOUND'));
     }
}
