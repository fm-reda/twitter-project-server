<?php

namespace App\Http\Controllers;
use  App\Twitter;
use Illuminate\Http\Request;

class TController extends Controller
{
   public function create(Request $request){
   $twitter =new Twitter();

   $twitter->twitterID = $request->input('twitterID');

   $twitter->save();
   return response()->json($twitter);
   }



   public function get(){
    return response()->json(Twitter::get());
}


public function delete($id){
    return response()->json(Twitter::destroy($id));

}


}
