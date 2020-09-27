@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Title -->
                <div style="display: flex; flex-direction: row;">
                    <span><h1 class="mt-"4>{{$post->title}}</h1></span>
                    {!! $liked=false !!}
                    @if(!Auth::guest())
                        @foreach($post->likes as $like)
                            @if($like->user_id==Auth::user()->id)
                                @php
                                  $liked=true
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    @if(!Auth::guest())
                    <span>
                        {!! Form::open(['action' => ['LikesController@store',$post->id],'method'=>'POST']) !!}
                        @if($liked){{Form::button('<i style="color:red;" class="fa fa-3x fa-heart" aria-hidden="true" id="heart"></i>',array('class'=>'btn ', 'type'=>'submit'))}}
                        @else{{Form::button('<i style="color:black;" class="fa fa-3x fa-heart" aria-hidden="true" id="heart"></i>',array('class'=>'btn ', 'type'=>'submit'))}}
                        @endif
                        {!! Form::hidden('post_id', $post->id) !!}
                        {!! Form::hidden('user_name', Auth::user()->name) !!}
                        {!! Form::close() !!}
                    </span>
                    @else
                        {{Form::button('<i style="color:grey;" class="fa fa-3x fa-heart" aria-hidden="true" id="heart"></i>',array('class'=>'btn ', 'type'=>'button'))}}
                    @endif
                    @if($post->howManyLikes()>0)
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                @foreach($post->likes as $like)
                                    <a class="dropdown-item" href="{!! route('profile', ['user_id'=>$like->user_id]) !!}">{{$like->user_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Author -->
                <p class="lead">
                    by
                    <a href="{!! route('profile', ['user_id'=>$post->user->id]) !!}">{{$post->user->name}}</a>
                </p>
                <!-- Date/Time -->
                <p>Posted on {{$post->created_at->format('d M,Y')}}</p>
                @if($post->cover_image!=null)
                    <!-- Preview Image -->
                    <img style="display: block; margin-left: auto; margin-right: auto;" class="img-fluid rounded" src="/storage/cover_images/{{$post->cover_image}}" alt="">
                @endif
                <hr>
                <p>
                    {!! $post->body !!}
                </p>
                <hr>
                @if(!Auth::guest()&&Auth::user()->id==$post->user_id)
                    <a href="/posts/{{$post->id}}/edit" class="btn btn-light">Edit</a>
                    {!!Form::open(['action'=>['PostsController@destroy',$post->id],
                    'method'=>'POST','style'=>'display:inline-block'])!!}
                    {{Form::hidden('_method','DELETE')}}
                    {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
                    {!!Form::close()!!}
                    <hr>
                @endif
                @if(!Auth::guest())
                    <!-- Comments Form -->
                    <div class="card my-4">
                        <h5 class="card-header">Leave a Comment:</h5>
                        <div class="card-body">
                            {!! Form::open(['action' => ['CommentsController@store'],'method'=>'POST']) !!}
                                <div class="form-group">
                                    {{Form::textarea('body','',['class'=>'comment form-control','placeholder'=>'Write something insightful..'])}}
                                </div>
                            {!! Form::hidden('post_id', $post->id) !!}
                            {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
                            {!! Form::close() !!}
                        </div>
                    </div>
                @else
                    Please <a href="{{ route('login')}}">LOGIN</a> to drop a comment.
                    <hr>
                @endif
                <!-- Comment with nested comments -->
                @foreach ($post->comments as $comment)
                    @if($comment->parent_id!=null)
                        @continue;
                    @endif
                    <div class="media mb-4">
                        @php
                            $theCommenter = \App\User::find($comment->user_id)
                        @endphp
                        @if($theCommenter->profile_image!="")
                            <img style="height: 50px;width: 50px;" class="d-flex mr-3 rounded-circle" src="/storage/profile_images/{{$theCommenter->profile_image}}" alt="">
                        @else
                            <img class="d-flex mr-3 rounded-circle" src="http://placekitten.com/50/50" alt="">
                        @endif

                        <div class="media-body">
                            <h5 class="mt-0"><a href="{!! route('profile', ['user_id'=>$comment->user_id]) !!}">{{$comment->user_name}}</a></h5>
                            {{$comment->body}}
                            <div class="pull-right">
                                {{$comment->created_at->diffForHumans() }}
                                @if(!Auth::guest())
                                    <a href="{{$post->id}}/comments/{{$comment->id}}/reply">reply</a>
                                @endif
                                @if(!Auth::guest()&&Auth::user()->id==$comment->user_id)
                                    <a href="/posts/comments/{{$comment->id}}/edit" class="btn btn-light">Edit</a>
                                    {!!Form::open(['action'=>['CommentsController@destroy',$comment->id],
                                    'method'=>'POST','style'=>'display:inline-block'])!!}
                                    {{Form::hidden('_method','DELETE')}}
                                    {{Form::submit('Delete',['class'=>'btn btn-light'])}}
                                    {!!Form::close()!!}
                                @endif
                            </div>
                            @if ($comment->replies!=null)
                                @foreach ($comment->replies as $reply)
                                    @include('comments.replies')
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <hr>
@endsection
