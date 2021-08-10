<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Confirmregister;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        
        $val = Validator::make( $request->all(), [
        'email'=>'required|email|min:8',
        'password'=> 'required|string|min:6']);

        if ($val->fails()) {
           return Redirect::back()->withErrors($val)->withInput();
        }else{

           if (User::where('email',$request->input('email'))->exists()) {

               $user = User::where('email',$request->input('email'))->first();
               $auth = Hash::check($request->input('password'),$user->password);
                  if ($user && $auth) {

                    if ($user->status == User::UNBLOCK) {
                        if ($user->hasVerifiedEmail()) {
                           
                            toastr()->success('Data has been saved successfully!');
                            $this->attemptLogin($request);
                        } else {
                            toastr()->error('emayl@ verifikachvat che');
                            Mail::to($user->email)->send(new Confirmregister($user));
                        }
                    } else {
                        toastr()->error('blok exat akaunt');
                    }                      
                } else {
                    toastr()->error('login kam prol sxale grvat');
                }

           } else {
             toastr()->error('email chi gtnvel duq karox eq granchvel hambal');
           }

         return Redirect::back();
        }

    }
}
