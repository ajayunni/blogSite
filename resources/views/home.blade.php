@extends('layouts.app')
@section('content')
        <div class="container">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="well well-sm">
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                @if(auth()->user()->profile_image==="")
                                    <img src="http://placekitten.com/150/150" alt="" class="img-rounded img-responsive" />
                                @else
                                    <img style="width: 150px;height: 150px;" class="media-object" src="/storage/profile_images/{{auth()->user()->profile_image}}">
                                @endif
                            </div>
                            <div class="col-sm-6 col-md-8">
                                <h4>{{auth()->user()->name}}</h4>
                                <p style="color: darkred">Add a new profile Pic</p>
                                {!! Form::open(['action' => 'UserController@update','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                                <div class="form-group">
                                    {{Form::file('profile_image')}}
                                </div>
                                {!! Form::hidden('user_id', auth()->user()->id) !!}
                                {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="posts/create" class="btn btn-outline-secondary">Create Post</a>
                    <hr>
                    <h3>Your Posts</h3>
                    @if(count($posts)>0)
                            @foreach($posts as $post)
                                <div class="container">
                                    <div class="well">
                                        <div class="media">
                                            <a class="pull-left" href="posts/{{$post->id}}">
                                                @if($post->cover_image!='noimage.jpeg')
                                                    <img style="width: 150px;height: 150px;" class="media-object" src="/storage/cover_images/{{$post->cover_image}}">
                                                @else
                                                    <img class="media-object" src="http://placekitten.com/150/150">
                                                @endif
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading">{{$post->title}}</h4>
                                                @php
                                                    $text = strip_tags(substr($post->body,0,50));
                                                @endphp
                                                <p>{{$text}}.....<a href="posts/{{$post->id}}">Read more</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>You have no Posts!</p>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
