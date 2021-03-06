<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Exception;
use Socialite;
use App\Models\User;

class TwitterController extends Controller
{
    public function loginwithTwitter()
    {
    	return Socialite::driver('twitter')->redirect();
    }

    public function cbTwitter()
    {
    	try{
            $user = Socialite::driver('twitter')->user();
      
            $userWhere = User::where('twitter_id', $user->id)->first();
      
            if($userWhere){
      
                Auth::login($userWhere);
     
                return redirect('/dashboard');
            }else{

                $twitUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'twitter_id' => $user->id,
                    'oauth_type' => 'twitter',
                    'twitter_avatar' => $user->avatar,
                    'password' => encrypt('supersecret')
                ]);
     
                Auth::login($twitUser);
      
                return redirect('/dashboard');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function tosTwitter()
    {
        return view('terms');
    }

    public function ppTwitter()
    {
        return view('policy');
    }
}
