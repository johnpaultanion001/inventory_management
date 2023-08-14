@extends('../layouts.admin')
@section('sub-title','Staff List')
@section('navbar')
    @include('../partials.admin.navbar')
@endsection
@section('sidebar')
    @include('../partials.admin.sidebar')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-2">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-md-10">
                                <h4 class="mb-0 text-uppercase" id="titletable">Manage Staff</h4>
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="create_record" class="btn btn-sm btn-dark">New Staff</button>
                            </div>

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" width="100%">
                            <thead class="text-uppercase thead-white">
                                <tr class="text-uppercase">
                                  <th  scope="col">ACTIONS</th>
                                  <th  scope="col">NAME</th>
                                  <th  scope="col">EMAIL</th>
                                  <th scope="col">CREATED AT</th>
                                </tr>
                            </thead>
                            <tbody class="font-weight-bold">
                                @foreach($admins as $admin)
                                <tr>
                                  <td>
                                    <button type="button" name="edit" edit="{{  $admin->id ?? '' }}"  class="edit  btn btn-sm btn-info">Edit Info</button>
                                  </td>

                                  <td>
                                      {{  $admin->name ?? '' }}
                                  </td>
                                  <td>
                                      {{  $admin->email ?? '' }}
                                  </td>

                                  <td>
                                      {{ $admin->created_at->format('M j , Y h:i A') }}
                                  </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="post" id="myForm" class="contact-form">
      @csrf
      <div class="modal fade" id="formModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-uppercase">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <i class="fas fa-times text-primary"></i>
              </button>
            </div>
            <div class="modal-body">


                  <div class="form-group">
                          <label class="form-label text-uppercase">Email <span class="text-danger">*</span></label>
                          <input type="email" name="email" id="email" class="form-control">
                    <span class="invalid-feedback" role="alert">
                        <strong id="error-email"></strong>
                      </span>
                  </div>

                  <div class="form-group">
                          <label class="form-label text-uppercase">Name <span class="text-danger">*</span></label>
                          <input type="name" name="name" id="name" class="form-control" >
                        <span class="invalid-feedback" role="alert">
                            <strong id="error-name"></strong>
                        </span>
                  </div>

                  <div class="form-group">
                          <label class="form-label text-uppercase">Password <span class="text-danger">*</span></label>
                          <input type="password" name="password" id="password" class="form-control" >
                        <span class="invalid-feedback" role="alert">
                            <strong id="error-password"></strong>
                        </span>
                  </div>
                    <hr>
                  <div class="form-group">
                          <label class="form-label text-uppercase">SIGN IN PASSWORD <span class="text-danger">*</span></label>
                          <input type="password" name="sign_in_password" id="sign_in_password" class="form-control" >
                            <span class="invalid-feedback" role="alert">
                                <strong id="error-sign_in_password"></strong>
                            </span>
                  </div>

                  <input type="hidden" name="action" id="action" value="Add" />
                  <input type="hidden" name="hidden_id" id="hidden_id" />

            </div>


            <div class="modal-footer">
              <input type="submit" name="action_button" id="action_button" class="btn btn-primary" value="Save" />
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    @section('footer')
        @include('../partials.admin.footer')
    @endsection
@endsection


@section('script')
<script>
  $(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    $.extend(true, $.fn.dataTable.defaults, {
      sale: [[ 1, 'desc' ]],
      pageLength: 25,
      'columnDefs': [{ 'orderable': false, 'targets': 0 }],
    });
    $('.datatable-table:not(.ajaxTable)').DataTable({ buttons: dtButtons })
      $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
          $($.fn.dataTable.tables(true)).DataTable()
              .columns.adjust();
      });
  });
  $(document).on('click', '.edit', function(){
      $('#formModal').modal('show');
      $('.modal-title').text('Update Information');
      $('#myForm')[0].reset();
      $('.form-control').removeClass('is-invalid');
      $('.input-group').addClass('is-filled');

      var id = $(this).attr('edit');
      $('#hidden_id').val(id);
      $.ajax({
          url :"/admin/customer_list/"+id+"/edit",
          dataType:"json",
          beforeSend:function(){
              $("#action_button").attr("disabled", true);
              $("#action_button").attr("value", "Loading..");
          },
          success:function(data){
              if($('#action').val() == 'Edit'){
                  $("#action_button").attr("disabled", false);
                  $("#action_button").attr("value", "Update");
              }else{
                  $("#action_button").attr("disabled", false);
                  $("#action_button").attr("value", "Submit");
              }
              $.each(data.result, function(key,value){
                if(key == $('#'+key).attr('id')){
                    $('#'+key).val(value)
                }
              })

              $('#action_button').val('Update');
              $('#action').val('Edit');
              $('#email').attr('readonly', true);
              $('#password_default').show();
          }
      })
  });
  $('#myForm').on('submit', function(event){
    event.preventDefault();

    var action_url = "{{ route('admin.staff.store') }}";
    var type = "POST";

    if($('#action').val() == 'Edit'){
        var id = $('#hidden_id').val();
        action_url = "/admin/staff_list/" + id;
        type = "PUT";
    }
    $.ajax({
        url: action_url,
        method:type,
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function(){
            $("#action_button").attr("disabled", true);
        },
        success:function(data){
            $("#action_button").attr("disabled", false);
            if(data.errors){
                $.each(data.errors, function(key,value){

                    if(key == $('#'+key).attr('id')){
                        $('#'+key).addClass('is-invalid')
                        $('#error-'+key).text(value)
                    }
                })
            }
            if(data.success){
                $('.form-control').removeClass('is-invalid')
                $('#myForm')[0].reset();
                $('#formModal').modal('hide');
                $.confirm({
                    title: 'Confirmation',
                    content: data.success,
                    type: 'green',
                    buttons: {
                            confirm: {
                                text: 'confirm',
                                btnClass: 'btn-blue',
                                keys: ['enter', 'shift'],
                                action: function(){
                                    location.reload();
                                }
                            },

                        }
                    });
            }

        }
    });
  });

    $(document).on('click', '#create_record', function(){
        $('#formModal').modal('show');
        $('#myForm')[0].reset();
        $('.form-control').removeClass('is-invalid')
        $('.modal-title').text('Add New Staff');
        $('#action_button').val('Submit');
        $('#action').val('Add');
        $('#password_default').hide();
        $('#email').attr('readonly', false);
    });
</script>
@endsection


