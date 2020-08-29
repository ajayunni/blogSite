<div class="media mb-4">
    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
    <div class="media-body">
        <h5 class="mt-0">{{$reply->user_name}}</h5>
        {{$reply->body}}
        <div class="pull-right">
            {{$reply->created_at->diffForHumans() }}
            <a href="{{url()->current()}}/comments/{{$reply->id}}/reply">reply</a>
        @if(!Auth::guest()&&Auth::user()->id==$reply->user_id)
                <a href="/posts/comments/{{$reply->id}}/edit" class="btn btn-light">Edit</a>
                {!!Form::open(['action'=>['CommentsController@destroy',$reply->id],
                'method'=>'POST','style'=>'display:inline-block'])!!}
                {{Form::hidden('_method','DELETE')}}
                {{Form::submit('Delete',['class'=>'btn btn-light'])}}
                {!!Form::close()!!}
            @endif
        </div>
    </div>
</div>
@if($reply->replies!=null)
    <ul>@each('comments.replies',$reply->replies,'reply')</ul>
@endif
