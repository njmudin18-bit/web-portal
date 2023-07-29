<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
  /**
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function index()
  {
    return view('login');
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function check_login(Request $request)
  {
    $input_request = $request->input();
    $validator = Validator::make($input_request, [
      'username'  => 'required|min:4',
      'password'  => 'required|min:5',
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors());
    }

    //if (auth()->attempt(array('username' => $input_request['username'], 'password' => $input_request['password']))) {
    if (Auth::attempt(['username' => $input_request['username'], 'password' => $input_request['password']])) {
      if (auth()->user()->aktivasi == 'Aktif') {
        $user = auth()->user();
        return response()->json([
          'code'        => 200,
          'status'      => "success",
          'message'     => "Anda berhasil login",
          'data'        => $user,
          'url'         => 'dashboard'
        ], 200);
      } else {
        return response()->json([
          'code'        => 401,
          'status'      => "error",
          'message'     => "Username anda di block",
          'data'        => array(),
          'url'         => null
        ], 401);
      }
    } else {
      return response()->json([
        'code'        => 400,
        'status'      => "error",
        'message'     => "Username atau password salah",
        'data'        => array(),
        'url'         => null
      ], 400);
    }
  }
}
