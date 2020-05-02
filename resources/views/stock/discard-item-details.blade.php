
<table class="ui celled selectable center aligned table" style="width:100%" id="discardItemTable">
  <thead>
    <tr>
      <th scope="col">Item Name</th>
      <th scope="col">Reason</th>
      <th data-orderable="false">Quantity</th>
      <th data-orderable="false">Batch NO</th>
      <th scope="col">Discard at</th>
      <th>Action</th>
    </tr>
  </thead>
</table>
<form id="discardItemApproveform" action="/getapprove" method="post">
 {{ csrf_field() }}
<input type="hidden" name="approve_id" id="approve_id">
<input type="hidden" name="disapprove_state" id="disapprove_state" value="0">
</form>
