<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    //
    public function createFollow(User $user){

        // cannot follow yourself
        if($user->id == auth()->user()->id){
            return back()->with('failure','can\'t follow yourself');
        }
        // cannot follow someone twice
        $existCheck = Follow::where([['user_id','=',auth()->user()->id],['followeduser','=',$user->id]])->count();
        if($existCheck){
            return back()->with('failure','already following user');
        }
        $newFollow = new Follow;
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();
        return back()->with('success','now following user');
    }

    public function removeFollow(User $user){
        Follow::where([['user_id','=',auth()->user()->id],['followeduser','=',$user->id]])->delete();
        return back()->with('success','user unfollowed');
    }
}
