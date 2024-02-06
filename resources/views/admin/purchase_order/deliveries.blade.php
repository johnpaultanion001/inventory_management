@extends('../layouts.admin')
@section('sub-title','All Deliveries')
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
                            <div class="col-md-8">
                                <h4 class="mb-0 text-uppercase" id="titletable">All Deliveries</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="deliveries_dd" id="deliveries_dd" class="select2" style="width: 100%;">
                                        <option value="Recieve">ALL DELIVERIES</option>
                                        <option value="Receipt">ALL DELIVERIES HISTORY</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ACTION</th>
                                    <th scope="col">ORDER ID</th>
                                    <th scope="col">TOTAL QTY</th>
                                    <th  scope="col">TOTAL AMOUNT</th>
                                    <th scope="col">DELIVERED BY</th>
                                    <th scope="col">CONFIRM BY</th>
                                    <th scope="col">CONFIRM AT</th>
                                </tr>
                            </thead>

                            <tbody class="text-uppercase font-weight-bold">
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            @if($order->isRecieve == false)
                                            <button type="button" name="recieve" recieve="{{  $order->id ?? '' }}"  class="recieve btn btn-sm btn-success">Recieve</button>
                                            <button type="button" name="verify" verify="{{  $order->id ?? '' }}"  class="verify btn btn-sm btn-info">Verify</button>
                                            @else
                                            <button type="button" name="receipt" receipt="{{  $order->id ?? '' }}"  class="receipt btn btn-sm btn-warning">Receipt</button>
                                            @endif

                                        </td>
                                        <td>
                                            {{  $order->id ?? '' }}
                                        </td>
                                        <td>
                                            {{  $order->deliveries->sum->qty ?? '' }}
                                        </td>
                                        <td>
                                            ₱ {{ number_format($order->deliveries->sum->total ?? '' , 2, '.', ',') }}
                                        </td>
                                        <td>
                                            {{ $order->user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $order->user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $order->created_at->format('M j , Y h:i A') }}
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

    <div  class="modal fade" id="receiptModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title-receipt">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-primary"></i>
                </button>

                </div>
                <div class="modal-body">
                    <div id="receipt_data">

                    </div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button type="button" class="btn btn-success" id="btn_print">Print</button>

                </div>
            </div>
        </div>
    </div>

    <form method="post" id="myVerify" class="contact-form">
        @csrf
        <div  class="modal fade" id="verifyModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title-verify">Delivery Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times text-primary"></i>
                    </button>

                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display text-center" cellspacing="0" width="100%">
                                <thead class="thead-dark font-weight-bold">
                                    <tr>
                                        <th scope="col">CODE</th>
                                        <th scope="col">UNIT</th>
                                        <th scope="col">EXPIRATION</th>
                                        <th scope="col">QTY</th>
                                        <th scope="col">UNIT PRICE</th>
                                        <th scope="col">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" id="delivers_records">
                                        <tr>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>

                                            <td>

                                            </td>

                                            <td>

                                            </td>

                                            <td>

                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 mx-auto">
                            <div class="form-group">
                                <label class="form-label">Supplier: <span class="text-danger">*</span></label>
                                <input type="text" name="supplier_name" id="supplier_name" class="form-control" required >
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                        <button type="submit" class="btn btn-success" id="btn_verify">Submit</button>

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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(function () {


    var title = 'title';
    var header =  'title';
    var table = $('.datatable-table').DataTable({
        bDestroy: true,
        responsive: true,
        scrollCollapse: true,
        pageLength: 50,

    });

    $('.select2').select2();

    $('#deliveries_dd').on('change', function () {
        table.columns(0).search( this.value ).draw();
    });




    var availableTags = @json($suppliers);
    console.log(availableTags)
    $( "#supplier_name" ).autocomplete({
      source: availableTags
    });

});


$(document).on('click', '.receipt', function(){
    var id = $(this).attr('receipt');

    $('#receiptModal').modal('show');
    $.ajax({
        url :"/admin/purchase_order/receipt/"+id,
        type: "get",
        dataType: "HTMl",
        beforeSend: function() {
            $('.modal-title-receipt').text('Loading Records...');
        },
        success: function(response){
            $('.modal-title-receipt').text('Receipt');
            $("#receipt_data").html(response);
        }
    })
});

$(document).on('click', '.verify', function(){
    var id = $(this).attr('verify');

    $('#verifyModal').modal('show');
    $.ajax({
        url :"/admin/purchase_order/verify/"+id,
        type: "get",
        dataType: "json",
        beforeSend: function() {

        },
        success: function(data){
            console.log(data.deliveries);
            var records = "";
            $.each(data.deliveries, function(key,value){
                records += `
                            <tr>
                                <td>`+value.product_code+`</td>
                                <td>
                                    <select name="unit[]"class="form-control">
                                            <option value="`+value.unit+`">`+value.unit+`</option>
                                            <hr>
                                            <option value="PCS">PCS</option>
                                            <option value="CS">CS</option>
                                    </select>
                                </td>
                                <td><input type="date" name="expiration[]" class="form-control" value="`+value.expiration+`" required/></td>
                                <td> <input type="number" name="qty[]" class="form-control" value="`+value.qty+`" required/> <input type="hidden" name="ids[]" class="form-control" value="`+value.id+`"/></td>
                                <td>`+number_format(value.unit_price, 2,'.', ',')+`</td>
                                <td>`+number_format(value.total, 2,'.', ',')+`</td>
                            </tr>
                    `;
                    console.log(value)
            })
            $('#delivers_records').empty().append(records);
            $('#supplier_name').val(data.supplier);
        }
    })
});

$('#myVerify').on('submit', function(event){
    event.preventDefault();
    var action_url = "{{ route('admin.purchase_order.verify') }}";
    var type = "POST";


    $.ajax({
        url: action_url,
        method:type,
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData: false,

        dataType:"json",
        beforeSend:function(){
            $("#btn_verify").attr("disabled", true);
            $("#btn_verify").attr("value", "Loading..");
        },
        success:function(data){
            $("#btn_verify").attr("disabled", false);
            $("#btn_verify").attr("value", "Submit");

            console.log(data.success)
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
                $('#verifyModal').modal('hide');
            }

        }
    });
});




$(document).on('click', '#btn_print', function(){
    var contents = $("#receipt_data").html();
    var frame1 = $('<iframe />');
    frame1[0].name = "frame1";
    frame1.css({ "position": "absolute", "top": "-1000000px" });
    $("body").append(frame1);
    var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
    frameDoc.document.open();
    //Create a new HTML document.
    frameDoc.document.write('<html><head><title>Title</title>');
    frameDoc.document.write('</head><body>');
    //Append the external CSS file.
    frameDoc.document.write('<link href="/admin/css/material-dashboard.css" rel="stylesheet" type="text/css" />');
    frameDoc.document.write('<style>size: A5 portrait;</style>');
    var source = 'bootstrap.min.js';
    var script = document.createElement('script');
    script.setAttribute('type', 'text/javascript');
    script.setAttribute('src', source);
    //Append the DIV contents.
    frameDoc.document.write(contents);
    frameDoc.document.write('</body></html>');
    frameDoc.document.close();
    setTimeout(function () {
    window.frames["frame1"].focus();
    window.frames["frame1"].print();
    frame1.remove();
    }, 500);
});

$(document).on('click', '.recieve', function(){
  var id = $(this).attr('recieve');
  $.confirm({
      title: 'Confirmation',
      content: 'Are you sure?',
      type: 'green',
      buttons: {
          confirm: {
              text: 'confirm',
              btnClass: 'btn-blue',
              keys: ['enter', 'shift'],
              action: function(){
                  return $.ajax({
                      url:"/admin/purchase_order/recieve/"+id,
                      method:'GET',
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









</script>
@endsection




