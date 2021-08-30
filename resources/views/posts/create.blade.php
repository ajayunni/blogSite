@extends('layouts.app')
@section('content')
    <h1>Create Post</h1>

    {!! Form::open(['action' => 'PostsController@store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('title','Title')}}
        {{Form::text('title','',['class'=>'form-control','placeholder'=>'Title'])}}
    </div>
    <div class="form-group">
        {{Form::label('body','Body')}}
        {{Form::textarea('body','',['id'=>'text-box','class'=>'form-control','placeholder'=>'Write something insightful..'])}}
    </div>
    <div class="form-group">
        {{Form::label('cover_image','Cover Image')}}
        {{Form::file('cover_image',['class'=>"cover_image"])}}
    </div>
    <div class="form-group">
        {{Form::label('image','Add an image')}}
        {{Form::file('image',['class'=>"post_image"])}}
    </div>
    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    @include('inc.upload_imgur')
@endsection
