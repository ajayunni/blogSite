<div class="media mb-4">
    @php
        $theCommenter = \App\User::find($reply->user_id)
    @endphp
    @if($theCommenter->profile_image!="")
        <img style="height: 50px;width: 50px;" class="d-flex mr-3 rounded-circle" src="/storage/profile_images/{{$theCommenter->profile_image}}" alt="">
    @else
        <img class="d-flex mr-3 rounded-circle" src="http://placekitten.com/50/50" alt="">
    @endif
    <div class="media-body">
        <h5 class="mt-0"><h5 class="mt-0"><a href="{!! route('profile', ['user_id'=>$reply->user_id]) !!}">{{$reply->user_name}}</a></h5></h5>
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
