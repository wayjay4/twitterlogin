<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Exception;
use Socialite;
use App\Models\Users;

class FacebookController extends Controller
{
    public function loginwithFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function cbFacebook()
    {
        try{
            $user = Socialite::driver('facebook')->user();
      
            $userWhere = User::where('facebook_id', $user->id)->first();
      
            if($userWhere){
      
                Auth::login($userWhere);
     
                return redirect('/dashboard');
            }else{

                $fbUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id' => $user->id,
                    'oauth_type' => 'facebook',
                    'facebook_avatar' => $user->avatar,
                    'password' => encrypt('supersecret')
                ]);
     
                Auth::login($fbUser);
      
                return redirect('/dashboard');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function tosFacebook()
    {
        return view('terms');
    }

    public function ppFacebook()
    {
        return view('policy');
    }
}
