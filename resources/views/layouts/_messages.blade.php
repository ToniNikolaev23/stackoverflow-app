@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> {{session('success')}}.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif


@if(session('update'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Success!</strong> {{session('update')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif

@if(session('delete'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Removed!</strong> {{session('delete')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

@endif