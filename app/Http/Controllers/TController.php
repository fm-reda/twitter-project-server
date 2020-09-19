<?php

namespace App\Http\Controllers;

use  App\Twitter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();



        $tweet = Twitter::where('twitterID', $request->twitterID)->first();


        if ($tweet) {
            // dd($tweet);
            return response()->json('Tweet already exist', 403);
        }

        $twitter = new Twitter();
        $twitter->twitterID = $request->twitterID;
        $twitter->name = $request->name;
        $twitter->text = $request->text;
        $twitter->avatar = $request->avatar;
        $twitter->user_id = $user->id;


        $twitter->save();
        return response()->json($twitter);
    }



    public function get()
    {
        $user = Auth::user();


        $favoris = $user->favoris->all();
        return response()->json(["user" => $user], 200);
        return response()->json(Twitter::get());
    }


    public function delete($id)
    {
        // dd($id);
        $favorie = Twitter::find($id);
        $favorie->delete();
        return response()->json('favorie deleted');


        // return response()->json(Twitter::destroy($id));
    }
}
