@extends('../layouts.admin')
@section('sub-title','Purchase Order')
@section('navbar')
    @include('../partials.admin.navbar')
@endsection
@section('sidebar')
    @include('../partials.admin.sidebar')
@endsection



@section('content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12 mb-2">
                    <div class="card p-2">
                        <div class="card-header border-0">
                            <div class="row ">
                                <div class="col-md-12 justify-content-between" style="display:flex;">
                                    <h4 class="mb-0 text-uppercase" id="titletable">YOUR ORDERS</h4>
                                    <a href="/admin/purchase_order/deliveries" class="text-uppercase view_deliveries btn btn-primary ">View Deliveries</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table display" cellspacing="0" width="100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ACTION</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">IMAGE</th>
                                        <th  scope="col">CODE</th>
                                        <th scope="col">DESCRIPTION</th>
                                        <th scope="col">CATEGORY</th>
                                        <th scope="col">EXPIRATION</th>
                                        <th scope="col">UNIT</th>
                                        <th scope="col">QTY</th>
                                        <th scope="col">UNIT PRICE</th>
                                        <th scope="col">TOTAL</th>
                                    </tr>
                                </thead>

                                <tbody class="text-uppercase font-weight-bold text-center" id="list_orders">

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer justify-content-between" style="display:flex;">
                                <button type="button" name="clear_order" id="clear_order" class="text-uppercase clear_order btn btn-danger">Clear Orders</button>
                                <button type="button" name="confirm_order" id="confirm_order" class="text-uppercase confirm_order btn btn-success ">Confirm Orders</button>

                        </div>
                    </div>
            </div>
            <div class="col-md-12">
                <div class="card p-2">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-md-10">
                                <h4 class="mb-0 text-uppercase" id="titletable">All Products</h4>
                            </div>
                            <div class="col-md-2">
                                <button type="button" name="create_record" id="create_record" class="text-uppercase create_record btn btn-dark">New Product</button>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="category_dd" id="category_dd" class="select2" style="width: 100%;">
                                        <option value="">FILTER CATEGORY</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->name}}">{{$category->name}}</option>
                                        @endforeach
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
                                    <th scope="col">ID</th>
                                    <th scope="col">IMAGE</th>
                                    <th  scope="col">CODE</th>
                                    <th scope="col">DESCRIPTION</th>
                                    <th scope="col">CATEGORY</th>
                                    <th scope="col">STOCK</th>
                                    <th scope="col">UNIT PRICE</th>
                                </tr>
                            </thead>

                            <tbody class="text-uppercase font-weight-bold">
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <button type="button" name="order" order="{{  $product->id ?? '' }}"  class="order btn btn-sm btn-warning">Order</button>
                                        </td>
                                        <td>
                                            {{  $product->id ?? '' }}
                                        </td>

                                        <td>
                                            @if($product->image1 == null)
                                             <img style="vertical-align: bottom;"  height="100" width="100" src="{{URL::asset('/assets/img/products/no_image.png')}}" />
                                            @else
                                             <img style="vertical-align: bottom;"  height="100" width="100" src="{{URL::asset('/assets/img/products/'.$product->image1)}}" />
                                            @endif

                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{  $product->code ?? '' }}</span>
                                        </td>

                                        <td>
                                            {{\Illuminate\Support\Str::limit($product->description,50)}}
                                        </td>
                                        <td>
                                            {{  $product->category->name ?? '' }}
                                        </td>

                                        <td>
                                            {{ $product->stock ?? '' }}
                                        </td>
                                        <td>
                                            {{ $product->unit_price ?? '' }}
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
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times text-primary"></i>
                    </button>

                    </div>
                    <div class="modal-body row">

                        <div class="col-sm-12">
                            <div class="form-group">

                                <label class="form-label">Description: <span class="text-danger">*</span></label>
                                <input type="text" name="description" id="description" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-description"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Code:  <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-code"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Unit:  <span class="text-danger">*</span></label>
                                <select name="unit" id="unit" class="select2" style="width: 100%;">
                                        <option value="PCS">PCS</option>
                                        <option value="CS">CS</option>
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-unit"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Category:  <span class="text-danger">*</span></label>
                                <select name="category" id="category" class="select2" style="width: 100%;">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-category"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Stock:  <span class="text-danger">*</span></label>
                                <input type="number" name="stock" id="stock" class="form-control disabled"  step="any">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-stock"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Unit Price:  <span class="text-danger">*</span></label>
                                <input type="number" name="unit_price" id="unit_price" class="form-control disabled"  step="any">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-unit_price"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Expiration:  <span class="text-danger">*</span></label>
                                <input type="date" name="expiration" id="expiration" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-expiration"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" id="image-section">
                                <label class="form-label">Image : <span class="text-danger">*</span></label>
                                <input type="file" name="image1" class="form-control image1" accept="image/*" >
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="error-image1"></strong>
                                    </span>
                            </div>

                            <div class="current_img pt-4">
                                <div class="row">
                                    <div class="col-6">
                                    <br>
                                    <br>
                                    <br>
                                            <small>Current Image:</small>
                                    </div>
                                    <div class="col-6">
                                            <img style="vertical-align: bottom;" id="current_image1"  height="150" width="150" src="" />
                                    </div>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />

                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="action_button" id="action_button" class="btn  btn-primary" value="Save" />
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post" id="myOrder" class="contact-form">
        @csrf
        <div class="modal fade" id="orderModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times text-primary"></i>
                    </button>

                    </div>
                    <div class="modal-body row">

                        <div class="col-sm-12">
                            <div class="form-group">

                                <label class="form-label">Description:</label>
                                <input type="text" name="order_description" id="order_description" class="form-control disabled" readonly>

                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Code: </label>
                                <input type="text" name="order_code" id="order_code" class="form-control disabled" readonly>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Unit:  <span class="text-danger">*</span></label>
                                <select name="unit_order" id="unit_order" class="select2" style="width: 100%;">
                                        <option value="PCS">PCS</option>
                                        <option value="CS">CS</option>
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-unit_order"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Expiration:  <span class="text-danger">*</span></label>
                                <input type="date" name="expiration_order" id="expiration_order" class="form-control">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-expiration_order"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Qty:  <span class="text-danger">*</span></label>
                                <input type="number" name="qty_order" id="qty_order" class="form-control disabled"  step="any">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-qty_order"></strong>
                                </span>
                            </div>
                        </div>

                        <input type="hidden" name="action_order" id="action_order" value="Add" />
                        <input type="hidden" name="product_id" id="product_id" />

                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="action_order_button" id="action_order_button" class="btn  btn-primary" value="Submit" />
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

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

        ],
    });

    $('.select2').select2();

    $('#category_dd').on('change', function () {
    table.columns(5).search( this.value ).draw();
    });
    orders();
});


function orders(){
    $.ajax({
        url :"/admin/purchase_order/orders",
        dataType:"json",
        beforeSend:function(){

        },
        success:function(data){
            console.log(data.deliveries);
            var list_orders = "";
            if(data.deliveries.length === 0){
                list_orders += `
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>

                                    <td>

                                    </td>
                                    <td>
                                        NO ORDER RECORD
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
                    `;
                    $('#list_orders').empty().append(list_orders);
            }else{
                $.each(data.deliveries, function(key,value){
                    list_orders += `
                                <tr>
                                    <td>
                                        <button type="button" name="remove_order" remove_order="`+value.id+`"  class="remove_order btn btn-sm btn-danger">x</button>
                                    </td>
                                    <td>
                                        `+value.id+`
                                    </td>

                                    <td>
                                    <img style="vertical-align: bottom;"  height="100" width="100" src="/assets/img/products/`+(value.product.image1 ? value.product.image1 : `no_image.png`)+`" />
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">`+value.product.code+`</span>
                                    </td>
                                    <td>
                                        `+value.product.description+`
                                    </td>
                                    <td>
                                        `+value.product.category.name+`
                                    </td>
                                    <td>`+moment(value.expiration).format('MM-DD-YYYY')+`</td>
                                    <td>
                                        `+value.unit+`
                                    </td>
                                    <td>
                                        `+value.qty+`
                                    </td>
                                    <td>
                                        `+number_format(value.unit_price, 2,'.', ',')+`
                                    </td>
                                    <td>
                                        `+number_format(value.total, 2,'.', ',')+`
                                    </td>
                                </tr>
                    `;
                    $('#list_orders').empty().append(list_orders);
                })


            }


        }
    })
}

$(document).on('click', '#create_record', function(){
    $('#formModal').modal('show');
    $('#myForm')[0].reset();
    $('.form-control').removeClass('is-invalid')
    $('.modal-title').text('Add Product');
    $('#action_button').val('Submit');
    $('#action').val('Add');
    $('.current_img').hide();
    $('.input-group').removeClass('is-filled');
    $('#added_section').hide();
    $('#image-section').show();
    $('.disabled').attr('readonly', false);
    $('#category').attr('disabled', false);
});

$('#myForm').on('submit', function(event){
    event.preventDefault();
    $('.form-control').removeClass('is-invalid')
    var action_url = "{{ route('admin.products.store') }}";
    var type = "POST";

    if($('#action').val() == 'Edit'){
        var id = $('#hidden_id').val();
        action_url = "products/update/" + id;
        type = "POST";
    }

    $.ajax({
        url: action_url,
        method:type,
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData: false,

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
            if(data.errors){
                $.each(data.errors, function(key,value){
                    if(key == $('#'+key).attr('id')){
                        $('#'+key).addClass('is-invalid')
                        $('#error-'+key).text(value)
                    }
                    if(key == 'image1'){
                        $('.image1').addClass('is-invalid')
                        $('#error-image1').text(value)
                    }

                })
            }
            if(data.success){
                $('.form-control').removeClass('is-invalid')
                $('#myForm')[0].reset();
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
                $('#formModal').modal('hide');
            }

        }
    });
});


$('#formModal').on('shown.bs.modal', function () {
    $('#added_stock').focus();
})

$(document).on('click', '.order', function(){
    $('#orderModal').modal('show');
    $('.modal-title').text('Order Product');
    $('#myOrder')[0].reset();
    $('.form-control').removeClass('is-invalid');

    var id = $(this).attr('order');

    $.ajax({
        url :"/admin/products/"+id+"/edit",
        dataType:"json",
        beforeSend:function(){
            $("#action_order_button").attr("disabled", true);
        },
        success:function(data){
            $("#action_order_button").attr("disabled", false);
            console.log(data.result)
            $.each(data.result, function(key,value){
                if(key == $('#'+key).attr('id')){
                    $('#'+key).val(value)
                }
                if(key == "description"){
                    $('#order_description').val(value)
                }
                if(key == "code"){
                    $('#order_code').val(value)
                }
            })

            $('#product_id').val(id);
            $('#action_order').val('Edit');
        }
    })
});


$(document).on('click', '.remove_order', function(){
    var id = $(this).attr('remove_order');

    $.ajax({
        url :"/admin/purchase_order/delete/"+id,
        dataType:"json",
        type:'get',
        beforeSend:function(){
        },
        success:function(data){
            orders();
        }
    })
});

$(document).on('click', '.clear_order', function(){

    $.confirm({
                title: 'Confirmation',
                content: 'You really want to clear this orders',
                type: 'red',
                buttons: {
                    confirm: {
                        text: 'confirm',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function(){
                            return $.ajax({
                                url :"/admin/purchase_order/delete/clear",
                                method:'GET',
                                dataType:"json",
                                beforeSend:function(){

                                },
                                success:function(data){
                                    orders();
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


$(document).on('click', '.confirm_order', function(){

        $.confirm({
            title: 'Confirmation',
            content: 'You really want to confirm this orders',
            type: 'green',
            buttons: {
                confirm: {
                    text: 'confirm',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        return $.ajax({
                            url :"/admin/purchase_order/confirm",
                            method:'GET',
                            dataType:"json",
                            beforeSend:function(){

                            },
                            success:function(data){
                                orders();
                                if(data.success){
                                    $.confirm({
                                        title: 'Confirmation',
                                        content: data.success,
                                        type: 'green',
                                        buttons: {
                                            confirm: {
                                                text: 'Confirm',
                                                btnClass: 'btn-blue',
                                                keys: ['enter', 'shift'],
                                                action: function(){

                                                }
                                            }
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



$('#myOrder').on('submit', function(event){
    event.preventDefault();
    $('.form-control').removeClass('is-invalid')
    var action_url = "{{ route('admin.purchase_order.order') }}";
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
            $("#action_order_button").attr("disabled", true);
            $("#action_order_button").attr("value", "Loading..");
        },
        success:function(data){
            $("#action_order_button").attr("disabled", false);
            $("#action_order_button").attr("value", "Submit");

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
                $('#myOrder')[0].reset();
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
                                orders();
                            }
                        },

                    }
                });
                $('#orderModal').modal('hide');
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
    frameDoc.document.write('<style>size: A5 portrait; </style>');
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




