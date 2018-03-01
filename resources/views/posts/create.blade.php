@extends('layouts.app')

@section('content')
<section class="row">
  <div class="col-md-8">
    <div class="card card-default">
      <div class="card-header">Create Post</div>
      <div class="card-body">
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="tags" ><b>Status</b></label>
            <select id="tags" class="form-control" name="tags[]" multiple>
              @foreach($tags as $tag)
              <option value="{{ $tag->id }}">{{ $tag->name }}</option>
              @endforeach
            </select>
          </div> <!-- /.form-group -->
          
          <div class="form-group">
            <label for="title"><b>Title</b></label>
            <input id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : ''}}" type="text" name="title" required autofocus>
            @if ($errors->has('title'))
              <span class="invalid-feedback">
                <strong>{{ $errors->first('title') }}</strong>
              </span>
            @endif
          </div> <!-- /.form-group -->

          <div class="form-group">
            <label for="ckeditor"><b>Body</b></label>
            <textarea id="ckeditor" class="form-control{{ $errors->has('body') ? ' is-invalid' : ''}}" name="body" cols="30" rows="10" required>
            </textarea>
            @if ($errors->has('body'))
              <span class="invalid-feedback">
                <strong>{{ $errors->first('body') }}</strong>
              </span>
            @endif
          </div> <!-- /.form-group -->
          
          <div class="form-group">
            <label for="cover_image">Cover Image</label>
            <input id="cover_image" class="form-control-file" type="file" name="cover_image">
          </div>

          <button class="btn btn-primary" type="submit">Submit</button>

        </form>
      </div>
    </div>
  </div> <!-- /.col-md-8 -->
  <aside class="col-md-4">
    @include('common.sidebar')
  </aside>
</section>
@endsection

@section('script')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script>CKEDITOR.replace('ckeditor');</script>
@endsection
