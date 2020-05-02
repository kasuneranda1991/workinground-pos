@extends('master')
@section('header')
<style type="text/css">
  .pulse-btn {
    text-align: center;
    /*padding: 30px 0;*/
}
.pulse-btn .btn {
    font-size: 22px;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 0.5em 1.5em;
    animation: pulse 1.5s cubic-bezier(0.66, 0.67, 0.83, 0.99) infinite;
}
@media (max-width: 767px) {
    .pulse-btn .btn {
        font-size: 16px;
        letter-spacing: normal;
        padding: 10px 15px;
    }
}
@keyframes pulse {
    0% {
        outline: 1px solid #428bca;
        outline-offset: 0px;
    }
    30% {
        outline: 1px solid rgba(48, 113, 169, 0.7);
        outline-offset: 10px;
    }
    60% {
        outline: 1px solid rgba(48, 113, 169, 0);
        outline-offset: 20px;
    }
    100% {
        outline: 1px solid rgba(48, 113, 169, 0);
        outline-offset: 60px;
    }
}
</style>
@stop
@section('pageurl') Home > Receive Job @stop
@section('pagetitle') Your Pending Jobs @stop
@section('content')
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="Receive_job" data-toggle="tab" href="#receive" role="tab" aria-controls="receive" aria-selected="true">Working Job <span class="badge badge-pill badge-danger">{{ $workingjob }}</span> </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="Complete_Job" data-toggle="tab" href="#complete" role="tab" aria-controls="complete" aria-selected="false">Complete Job <span class="badge badge-pill badge-danger">{{ $completejob }}</span> </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="Cancel_Job" data-toggle="tab" href="#cancel" role="tab" aria-controls="cancel" aria-selected="false">Cancel Jobs <span class="badge badge-pill badge-danger">{{ $canceljob }}</span></a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="receive" role="tabpanel" aria-labelledby="Receive_job">
      @include('job.receive-job-include')
  </div>
  <div class="tab-pane fade" id="complete" role="tabpanel" aria-labelledby="complete-tab">
      @include('job.complete-job-model')
  </div>
  <div class="tab-pane fade" id="cancel" role="tabpanel" aria-labelledby="cancel-tab">
      @include('job.cancel-job-model')
  </div>
</div>
@stop