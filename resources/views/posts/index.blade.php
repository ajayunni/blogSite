@extends('layouts.app')
@section('content')
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
                        <p class="text-right">By {{$post->user->name}}</p>
                        <p>{{substr($post->body,0,50)}}.....<a href="posts/{{$post->id}}">Read more</a></p>
                        <ul class="list-inline list-unstyled">
                            <li><span><i style="color: grey;" class="glyphicon glyphicon-calendar"></i> {{$post->created_at->diffForHumans()}}</span></li>
                            <li>|</li>
                            <span><i style="color: blue;" class="glyphicon glyphicon-comment"></i> {{($post->howManyComments())}} comments</span>
                            <li>|</li>
                            <span><i style="color: red;" class="fa fa-heart"></i> {{($post->howManyLikes())}} likes</span>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
