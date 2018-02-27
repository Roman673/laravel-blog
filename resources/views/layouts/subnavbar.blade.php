<div class="list-group mb-3">
  <a href="{{ route('posts.index') }}" class="list-group-item list-group-item-action 
		@if(Request::fullUrl() == route('posts.index')) active @endif">All posts</a>
  <a href="{{ route('posts.orderByCreated') }}" class="list-group-item list-group-item-action
    @if(Request::fullUrl() == route('posts.orderByCreated')) active @endif">New posts</a>
  <a href="{{ route('posts.orderByViews') }}" class="list-group-item list-group-item-action
    @if(Request::fullUrl() == route('posts.orderByViews')) active @endif">Most viewed</a>
  <a href="{{ route('posts.orderByLikes') }}" class="list-group-item list-group-item-action
    @if(Request::fullUrl() == route('posts.orderByLikes')) active @endif">Most liked</a>
  <a href="{{ route('posts.orderByComments') }}" class="list-group-item list-group-item-action
    @if(Request::fullUrl() == route('posts.orderByComments')) active @endif">Most commented</a>
</div>
