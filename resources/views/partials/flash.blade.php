@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle" aria-hidden="true"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif
