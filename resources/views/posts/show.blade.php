@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
 			<li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
 			<li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
		</ol>
	</nav>
	<div class="row justify-content-md-center">
		<div class="col-8">
      <div class="row">
        <div class="col-1">
          <img src="{{ Gravatar::src($post->user->email) }}" width="40" class="rounded-circle" alt="Gavatar">
        </div>
        <div class="col-10">
          <div class="h3">{{ $post->user->name }}</div>
        </div>
        <div class="col-1">
				@auth
					@if (Auth::user()->id == $post->user_id)
        	<div class="dropdown">
  					<a class="btn-link dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    					<i class="fa fa-ellipsis-v"></i>
  					</a>
  					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
      				<a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}">Update</a>
							<button type="button" class="dropdown-item" data-toggle="modal" data-target="#delete">
  							Delete
							</button>
  					</div>
					</div> <!-- /.dropdown --> 
		      <div class="modal fade" id="delete" tabindex="-1" role="dialog">
    		    <div class="modal-dialog" role="document">
        		  <div class="modal-content">
            		<div class="modal-header">
		              <h5 class="modal-title">Deleting Post</h5>
    		          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        		        <span aria-hidden="true">&times;</span>
            		  </button>
		            </div>
    		        <div class="modal-body">
        		      <p>Are you sure you want to delete post {{ $post->title }}?</p>
            		</div>
		            <div class="modal-footer">
    		          <form action="{{ route('posts.destroy', $post->id) }}" method="post">
        		        @csrf
            		    @method('DELETE')
                		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		                <button type="submit" class="btn btn-danger">Delete post</button>
    		          </form>
        		    </div>
		          </div>
    		    </div>
		      </div> <!-- /.modal -->
					@endif
				@endauth
        </div>
      </div>
      <hr>
      @foreach($post->tags as $tag)
        <span class="badge badge-{{ $tag->status }}">{{ $tag->name }}</span>
      @endforeach
      <h2 class="mb-0">{{ $post->title }}</h2>
      <p class="text-muted">@date($post->created_at) by {{ $post->user->name }}</p>
      <div class="text-justify">{!! $post->body !!}</div>
      <hr>
      <a href="{{ route('posts.liked', $post->id) }}" style="color:black">
        @if ($is_liked)
          <i class="fa fa-thumbs-up"></i>
        @else
          <i class="fa fa-thumbs-o-up"></i>
        @endif
        {{ $post->likes }}
      </a>&nbsp;&nbsp;
      <a href="{{ route('posts.disliked', $post->id) }}" style="color:black">
        @if ($is_disliked)
          <i class="fa fa-thumbs-down"></i>
        @else
          <i class="fa fa-thumbs-o-down"></i>
        @endif
        {{ $post->dislikes }}
      </a>
      <br><br>
      <p>{{ $post->comments->count() }} Comments</p>
      @auth
      <!-- Comment Create -->
      <form action="{{ route('comments.store') }}" method="post" class="mb-3">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <div class="input-group">
          <input class="form-control" name="body" type="text" placeholder="Add a public comment...">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Submit</button>
          </div>
        </div>
      </form>
      @endauth

      @forelse ($comments as $comment)
        <hr>
        <div class="row">
          <div class="col-sm-1">
            <img src="{{ Gravatar::src($comment->user->email) }}" width="50" class="rounded-circle" alt="Gravatar">
          </div>
          <div class="col-sm-11">
            <div class="h3 mb-0">{{ $comment->user->name }}</div>
            <p class="text-muted"><small>{{ $comment->created_at }}</small></p>
            <p>{{ $comment->body }}</p>
						@auth
						@if (Auth::user()->id == $comment->user_id)
            <!-- Comment delete -->
            <button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#commentDelete{{ $comment->id }}">
							Comment delete
						</button>
						<!-- Modal -->
						<div class="modal fade" id="commentDelete{{ $comment->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  			<div class="modal-dialog" role="document">
			    			<div class="modal-content">
			      			<div class="modal-header">
			        			<h5 class="modal-title" id="modalLabel">Deleting comment</h5>
			        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          			<span aria-hidden="true">&times;</span>
      			  			</button>
			      			</div>
						      <div class="modal-body">
            			  <p>Are you sure you want to delete comment?</p>
			      			</div>
						      <div class="modal-footer">
            				<form action="{{ route('comments.destroy', $comment->id) }}" method="post">
			              	@csrf
      			        	@method('DELETE')
            			  	<input type="hidden" name="_post_id" value="{{ $post->id }}">
						        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      			        	<button class="btn btn-danger" type="submit">Delete comment</button>
            				</form>
						      </div>
						    </div>
						  </div>
						</div> <!-- /.modal -->
						@endif
						@endauth
          </div>
        </div>
      @empty
        <p>Comments Lists is Empty</p>
      @endforelse
    </div> <!-- /.col-8 -->
  </div> <!-- /.row -->
</div> <!-- /.container -->
@endsection
