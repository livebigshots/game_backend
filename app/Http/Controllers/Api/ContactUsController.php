<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends BaseController
{
    public function create(Request $request) {
        try {
            $validator = Validator::make($request->all(),
            [
                'title' => 'required',
                'message' => 'required',
            ]);
            $requestData = $request->all();
            $contactData = Contact::create([
                'user_id' => Auth::user()->id,
                'title' => $requestData['title'],
                'email' => $requestData['email'],
                'message' => $requestData['message'],
            ]);

            return $this->sendResponse($contactData, Lang::get('messages.CONTACT_CREATED'));

        } catch (\Exception $ex)
        {
            dd($ex);
            return $this->sendError(Lang::get('messages.SOMTHING_WENT_WRONG'), []);
        }
    }

    public function detail($id) {
        try {
            $contactData = Contact::find($id);

            if($contactData) {
                return $this->sendResponse($contactData, Lang::get('messages.RECORD_FOUND'));
            }
            return $this->sendResponse($contactData, Lang::get('messages.NO_RECORD_FOUND'));

        } catch (\Exception $ex)
        {
            return $this->sendError(Lang::get('messages.SOMTHING_WENT_WRONG'), []);
        }
    }

    public function list(Request $request) {
        try {
            $contactData = Contact::where('user_id', Auth::user()->id)->get();

            if($contactData) {
                return $this->sendResponse($contactData, Lang::get('messages.RECORD_FOUND'));
            }
            return $this->sendResponse($contactData, Lang::get('messages.NO_RECORD_FOUND'));

        } catch (\Exception $ex)
        {
            return $this->sendError(Lang::get('messages.SOMTHING_WENT_WRONG'), []);
        }
    }
}
