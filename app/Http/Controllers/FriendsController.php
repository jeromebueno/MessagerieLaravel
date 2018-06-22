<?php
/**
 * Created by PhpStorm.
 * User: jeromebueno
 * Date: 10/06/2018
 * Time: 21:13
 */

namespace App\Http\Controllers;

use Auth;


class FriendsController
{
    public function showFriends()
    {
        $user = new \App\User();
        $friends = $user->getFriends();
        if (count($friends) == 0) {
            return view('friends', ['error' => 'Aucun amis']);
        }
        return view('friends', ['friends' => $friends]);
    }

    public function getDemand(){
        $user = new \App\User();
        $demands = $user->getDemand();
        if(count($demands) == 0) {
            return view('friends', ['error' => 'Aucune demande']);
        }
        return view('friends',['friends' => $demands]);
    }//

    public function acceptDemand($idAccepted){
        $user = new \App\User();
        \App\Relation::where('idReceived',Auth::user()->id)->where('idSender',$idAccepted)->where('status',0)->update(array('status'=> 1));
        return view('friends',['friends' => $user->getDemand()]);
    }
}