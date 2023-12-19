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
                            <div class="col-md-10">
                                <h4 class="mb-0 text-uppercase" id="titletable">All Deliveries</h4>
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
                                    <th scope="col">CONFIRM BY</th>
                                    <th scope="col">CONFIRM AT</th>
                                </tr>
                            </thead>

                            <tbody class="text-uppercase font-weight-bold">
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <button type="button" name="receipt" receipt="{{  $order->id ?? '' }}"  class="receipt btn btn-sm btn-warning">Receipt</button>
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
    @section('footer')
        @include('../partials.admin.footer')
    @endsection
@endsection


@section('script')
<script>
$(function () {


    var title = 'title';
    var header =  'title';
    var table = $('.datatable-table').DataTable({
        bDestroy: true,
        responsive: true,
        scrollCollapse: true,
        pageLength: 50,
        buttons: [
            {
                extend: 'excel',
                className: 'btn btn-dark m-2',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                footer: true,
                className: 'btn btn-dark m-2',

            }
        ],
    });

    $('.select2').select2();


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








</script>
@endsection




