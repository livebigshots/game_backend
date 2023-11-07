<?php

namespace App\Http\Controllers\Api;

use Lang;
use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class UserController extends BaseController
{
    public function register(Request $request) {

        $validator = Validator::make($request->all(),
        [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'mobile_number' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $userDetails = $request->all();

        $userDetails['password'] = Hash::make($userDetails['password']);
        // Create new user
        $user = User::create($userDetails);
        $success = $user;
        $success['token'] = $user->createToken(env('APP_NAME'))->accessToken;

        return $this->sendResponse($success, Lang::get('messages.USER_REGISTERED_SUCCESSFULLY_MSG'));
    }

    public function login(Request $request)
    {
        $token = $request->username;

        try
        {
            $validator = Validator::make($request->all(),
            [
                'password' => 'required',
                'username' => 'nullable'
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }

            $isUserExists = User::where('email', $token)
                            ->orWhere('mobile_number', $token)
                            ->count();

            if ($isUserExists === 0) {

                return $this->sendError(Lang::get('messages.USER_NOT_EXISTS_IN_SYSTEM'), [] ,201);
            }

            $userDetails = null;

            // Check login user is social media user or not
            if (Auth::attempt(['email' => $request->username, 'password' => $request->password, 'role' => config('enums.USER_TYPE')['USER'] ]) || Auth::attempt(['mobile_number' => $request->username , 'password' => $request->password, 'role' => config('enums.USER_TYPE')['USER']])) {

                $userDetails = Auth::user();
            }

            if ($userDetails) {
                    $success = $userDetails;
                    // To revoke all the existing token of specific user
                    Helper::revokeUserTokens($userDetails->id);
                    $success['token'] = $userDetails->createToken(env('APP_NAME'))->accessToken;
                    return $this->sendResponse($success, Lang::get('messages.USER_LOGIN_SUCCESSFULLY_MSG'));
            }
            return $this->sendError(Lang::get('messages.INVALID_USERNAME_OR_PASSOWRD'), [], 201);
        }
        catch (\Exception $ex)
        {
            return $this->sendError(Lang::get('messages.SOMTHING_WENT_WRONG'), []);
        }
    }

    public function userList(Request $request) {
        $userData = User::all();

        if ($userData) {
            $success = $userData;
            return $this->sendResponse($success, Lang::get('messages.RECORD_FOUND'));
        } else {
            return $this->sendError(Lang::get('messages.SOMETHING_WENT_WRONG_MSG'), []);
        }
    }

    public function userEdit(Request $request) {
        try {

            $validator = Validator::make($request->all(),
            [
                'id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required|unique:users,username,'.$request->id,
                'email' => 'required|email|unique:users,email,'.$request->id,
                'mobile_number' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }

            // Trim all the request data.
            $input = array_map('trim', $request->all());

            // Update user data
            $userDetails = Auth::user();
            $userDetails->first_name =$input['first_name'];
            $userDetails->last_name = $input['last_name'];
            $userDetails->username = $input['username'];
            $userDetails->email = $input['email'];
            $userDetails->mobile_number = $input['mobile_number'];
            $userDetails->save();

            if ($userDetails) {
                $success = $userDetails;
                return $this->sendResponse($success, Lang::get('messages.UPDATE_PROFILE_SUCCESSFULLY_MSG'));
            } else {
                return $this->sendError(Lang::get('messages.SOMETHING_WENT_WRONG_MSG'), []);
            }
        } catch (\Exception $ex)
        {
            return $this->sendError(Lang::get('messages.SOMTHING_WENT_WRONG'), []);
        }
    }
}
