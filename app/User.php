<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cmgmyr\Messenger\Traits\Messagable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use Messagable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFriends()
    {
        $idWaitRelation = [];
        $relations = \App\Relation::where('status', 1)->where('idReceived', Auth::user()->id)->orWhere('idSender', Auth::user()->id)->get();
        foreach ($relations as $relation) {
            if ($relation->idSender != Auth::user()->id) {
                $idWaitRelation[] = $relation->idSender;
            }
            if ($relation->idReceived != Auth::user()->id) {
                $idWaitRelation[] = $relation->idReceived;
            }
        }
            $friends = \App\User::whereIn('id', $idWaitRelation)->get();
            return $friends;
    }

    public function getDemand()
    {
        $idWaitRelation = [];
        $relations = \App\Relation::where('idReceived',Auth::user()->id)->where('status',0)->get();
        foreach ($relations as $relation) {
            if ($relation->idSender != Auth::user()->id) {
                $idWaitRelation[] = $relation->idSender;
            }
            if ($relation->idReceived != Auth::user()->id) {
                $idWaitRelation[] = $relation->idReceived;
            }
        }
        $demands = \App\User::whereIn('id', $idWaitRelation)->get();
        return $demands;
    }
}

