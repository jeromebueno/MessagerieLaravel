<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;

class SearchController extends Controller
{
    //
    public function search(Request $request){
        $name = $request->input('name_search');
        if(empty($name)){
            return view('search', ['error' => 'Recherche incorrect, aucun nom renseigné']);
        }
        $users = \App\User::where('name','like','%'.$name.'%')->get();
        $relations = \App\Relation::where('idSender',Auth::user()->id)->orWhere('idReceived',Auth::user()->id)->get();
        foreach ($users as $user) {
            $user->setAttribute('status', '-1');
            if($user->id == Auth::user()->id){
                $user->setAttribute('status', '-2');
            }
            else {
                    foreach ($relations as $relation) {
                        if ($relation->idReceived == $user->id || $relation->idSender == $user->id) {
                            if ($relation->status == 0) {
                                $user->setAttribute('status', '0');
                            } elseif ($relation->status == 1) {
                                $user->setAttribute('status', '1');
                            }
                        }
                    }
            }
        }

        return view('search', ['users' => $users]);
    }
}
