@extends('layouts.app')

@section('content')
<section class="row">
  <div class="col-md-2">
    <img src="{{ Gravatar::src(Auth::user()->email) }}" width="120" class="rounded" alt="Gravatar">
  </div>
  <div class="col-md-10">
    <div class="card card-default">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="tabs">
          <li class="nav-item">
            <a class="nav-link active" id="dash-tab" data-toggle="tab" href="#dash" aria-controls="dash" aria-selected="true">
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="post-tab" data-toggle="tab" href="#post" aria-controls="post" aria-selected="false">
              Posts
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="comment-tab" data-toggle="tab" href="#comment" aria-controls="comment" aria-selected="false">
              Comments
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="liked-tab" data-toggle="tab" href="#liked" aria-controls="liked" aria-selected="false">
              Liked posts
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="disliked-tab" data-toggle="tab" href="#disliked" aria-controls="disliked" aria-selected="false">
              Disliked posts
            </a>
          </li>
        </ul>  
      </div>

      <div class="card-body">
        <div class="tab-content">
          <div id="dash" class="tab-pane fade show active" aria-labelledby="dash-tab">
            <h5 class="card-title">Dashboard</h5>
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif

            You are logged in!
          </div> <!-- /.tab-pane -->
          <div id="post" class="tab-pane fade" aria-labelledby="post-tab">
            @if (count(Auth::user()->posts) > 0)
            <table class="table table-striped table-bordered table-sm">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Title</th>
                  <th scope="col"><i class="fa fa-comment"></i></th>
                  <th scope="col"><i class="fa fa-eye"></i></th>
                  <th scope="col"><i class="fa fa-thumbs-up"></i></th>
                  <th scope="col"><i class="fa fa-thumbs-down"></i></th>
                  <th scope="col">Created at</th>
                  <th scope="col">Updated at</th>
                  <th scope="col">Update</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>
                @foreach (Auth::user()->posts as $post)
                <tr>
                  <th scope="row">{{ $post->id }}</th>
                  <td><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></td>
                  <td>{{ $post->comments }}</td>
                  <td>{{ $post->views }}</td>
                  <td>{{ $post->likes }}</td>
                  <td>{{ $post->dislikes }}</td>
                  <td>{{ $post->created_at }}</td>
                  <td>{{ $post->updated_at }}</td>
                  <td>
                    <a class="btn btn-sm btn-outline-warning" href="{{ route('posts.edit', $post->id) }}">
                      Update
                    </a>
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#postDelete{{ $post->id }}">
                      Delete
                    </button>
                    @include('common.postDelete', ['redirectTo' => 'dashboard'])
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
              <h5 class="card-title">You do not have any posts</h5>
            @endif
          </div> <!-- /.tab-pane -->
          <div id="comment" class="tab-pane fade" aria-labelledby="comment-tab">
            @if (count(Auth::user()->comments) > 0)
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Post's</th>
                  <th scope="col">Created at</th>
                  <th scope="col">Body</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>
                @foreach (Auth::user()->comments as $comment)
                <tr>
                  <th scope="row">{{ $comment->id }}</th>
                  <td>
                    <a href="{{ route('posts.show', $comment->post->id) }}">
                      {{ $comment->post->title }}
                    </a>
                  </td>
                  <td>{{ $comment->created_at }}</td>
                  <td>{{ $comment->body }}</td>
                  <td>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#commentDelete{{ $comment->id }}">
                      Delete
                    </button>
                    @include('common.commentDelete', ['redirectTo' => 'dashboard'])
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
              <h5 class="card-title">You do not have any comments</h5>
            @endif
          </div> <!-- /.tab-pane -->
          <div id="liked" class="tab-pane fade" aria-labelledby="liked-tab">
            @if (count($liked_posts) > 0)
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($liked_posts as $liked)
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                      <a href="{{ route('posts.show', $liked->post->id) }}">
                        {{ $liked->post->title }}
                      </a>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            @else
              <h5 class="card-title">You do not have any liked/disliked posts</h5>
            @endif
          </div> <!-- /.tab-pane -->
          <div id="disliked" class="tab-pane fade" aria-labelledby="disliked-tab">
            @if (count($disliked_posts) > 0)
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($disliked_posts as $disliked)
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                      <a href="{{ route('posts.show', $disliked->post->id) }}">
                        {{ $disliked->post->title }}
                      </a>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            @else
              <h5 class="card-title">You do not have any liked/disliked posts</h5>
            @endif
          </div> <!-- /.tab-pane -->
        </div> <!-- /.tab-content -->
      </div>
    </div>
  </div>
</section>
@endsection
