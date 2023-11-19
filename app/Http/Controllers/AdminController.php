<?php

namespace App\Http\Controllers;

use App\Models\AdminAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * get chnage password form
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $userData = Auth::user();
        $adminAccountDetails = AdminAccount::orderBy('id', 'DESC')->first();
        return view('profile',
        [
            "users" => $userData,
            "adminAccount" => $adminAccountDetails,
            'uri' => \Request::route()->uri
       ]);
    }

     /**
     * profile
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        $userData = User::find(Auth::user()->id);
        $userData->first_name = $request->firstname;
        $userData->last_name = $request->lastname;
        $userData->email = $request->email;
        $userData->mobile_number = $request->mobile;
        $userData->save();
        return view('profile',
        [
            'users' => $userData,
            'uri' => \Request::route()->uri,
        ]);
    }

     /**
     * change Password
     *
     * @return \Illuminate\Http\Response
     */
    public function changePasswordForm(Request $request)
    {
        $validator = $request->validate( [
            'old_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail(Lang::get('messages.OLD_PASSWORD_MATCH_MSG'));
                    }
                },
            ],
            'password' => 'required|different:old_password',
            'confirm_password' => 'required|same:password',
        ], [
            'password.different' => Lang::get('messages.DIFFERENT_PASSWORD_MSG'),
        ]);

        $userData = Auth::user();
        $userData->password = Hash::make($request->password);
        $userData->save();
        Session::flash('message', Lang::get('messages.PASSWORD_FLASH_MSG'));
        return back();
    }

    public function changeAccountDetail(Request $request) {

        $validator = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'upi_id' => 'nullable',
        ]);

        $image = new AdminAccount();

        // Check if an image already exists and delete it
        if($request->has('image')) {
            Storage::disk('public')->deleteDirectory('admin_account/');
            AdminAccount::truncate();
            // Store the new image and save image information to the database
            $uploadedFile = $request->file('image');
            $newName = time() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->storeAs('admin_account/', $newName, 'public');
            $image->image = $newName;

        }

        $image->upi_id = $request->upi_id;
        $image->status = '1';
        $image->save();

        Session::flash('message', Lang::get('messages.ACCOUNT_DETAIL_UPDATE'));
        return back();
    }
}
