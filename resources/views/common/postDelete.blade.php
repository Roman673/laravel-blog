<div class="modal fade" id="postDelete{{ $post->id }}" tabindex="-1" role="dialog">
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
          <input type="hidden" name="redirectTo" value="{{ $redirectTo }}">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      <button type="submit" class="btn btn-danger">Delete post</button>
    		</form>
      </div>
		</div>
  </div>
</div> <!-- /.modal -->
