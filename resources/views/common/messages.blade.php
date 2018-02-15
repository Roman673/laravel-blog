<div class="container mt-4">
@if (count($errors) > 0)
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissable fade show">
      <strong>Danger!</strong> {{ $error }}
      <button class="close" type="button" data-dismiss="alert" aria-label="Close">&times;</button>
    </div>
  @endforeach
@endif

@if (session('success'))
  <div class="alert alert-success alert-dismissable fade show">
    <strong>Success!</strong> {{ session('success') }}
    <button class="close" type="button" data-dismiss="alert" aria-label="Close">&times;</button>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger alert-dismissabel fade show">
    <strong>Success!</strong> {{ session('error') }}
    <button class="close" type="button" data-dismiss="alert" aria-label="Close">&times;</button>
  </div>
@endif
</div>
