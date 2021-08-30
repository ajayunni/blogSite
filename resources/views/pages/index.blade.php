@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="well well-sm">
                    <h1>Welcome 🙌💕</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="card-header">{{ __('NewsFeed') }}</h2>
                    <div class="card-body">
                        @php
                            $histories = \App\History::all()->sortByDesc("created_at");
                        @endphp
                        @if(count($histories)>0)
                            @foreach($histories as $history)
                                <div class="container">
                                    <div class="well">
                                        <div class="media-body">
                                            @php
                                                $user = \App\User::find($history->user_id);
                                                $action = $history->action;
                                                $actionId = $history->action_id;
                                            @endphp
                                            @switch($action)
                                                @case(App\constants\Actions::ACTION_DP_CHANGED)
                                                <h4 class="media-heading">
                                                    <a href="profile/{{$user->id}}">{{$user->name}}</a>
                                                    has changed their profile picture !😎
                                                </h4>
                                                @break
                                                @case(App\constants\Actions::ACTION_USER_REG)
                                                <h4 class="media-heading" style="background-color:lightgreen;">
                                                    <a href="profile/{{$user->id}}">{{$user->name}}</a>
                                                    a new user has joined our community! 😍
                                                </h4>
                                                @break
                                                @case(App\constants\Actions::ACTION_POST_DELETE)
                                                <h4 class="media-heading">
                                                    <a href="profile/{{$user->id}}">{{$user->name}}</a>
                                                    has deleted their post! 🤔
                                                </h4>
                                                @break
                                                @case(App\constants\Actions::ACTION_POST)
                                                <h4 class="media-heading">
                                                    <a href="profile/{{$user->id}}">{{$user->name}}</a>
                                                    has added a new
                                                    <a href="posts/{{$actionId}}"> post!</a>! ✔
                                                </h4>
                                                @break
                                                @case(App\constants\Actions::ACTION_POST_EDIT)
                                                <h4 class="media-heading">
                                                    <a href="profile/{{$user->id}}">{{$user->name}}</a>
                                                    has edited their
                                                    <a href="posts/{{$actionId}}"> post!</a>! 👀
                                                </h4>
                                                @break
                                                @case(App\constants\Actions::ACTION_COMMENT_DELETE)
                                                <h4 class="media-heading">
                                                    <a href="profile/{{$user->id}}">{{$user->name}}</a>
                                                    has deleted their comment! (⊙_⊙;)
                                                </h4>
                                                @break
                                                @case(App\constants\Actions::ACTION_COMMENT_EDIT)
                                                <h4 class="media-heading">
                                                    <a href="profile/{{$user->id}}">{{$user->name}}</a>
                                                    has edited their
                                                    <a href="posts/{{$actionId}}"> comment!</a>! 🤷‍
                                                </h4>
                                                @break
                                                @case(App\constants\Actions::ACTION_COMMENT)
                                                <h4 class="media-heading">
                                                    <a href="profile/{{$user->id}}">{{$user->name}}</a>
                                                    has added a new
                                                    <a href="posts/{{$actionId}}"> comment!</a>! (⌐■_■)
                                                </h4>
                                                @break
                                                @case(App\constants\Actions::ACTION_LIKE)
                                                <h4 class="media-heading">
                                                    <a href="profile/{{$user->id}}">{{$user->name}}</a>
                                                    has liked this
                                                    <a href="posts/{{$actionId}}"> post!</a>! 👌
                                                </h4>
                                                @break
                                                @case(App\constants\Actions::ACTION_DISLIKE)
                                                <h4 class="media-heading">
                                                    <a href="profile/{{$user->id}}">{{$user->name}}</a>
                                                    has disliked this
                                                    <a href="posts/{{$actionId}}"> post!</a>! (╯°□°）╯︵ ┻━┻
                                                </h4>
                                                @break
                                            @endswitch
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h2 class="media-heading"> It seems empty here ! 👀 👀 </h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

