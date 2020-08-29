@extends('layouts.app')
@section('content')
    <h1>Reply Comment</h1>
    {!! Form::open(['action' => 'CommentsController@store','method'=>'POST']) !!}
    <div class="form-group">
        {{Form::textarea('body','',['class'=>'form-control','placeholder'=>'Write something insightful..'])}}
    </div>
    {!! Form::hidden('post_id', $post_id) !!}
    {!! Form::hidden('comment_id', $comment_id) !!}
    {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
