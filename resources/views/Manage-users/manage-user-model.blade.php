<!-- Modal -->
  <div class="modal fade" id="shop{{ $shop->id }}" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ $shop->shop_name }} Users <span style="color: green;" id="response" ></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- model body -->
      
  <div class="modal-body card card-small blog-comments">
    <div class="card-body p-0">
    @foreach($users as $user)
    @if($user->account_state !== 'Delete')
    @if($shop->id == $user->shop_id)
      <!-- start user -->
      <div class="blog-comments__item d-flex p-3">
        <div class="blog-comments__avatar mr-3">
          <img src="user/{{ $user->profile_pic }}" alt="{{ $user->username }} avatar"> </div>
        <div class="blog-comments__content">
          <div class="blog-comments__actions">
            <div class="btn-group btn-group-sm">

          <div class="custom-control custom-toggle custom-toggle-sm mb-1">
            <input type="checkbox" id="customToggle1" name="customToggle1" class="custom-control-input">
            <label class="custom-control-label" for="customToggle1">Default</label>
          </div>
          
          @if(Auth::user()->role == 'super_admin')
            <!-- ======================================== -->
            @if($user->account_state !== 'Verified')
              <form id="aprove_form{{ $user->id }}" action="/user-modification">
              {{ csrf_field() }}
                <button type="submit" id="approvebutton{{$user->id}}" class="btn btn-white">
                <input type="hidden" name="verify_user_id" value="{{$user->id}}">
                  <span class="text-success">
                    <i class="material-icons">check</i>
                  </span>Not Approved </button>
              </form>
            @elseif($user->account_state == 'Verified')
               <button type="button" class="btn btn-white ">
                <input type="hidden" name="verify_user_id" value="{{$user->id}}">
                  <span class="text-success">
                    <i class="material-icons">check</i>
                  </span>Approved </button>
            @endif <!-- verified user -->
            <!-- =============================== -->
          @else
            <button type="button" class="btn btn-white ">
                <input type="hidden" name="verify_user_id" value="{{$user->id}}">
                  <span class="text-success">
                    <i class="material-icons">check</i>
                  </span>Not Approved </button>
          @endif <!-- admin privilage -->

            <form id="delete_form{{ $user->id }}" action="/user-modification">
            {{ csrf_field() }}
            <input type="hidden" name="delete_user_id" value="{{$user->id}}">
              <button type="submit" id="deletebutton{{$user->id}}" class="btn btn-white">
                <span class="text-danger">
                  <i class="material-icons">clear</i>
                </span> Reject </button>
            </form>

            <!-- start user block  -->
            <button class="btn btn-white">
            <div class="custom-control custom-toggle custom-toggle-sm mb-1">
            <form id="block_form{{ $user->id }}" action="/user-modification">
            {{ csrf_field() }}
            @if($user->block_state !== 'Block')
            <input type="hidden" name="block_user_id" value="{{$user->id}}">
            <input type="checkbox" id="checkbox_block{{ $user->id }}" name="checkbox_block" class="custom-control-input">
            <label class="custom-control-label" id="lable_block{{ $user->id }}" checked="true" for="checkbox_block{{ $user->id }}">Unblock</label>
            @else
              <input type="hidden" name="unblock_user_id" value="{{$user->id}}">
              <input type="checkbox" id="checkbox_block{{ $user->id }}" name="checkbox_block" checked="" class="custom-control-input">
              <label class="custom-control-label" id="lable_block{{ $user->id }}" checked="true" for="checkbox_block{{ $user->id }}">Block</label>
            @endif
            </form>
            </div>
            </button>
            <!-- end user block  -->

            @if(Auth::user()->role == 'super_admin')
              <button class="btn btn-white">
                <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                <form id="promote_form{{ $user->id }}" action="/user-modification">
                {{ csrf_field() }}
                @if($user->role !== 'admin')
                <input type="hidden" name="promote_user_id" value="{{$user->id}}">
                <input type="checkbox" id="checkbox_promote{{ $user->id }}" name="checkbox_promote"  class="custom-control-input">
                <label class="custom-control-label" id="lable_promote{{ $user->id }}" for="checkbox_promote{{ $user->id }}">User</label>
                @else
                <input type="hidden" name="demote_user_id" value="{{$user->id}}">
                <input type="checkbox" id="checkbox_promote{{ $user->id }}" name="checkbox_promote" checked="" class="custom-control-input">
                <label class="custom-control-label" id="lable_promote{{ $user->id }}"  for="checkbox_promote{{ $user->id }}">Admin</label>
                @endif
                </form>
              </div>
              </button>
              @else
                @if($user->role == 'admin')
                <button class="btn btn-white">
                <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                <input type="checkbox" id="checkbox_promote{{ $user->id }}" name="checkbox_promote" disabled="" checked=""  class="custom-control-input">
                <label class="custom-control-label" id="lable_promote{{ $user->id }}" for="checkbox_promote{{ $user->id }}">Admin</label>
                </div>
              </button>
              @else
              <button class="btn btn-white">
                <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                <input type="checkbox" id="checkbox_promote{{ $user->id }}" name="checkbox_promote" disabled=""  class="custom-control-input">
                <label class="custom-control-label" id="lable_promote{{ $user->id }}"  for="checkbox_promote{{ $user->id }}">User</label>
                </div>
              </button>
              @endif
              @endif

            </div>
          </div>
          <div class="blog-comments__meta text-muted">
            <a class="text-secondary" href="#">{{ $user->username }}</a> created at 
            <span class="text-muted">{{ $user->created_at->diffForHumans() }}</span>
          </div>
        </div>
      </div>
      <!-- end user --> 
      @endif 
      <!-- shop filter -->
      @endif <!-- With out Delete Account -->
      @endforeach                   
    </div>
    <div class="modal-footer card-footer border-top">
      <div class="row">
        <div class="col text-center view-report">
          <button type="submit" class="btn btn-white" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
      </div>
    </div>
  </div>
  <!-- end model