@extends('layouts.app')
@section('content')
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
                                                <p>{{substr($post->body,0,50)}}.....<a href="posts/{{$post->id}}">Read more</a></p>
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
