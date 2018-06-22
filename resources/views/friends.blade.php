@extends('layout')
@section('content')
    <a href="{{ url('/friends') }}" class="btn btn-info {{Illuminate\Support\Facades\Request::path() == 'friends'?'active':''}}">Ma liste d'amis</a>
    <a href="{{ url('/addedFriends') }}" class="btn btn-info {{Illuminate\Support\Facades\Request::path() == 'addedFriends'?'active':''}}">Mes demandes en attentes</a>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Accepter</th>
        </tr>
        </thead>
        <tbody>
    @if(isset($friends))

            @foreach($friends as $key=>$friend)
                <tr>
                    <th scope="row">{{ $key +1}}</th>
                    <td>{{$friend->name}}</td>
                    @if(\Illuminate\Support\Facades\Request::path() == 'friends')
                        <td><a href="{{ url('sendMessage/'.$friend->id) }}" class="btn btn-success">Envoyez un message</a></td>
                    @elseif(\Illuminate\Support\Facades\Request::path() == 'addedFriends')
                        <td><a href="{{ url('acceptFriend/'.$friend->id) }}" class="btn btn-success">Accept</a></td>
                    @endif
                </tr>
            @endforeach
    @endif

    @if(isset($error))
        <tr>
            <td colspan="3">{{$error}}</td>
        </tr>
    @endif

        <tbody>
    </table>
@endsection