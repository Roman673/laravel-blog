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
          <input type="hidden" name="redirectTo" value="{{ $redirectTo }}">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      		<button class="btn btn-danger" type="submit">Delete comment</button>
        </form>
			</div>
		</div>
	</div>
</div> <!-- /.modal -->
