<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }


  /**
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function index()
  {
    if (Auth::check()) {
      return view('auth/dashboard');
    }

    return redirect("login")->withSuccess('You are not allowed to access');
  }


  /**
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();

    $request->session()->regenerateToken();
    return redirect(route('login'));
  }
}
