<div class="row"><!-- Start Row -->

@foreach($payments as $payment)<!-- payment foreach start -->
@if(Auth::user()->role == 'super_admin')

@else
  <!-- ========= -->
  @if(Auth::user()->shop_id == $payment->shop_id)
    @if($payment->state == 'Pending' || $payment->state == 'Due_Payment')
    <div class="col-lg-4">
      <div class="card card-small card-post mb-4">
        <div class="card-body">
          <h5 class="card-title">{{ $payment->type }}</h5>
            <p class="card-text text-warning">
            Please,wait for confirmation.....
            </p>
        </div>
        <div class="card-footer border-top d-flex">
          <div class="card-post__author d-flex">
            <div class="d-flex flex-column justify-content-center ml-3">
            <span class="card-post__author-name">Payment ID:{{$payment->id}}</span> 
              <small class="text-muted">{{ \Carbon\Carbon::parse($payment->created_at)->toDateTimeString() }}</small>
            </div>
         </div>
          <div class="my-auto ml-auto">
            @if($payment->state == 'Accepted')
            <a class="btn btn-sm btn-success disabled" href="#"><i class="fa check-square-o mr-1"></i> Accepted </a>
            @elseif($payment->state == 'Rejected')
            <a class="btn btn-sm btn-danger disabled" href="#"><i class="fa check-square-o mr-1"></i> Rejected </a>
            @else
            <a href="#" data-toggle="tooltip" data-placement="right" title="Payment under Inspection,This will take few hours" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('loading/proccess.gif');">Proccesing</a>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endif
  @endif
  <!-- ========== -->
@endif
@endforeach <!-- end payment foreach -->
</div><!-- End Row -->