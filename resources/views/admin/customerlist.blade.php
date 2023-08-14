@extends('../layouts.admin')
@section('sub-title','Customers')
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
                            <div class="col-md-11">
                                <h4 class="mb-0 text-uppercase" id="titletable">Manage Customers</h4>
                            </div>


                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" width="100%">
                            <thead class="text-uppercase thead-white">
                                <tr class="text-uppercase">
                                  <th  scope="col">Actions</th>
                                  <th  scope="col">Account Status</th>
                                  <th  scope="col">ID Image</th>
                                  <th  scope="col">NAME</th>
                                  <th  scope="col">EMAIL</th>
                                  <th  scope="col">CONTACT NUMBER</th>
                                  <th  scope="col">ADDRESS</th>
                                  <th  scope="col">CREATED AT</th>
                                </tr>
                            </thead>
                            <tbody class="font-weight-bold">
                                @foreach($customers as $customer)
                                <tr>

                                  <td>
                                  <button type="button" name="edit" edit="{{  $customer->id ?? '' }}"  class="edit  btn btn-sm btn-info">Edit Info</button>
                                  </td>
                                  <td>
                                        <button type="button" name="status" status="{{  $customer->id ?? '' }}"
                                            class="btn btn-sm
                                            @if($customer->isApproved == true)
                                                btn-success status
                                            @else
                                                btn-warning status
                                            @endif">
                                            @if($customer->isApproved == true)
                                                APPROVED
                                            @else
                                                PENDING
                                            @endif
                                        </button>
                                  </td>
                                  <td>
                                    <a href="{{URL::asset('/assets/img/id_image/'.$customer->id_image)}}" target="_blank">
                                        <img style="vertical-align: bottom;"  height="100" width="100" src="{{URL::asset('/assets/img/id_image/'.$customer->id_image)}}" />
                                    </a>

                                  </td>
                                  <td>
                                      {{  $customer->name ?? '' }}
                                  </td>
                                  <td>
                                      {{  $customer->email ?? '' }}
                                  </td>
                                  <td>
                                      {{  $customer->contact_number ?? '' }}
                                  </td>
                                  <td>
                                      {{  $customer->address ?? '' }}
                                  </td>
                                  <td>
                                      {{ $customer->created_at->format('M j , Y h:i A') }}
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
              <h5 class="modal-title">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <i class="fas fa-times text-primary"></i>
              </button>
            </div>
            <div class="modal-body">


                  <div class="form-group">

                          <label class="form-label">Email</label>
                          <input type="email" name="email" id="email" class="form-control disabled" readonly >

                  </div>

                  <div class="form-group">

                          <label class="form-label">Name</label>
                          <input type="name" name="name" id="name" class="form-control disabled" >

                      <span class="invalid-feedback" role="alert">
                        <strong id="error-name"></strong>
                      </span>
                  </div>

                  <div class="form-group">

                          <label class="form-label">Contact Number</label>
                          <input type="number" name="contact_number" id="contact_number" class="form-control disabled" >

                      <span class="invalid-feedback" role="alert">
                        <strong id="error-contact_number"></strong>
                      </span>
                  </div>

                  <div class="form-group">

                          <label class="form-label">Address</label>
                          <input type="text" name="address" id="address" class="form-control disabled" >

                      <span class="invalid-feedback" role="alert">
                        <strong id="error-address"></strong>
                      </span>
                  </div>

                  <input type="hidden" name="action" id="action" value="Add" />
                  <input type="hidden" name="hidden_id" id="hidden_id" />

            </div>


            <div class="modal-footer">
            <button type="button" id="password_default" class="btn btn-warning">Set A Default Password</button>
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

  $(document).on('click', '.status', function(){
    var id = $(this).attr('status');

    $.ajax({
        url :"/admin/customer_list/"+id+"/status",
        dataType:"json",
        method: 'put',
        data: { _token: '{!! csrf_token() !!}'},
        beforeSend:function(){

        },
        success:function(data){
            if(data.success){
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
    })
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
          }
      })
  });

  $('#myForm').on('submit', function(event){
    event.preventDefault();

    var id = $('#hidden_id').val();
    var action_url = "/admin/customer_list/" + id;
    var type = "PUT";

    $.ajax({
        url: action_url,
        method:type,
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function(){
            $("#action_button").attr("disabled", true);
            $("#action_button").attr("value", "Loading..");
        },
        success:function(data){
            var html = '';
            if(data.errors){
                $.each(data.errors, function(key,value){
                    $("#action_button").attr("disabled", false);
                    $("#action_button").attr("value", "Update");

                    if(key == $('#'+key).attr('id')){
                        $('#'+key).addClass('is-invalid')
                        $('#error-'+key).text(value)
                    }
                })
            }
            if(data.success){
                $("#action_button").attr("disabled", false);
                $("#action_button").attr("value", "Update");

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

  $(document).on('click', '#password_default', function(){
    var id = $('#hidden_id').val();
    $.confirm({
        title: 'Confirmation',
        content: 'Are you sure?',
        autoClose: 'cancel|10000',
        type: 'blue',
        buttons: {
            confirm: {
                text: 'confirm',
                btnClass: 'btn-blue',
                keys: ['enter', 'shift'],
                action: function(){
                    return $.ajax({
                        url:"/admin/customer_list/"+id+"/dpass",
                        method:'PUT',
                        data: {
                            _token: '{!! csrf_token() !!}',
                        },
                        dataType:"json",
                        beforeSend:function(){

                        },
                        success:function(data){
                            if(data.success){
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
                    })
                }
            },
            cancel:  {
                text: 'cancel',
                btnClass: 'btn-red',
                keys: ['enter', 'shift'],
            }
        }
    });
  });

  $(document).on('click', '.status', function(){

    var id = $(this).attr('status');
    $.ajax({
        url :"/admin/customer/status/"+id,
        dataType:"json",
        method: 'put',
        data: { _token: '{!! csrf_token() !!}'},
        beforeSend:function(){
            $(".status").attr("disabled", true);
        },
        success:function(data){
            if(data.success){
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
    })
});
</script>
@endsection






