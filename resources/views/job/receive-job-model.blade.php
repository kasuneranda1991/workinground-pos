<!-- Modal -->
<div class="modal fade" id="job_model{{ $job->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ $job->description }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <form action="/jobactivity" method="post">
      {{ csrf_field() }}
        <input type="hidden" name="cancel_job_id" value="{{ $job->id }}">
        <button type="submit" class="btn btn-outline-danger">Cancel Job</button>
      </form>
      <form action="/jobactivity" method="post">
      {{ csrf_field() }}
        <input type="hidden" name="finish_job_id" value="{{ $job->id }}">
        <button type="submit" class="btn btn-outline-success">Finish Job</button>
      </form>
      </div>
    </div>
  </div>
</div>