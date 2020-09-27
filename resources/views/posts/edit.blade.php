@extends('layouts.app')
@section('content')
    <h1>Edit Post</h1>

    {!! Form::open(['action' => ['PostsController@update',$post->id],'method'=>'POST','enctype'=>'multipart/form-data']) !!}
    <div class="form-group">
        {{Form::label('title','Title')}}
        {{Form::text('title',$post->title,['class'=>'form-control','placeholder'=>'Title'])}}
    </div>
    <div class="form-group">
        {{Form::label('body','Body')}}
        {{Form::textarea('body',$post->body,['id'=>'text-box','class'=>'form-control','placeholder'=>'Write something insightful..'])}}
    </div>
    <div class="form-group">
        {{Form::label('image','Add an image')}}
        <input type="file" class="imgur" accept="image/*" data-max-size="5000" />
        {{Form::label('cover_image','Add Cover Image')}}
        {{Form::file('cover_image')}}
    </div>
    {{Form::hidden('_method','PUT')}}
    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
    @include('inc.upload_imgur')
@endsection
