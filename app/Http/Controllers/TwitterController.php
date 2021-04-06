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
		if(!$user->email){
		    $user->email =  "example_".rand()."@example.com";
		}

                $twitUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'twitter_id'=> $user->id,
                    'oauth_type'=> 'twitter',
                    'password' => encrypt('supersecret')
                ]);
     
                Auth::login($twitUser);
      
                return redirect('/dashboard');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
