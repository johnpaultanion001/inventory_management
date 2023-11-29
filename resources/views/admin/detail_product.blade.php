@extends('../layouts.admin')
@section('sub-title','PRODUCT')
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
                                <h4 class="mb-0 text-uppercase" id="titletable">SCAN A Products</h4>
                            </div>
                            <div class="col-md-2">
                                <a href="/admin/products" target="_black" class="text-uppercase create_record btn btn-dark">MANAGE PRODUCT</a>

                                <!-- <button type="button" name="create_record" id="create_record" class="text-uppercase create_record btn btn-dark">New Product</button> -->
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-md-10">
                                <input id="scan_code" type="text" class="form-control  text-center">
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
                                    <th  scope="col">UNIT</th>
                                    <th  scope="col">CODE</th>
                                    <th  scope="col">CATEGORY</th>
                                    <th scope="col">DESCRIPTION</th>
                                    <th scope="col">STOCK</th>
                                    <th scope="col">UNIT PRICE</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">EXPIRATION</th>
                                    <th scope="col">CREATED AT</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase font-weight-bold text-center">
                                    <tr>
                                        <td id="td_action">

                                        </td>
                                        <td id="td_id">

                                        </td>

                                        <td id="td_image1">

                                        </td>

                                        <td id="td_unit">

                                        </td>

                                        <td id="td_code">

                                        </td>

                                        <td id="td_category">

                                        </td>

                                        <td id="td_description">

                                        </td>

                                        <td  id="td_stock">

                                        </td>

                                        <td  id="td_unit_price">

                                        </td>

                                        <td  id="td_price">

                                        </td>
                                        <td id="td_expiration">

                                        </td>
                                        <td id="td_created_at">

                                        </td>


                                    </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-2">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-md-10">
                                <h4 class="mb-0 text-uppercase" id="titletable">Stock History</h4>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="row justify-content-md-center">

                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display text-center" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>STOCKS</th>
                                    <th>REMARKS</th>
                                    <th>CREATED AT</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase font-weight-bold text-center" id="list_stocks">
                                    <tr>
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

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-2">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-md-10">
                                <h4 class="mb-0 text-uppercase" id="titletable">Expiration History</h4>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="row justify-content-md-center">

                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display text-center" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>STOCKS</th>
                                    <th>Expiration</th>
                                    <th>CREATED AT</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase font-weight-bold text-center" id="list_expiration">
                                    <tr>
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

                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid py-4">
        <div class="row">
        <div class="col-md-12">
                <div class="card p-2">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-md-10">
                                <h4 class="mb-0 text-uppercase" id="titletable">Sales Order</h4>
                            </div>
                            <div class="col-md-2">

                            </div>
                        </div>
                        <div class="row justify-content-md-center">

                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display text-center" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>ORDER ID</th>
                                    <th>PRODUCT</th>
                                    <th>PRICE</th>
                                    <th>SOLD</th>
                                    <th>AMOUNT</th>
                                    <th>ORDER AT</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase font-weight-bold text-center" id="list_orders">
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

                </div>
            </div>
        </div>
    </div>



    <form method="post" id="myForm" class="contact-form">
        @csrf
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
                                        <option value="CASE">CASE</option>
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
                                <input type="number" name="stock" id="stock" class="form-control disabled"  step="any" disabled>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-stock"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Unit Price:  <span class="text-danger">*</span></label>
                                <input type="number" name="unit_price" id="unit_price" class="form-control disabled"  step="any" disabled>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-unit_price"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Price:  <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" class="form-control disabled" step="any" disabled>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-price"></strong>
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
                        <div class="col-sm-6">
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
                                            <img alt="no image" style="vertical-align: bottom;" id="current_image1"  height="150" width="150" src="" />
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

    <form method="post" id="myFormStock" class="contact-form">
        @csrf
        <div class="modal fade" id="formModalStock" tabindex="-1" role="dialog">
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
                                <label class="form-label">Stock:  <span class="text-danger">*</span></label>
                                <input type="number" name="manage_stock" id="manage_stock" class="form-control disabled"  step="any">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-manage_stock"></strong>
                                </span>
                            </div>
                        </div>
                        <input type="hidden" name="hidden_id_stock" id="hidden_id_stock" />

                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="action_button_stock" id="action_button_stock" class="btn  btn-primary" value="Save" />
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

        $('#scan_code').focus();
        $('.select2').select2();

        $('#scan_code').on("input", function() {
            var code = this.value;
            //console.log(code);

            $.ajax({
                url :"/admin/products/product/detail/"+code,
                dataType:"json",
                beforeSend:function(){
                    $("#action_button").attr("disabled", true);
                    $("#action_button").attr("value", "Loading..");
                },
                success:function(data){
                    console.log(data.product);
                    $.each(data.product, function(key,value){
                            $('#td_'+key).text(value)
                            if(key == "expiration"){
                                $('#td_expiration').text(moment(value).format('DD-MM-YYYY'));
                            }
                            if(key == "created_at"){
                                $('#td_created_at').text(moment(value).format('DD-MM-YYYY'));
                            }
                            if(key == "image1"){
                                if(value != null){
                                    var img = '<img style="vertical-align: bottom;"  height="100" width="100" src="/assets/img/products/'+value+'" />'
                                }else{
                                    var img = '<img style="vertical-align: bottom;"  height="100" width="100" src="/assets/img/products/no_image.png" />'
                                }
                                $('#td_'+key).empty().append(img);

                            }

                            if(key == "id"){
                                var buttons = '<button type="button" name="edit" edit="'+value+'"  class="edit btn btn-sm btn-success form-control">Edit</button> <br>'
                                    buttons += '<button type="button" name="stock" stock="'+value+'" class="stock btn btn-sm btn-warning form-control">Manage Stock</button> <br>'
                                    buttons += '<button type="button" name="remove" remove="'+value+'" class="remove btn btn-sm btn-danger form-control">Remove</button> <br>'

                                $('#td_action').empty().append(buttons);

                            }
                            $('#td_category').text(data.category);
                    })
                    var list_orders = "";

                    $.each(data.orders, function(key,value){
                        list_orders += `
                                    <tr>
                                        <td>`+value.id+`</td>
                                        <td>`+value.description+`</td>
                                        <td>`+number_format(value.price, 2,'.', ',')+`</td>
                                        <td>`+value.qty+`</td>
                                        <td>`+number_format(value.amount, 2,'.', ',')+`</td>
                                        <td>`+moment(value.created_at).format('DD-MM-YYYY')+`</td>
                                    </tr>
                            `;
                            console.log(value)
                    })
                    $('#list_orders').empty().append(list_orders);

                    var list_stocks = "";

                    $.each(data.stocks, function(key,value){
                        list_stocks += `
                                    <tr>
                                        <td>`+value.id+`</td>
                                        <td>`+value.stock+`</td>
                                        <td>`+value.remarks+`</td>
                                        <td>`+moment(value.created_at).format('DD-MM-YYYY')+`</td>
                                    </tr>
                            `;
                            console.log(value)
                    })
                    $('#list_stocks').empty().append(list_stocks);

                    var list_expi = "";
                    $.each(data.expirations, function(key,value){
                        list_expi += `
                                    <tr>
                                        <td>`+value.id+`</td>
                                        <td>`+value.stock_expi+`</td>
                                        <td>`+moment(value.expiration).format('DD-MM-YYYY')+`</td>
                                        <td>`+moment(value.created_at).format('DD-MM-YYYY')+`</td>
                                    </tr>
                            `;
                            console.log(value)
                    })
                    $('#list_expiration').empty().append(list_expi);


                }
            })
        });

        $(document).on('click', '.edit', function(){
            $('#formModal').modal('show');
            $('.modal-title').text('Edit Product');
            $('#myForm')[0].reset();
            $('.form-control').removeClass('is-invalid');
            $('.input-group').addClass('is-filled');
            $('.current_img').show();
            $('.disabled').attr('readonly', false);
            $('#added_section').hide();
            $('#image-section').show();
            var id = $(this).attr('edit');

            $.ajax({
                url :"/admin/products/"+id+"/edit",
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

                        if(key == 'image1'){
                            $('#current_image1').attr("src", '/assets/img/products/'  + value);
                        }
                        if(key == 'expiration'){
                            console.log(value)
                        }
                        if(key == 'category_id'){
                            $("#category").select2("trigger", "select", {
                                data: { id: value }
                            });
                        }





                    })
                    $('#hidden_id').val(id);
                    $('#action_button').val('Update');
                    $('#action').val('Edit');
                }
            })
        });

        $(document).on('click', '.stock', function(){
            $('#formModalStock').modal('show');
            $('.modal-title').text('Manage Stock');
            $('#myFormStock')[0].reset();
            $('.form-control').removeClass('is-invalid');

            var id = $(this).attr('stock');

            $.ajax({
                url :"/admin/products/"+id+"/stock",
                dataType:"json",
                beforeSend:function(){
                    $("#action_button_stock").attr("disabled", true);
                    $("#action_button_stock").attr("value", "Loading..");
                },
                success:function(data){
                    $("#action_button_stock").attr("disabled", false);
                    $("#action_button_stock").attr("value", "Submit");

                    $('#manage_stock').val(data.stock);
                    $('#hidden_id_stock').val(id);
                }
            })
        });

        $('#myForm').on('submit', function(event){
            event.preventDefault();
            $('.form-control').removeClass('is-invalid')


            var id = $('#hidden_id').val();
            var action_url = "/admin/products/update/" + id;
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
                                        $.each(data.product, function(key,value){
                                                $('#td_'+key).text(value)
                                                if(key == "image1"){
                                                    if(value != null){
                                                        var img = '<img style="vertical-align: bottom;"  height="100" width="100" src="/assets/img/products/'+value+'" />'
                                                    }else{
                                                        var img = '<img style="vertical-align: bottom;"  height="100" width="100" src="/assets/img/products/no_image.png" />'
                                                    }
                                                    $('#td_'+key).empty().append(img);

                                                }

                                                if(key == "id"){
                                                    var buttons = '<button type="button" name="edit" edit="'+value+'"  class="edit btn btn-sm btn-success form-control">Edit</button> <br>'
                                                    buttons += '<button type="button" name="stock" stock="'+value+'" class="stock btn btn-sm btn-warning form-control">Manage Stock</button> <br>'
                                                        buttons += '<button type="button" name="remove" remove="'+value+'" class="remove btn btn-sm btn-danger form-control">Remove</button> <br>'

                                                    $('#td_action').empty().append(buttons);

                                                }
                                        })
                                        $('#td_category').text(data.category);
                                        var list_stocks = "";

                                        $.each(data.stocks, function(key,value){
                                            list_stocks += `
                                                        <tr>
                                                            <td>`+value.id+`</td>
                                                            <td>`+value.stock+`</td>
                                                            <td>`+value.remarks+`</td>
                                                            <td>`+value.created_at+`</td>
                                                        </tr>
                                                `;
                                                console.log(value)
                                        })
                                        $('#list_stocks').empty().append(list_stocks);
                                    }
                                },

                            }
                        });
                        $('#formModal').modal('hide');
                    }

                }
            });
        });

        $('#myFormStock').on('submit', function(event){
            event.preventDefault();
            $('.form-control').removeClass('is-invalid')
            var id = $('#hidden_id_stock').val();
            var action_url = "/admin/stock/" + id;
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
                    $("#action_button_stock").attr("disabled", true);
                    $("#action_button_stock").attr("value", "Loading..");
                },
                success:function(data){

                        $("#action_button_stock").attr("disabled", false);
                        $("#action_button_stock").attr("value", "Submit");

                    if(data.errors){
                        $.each(data.errors, function(key,value){
                            if(key == $('#'+key).attr('id')){
                                $('#'+key).addClass('is-invalid')
                                $('#error-'+key).text(value)
                            }
                        })
                    }
                    console.log("test "+data.critStock)
                    if(data.critStock === 1){
                        $.confirm({
                        title: 'Confirmation',
                        content: 'This product has been critical stock',
                        type: 'red',
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
                                        $.each(data.product, function(key,value){
                                                $('#td_'+key).text(value)
                                                if(key == "image1"){
                                                    if(value != null){
                                                        var img = '<img style="vertical-align: bottom;"  height="100" width="100" src="/assets/img/products/'+value+'" />'
                                                    }else{
                                                        var img = '<img style="vertical-align: bottom;"  height="100" width="100" src="/assets/img/products/no_image.png" />'
                                                    }
                                                    $('#td_'+key).empty().append(img);

                                                }

                                        })
                                        $('#td_category').text(data.category);

                                        var list_orders = "";

                                        $.each(data.orders, function(key,value){
                                            list_orders += `
                                                        <tr>
                                                            <td>`+value.id+`</td>
                                                            <td>`+value.description+`</td>
                                                            <td>`+number_format(value.price, 2,'.', ',')+`</td>
                                                            <td>`+value.qty+`</td>
                                                            <td>`+number_format(value.amount, 2,'.', ',')+`</td>
                                                            <td>`+moment(value.created_at).format('DD-MM-YYYY')+`</td>
                                                        </tr>
                                                `;
                                                console.log(value)
                                        })
                                        $('#list_orders').empty().append(list_orders);

                                        var list_stocks = "";

                                        $.each(data.stocks, function(key,value){
                                            list_stocks += `
                                                        <tr>
                                                            <td>`+value.id+`</td>
                                                            <td>`+value.stock+`</td>
                                                            <td>`+value.remarks+`</td>
                                                            <td>`+moment(value.created_at).format('DD-MM-YYYY')+`</td>
                                                        </tr>
                                                `;
                                                console.log(value)
                                        })
                                        $('#list_stocks').empty().append(list_stocks);

                                        console.log(data.order);
                                    }
                                },

                            }
                        });
                        $('#formModalStock').modal('hide');

                    }


                }
            });
        });

        $(document).on('click', '.remove', function(){
            var id = $(this).attr('remove');
            $.confirm({
                title: 'Confirmation',
                content: 'You really want to remove this record?',
                type: 'red',
                buttons: {
                    confirm: {
                        text: 'confirm',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function(){
                            return $.ajax({
                                url:"/admin/products/"+id,
                                method:'DELETE',
                                data: {
                                    _token: '{!! csrf_token() !!}',
                                },
                                dataType:"json",
                                beforeSend:function(){
                                    $('#titletable').text('Loading...');
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
    });
</script>
@endsection




