@if (count($errors) > 0)
<div class="container mt-4">
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissable fade show">
      <strong>Danger!</strong> {{ $error }}
      <button class="close" type="button" data-dismiss="alert" aria-label="Close">&times;</button>
    </div>
  @endforeach
</div>
@endif

@if (session('success'))
<div class="container mt-4">
  <div class="alert alert-success alert-dismissable fade show">
    <strong>Success!</strong> {{ session('success') }}
    <button class="close" type="button" data-dismiss="alert" aria-label="Close">&times;</button>
  </div>
</div>
@endif

@if (session('error'))
<div class="container mt-4">
  <div class="alert alert-danger alert-dismissabel fade show">
    <strong>Danger!</strong> {{ session('error') }}
    <button class="close" type="button" data-dismiss="alert" aria-label="Close">&times;</button>
  </div>
</div>
@endif
