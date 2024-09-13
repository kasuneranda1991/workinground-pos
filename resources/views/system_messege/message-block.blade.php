 @if(Session::has('success'))
            <!-- system alert -->
          <div id="success" class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-check mx-2"></i>
            <strong>Success!</strong> {{Session::get('success')}} </div>
          <!-- system alert -->
@endif
@if(Session::has('error'))
            <!-- system alert -->
          <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <i class="material-icons" style="font-size: 20px;">block</i>
            <strong>Error!</strong> {{Session::get('error')}} </div>
          <!-- system alert -->
@endif
@if(Session::has('login-error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> {{Session::get('login-error')}}.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif