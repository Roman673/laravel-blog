@extends('layouts.app')

@section('title', "Edit $post->title")

@section('content')
<div class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card card-default">
        <div class="card-header">Edit {{ $post->title }}</div>
        <div class="card-body">
          <form action="{{ route('posts.update', $post->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="title"><b>Title</b></label>
              <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : ''}}" type="text" name="title" value="{{ $post->title }}" required autofocus>
              @if ($errors->has('title'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('title') }}</strong>
                </span>
              @endif
            </div> <!-- /.form-group -->

            <div class="form-group">
              <label for="ckeditor"><b>Body</b></label>
              <textarea id="ckeditor" class="form-control{{ $errors->has('body') ? ' is-invalid' : ''}}" name="body" cols="30" rows="10" required>
                {{ $post->body }}
              </textarea>
              @if ($errors->has('body'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('body') }}</strong>
                </span>
              @endif
            </div> <!-- /.form-group -->
            
            <button class="btn btn-primary" type="submit">Submit</button>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
