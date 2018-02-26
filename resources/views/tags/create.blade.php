@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('tags.index') }}">Tags</a></li>
<li class="breadcrumb-item active" aria-current="page">Creating tag</li>
@endsection

@section('content')
<section class="row">
  <div class="col-md-8">
    <div class="card card-default">
      <div class="card-header">Creating Tag</div>
      <div class="card-body">
        <form method="POST" action="{{ route('tags.store') }}">
          @csrf
          <div class="form-group row">
            <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
            <div class="col-md-6">
              <input id="name" type="name" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
            </div>
          </div>
          <div class="form-group row">
            <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
            <div class="col-md-6">
              <select id="status" class="form-control" name="status" required>
                @foreach($statuses as $status)
                <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
              <button type="submit" class="btn btn-primary">
                Add tag
              </button>
            </div>
          </div>
        </form>
      </div> <!-- /.card-body -->
    </div> <!-- /.card -->
  </div> <!-- /.col-md-8 -->
  <aside class="col-md-4">
    @include('common.sidebar')
  </aside>
</section> <!-- /.row -->
@endsection
