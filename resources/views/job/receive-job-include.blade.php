@isset($jobs)
@foreach( $jobs as $job )
@if($job->state == 'working')
@if($job->shop_id == Auth::user()->shop_id)
<!-- job start -->
<div class="col-lg-12 col-sm-12 mb-12">
  <div class="card card-post card-post--aside card-post--1">
    <div class="card-post__image" style="background-image: url('shop/{{ Auth::user()->shop->logo  }}');background-size: contain;" >

      <a href="#" class="card-post__category badge badge-pill badge-dark">{{$job->priority}}</a>
    @if( $job->priority === 'urgent')
    <a href="#" class="card-post__category badge badge-pill badge-danger">{{$job->priority}}</a>
    @elseif($job->priority === 'one week')
    <a href="#" class="card-post__category badge badge-pill badge-success">{{$job->priority}}</a>
    @elseif($job->priority === 'one day')
    <a href="#" class="card-post__category badge badge-pill badge-warning">{{$job->priority}}</a>
    @else
    <a href="#" class="card-post__category badge badge-pill badge-success">{{$job->priority}}</a>
    @endif
      <div class="card-post__author d-flex">
    @foreach($users as $user)
    @if($job->user_id == $user->id)
        <a href="#" class="card-post__author-avatar card-post__author-avatar--small" style="background-image: url('user/{{ $user->profile_pic  }}');" data-toggle="tooltip" data-placement="right" title="Job Post by {{ $user->username }}"></a>
    @endif
    @endforeach
      </div>
    </div>
  <div class="card-body">
    <h5 class="card-title">
      <a class="text-fiord-blue" href="#">{{$job->description}}</a>
    </h5>
    @foreach($customers as $customer)
    @if($job->customer_id == $customer->id)
    <p class="card-text d-inline-block mb-3">{{$job->remark}} given by {{ $customer->name }} who lives on {{ $customer->address }} </p><br>
    <strong>{{ $customer->contact_no }} | {{ $customer->nic }}</strong><br><hr>
    <span class="text-muted">{{ $job->created_at->toFormattedDateString() }} - {{ $job->created_at->diffForHumans() }}</span><span class="float-right pulse-btn"> <input data-toggle="modal" data-target="#job_model{{ $job->id }}" class="btn btn-white" type="button" value="Rs.{{$job->job_price}}" ></span>
    @include('job.receive-job-model')
    @endif
    @endforeach
  </div>
  </div>
</div>
<!-- end job -->
<br>
@endif
@endif
@endforeach
@endisset