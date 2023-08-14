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
                                    <th scope="col">AREA</th>
                                    <th scope="col">STOCK</th>
                                    <th scope="col">UNIT PRICE</th>
                                    <th scope="col">PRICE</th>
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
                                        <td  id="td_area">

                                        </td>

                                        <td  id="td_stock">

                                        </td>

                                        <td  id="td_unit_price">

                                        </td>

                                        <td  id="td_price">

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
                                <input type="text" name="unit" id="unit" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-unit"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Area:  <span class="text-danger">*</span></label>
                                <input type="text" name="area" id="area" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-area"></strong>
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
                                <label class="form-label">Price:  <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" class="form-control disabled" step="any">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-price"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" id="image-section">
                                <label class="form-label">Image : <span class="text-danger">*</span></label>
                                <div class="input-group input-group-outline my-3">
                                <input type="file" name="image1" class="form-control image1" accept="image/*" >
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="error-image1"></strong>
                                    </span>
                                </div>
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



    @section('footer')
        @include('../partials.admin.footer')
    @endsection
@endsection


@section('script')
<script>
    $(function () {
        $('#scan_code').focus();

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
                                    buttons += '<button type="button" name="remove" remove="'+value+'" class="remove btn btn-sm btn-danger form-control">Remove</button> <br>'

                                $('#td_action').empty().append(buttons);

                            }
                    })
                    var list_orders = "";

                    $.each(data.orders, function(key,value){
                        list_orders += `
                                    <tr>
                                        <td>`+value.id+`</td>
                                        <td>`+value.description+`</td>
                                        <td>`+value.price+`</td>
                                        <td>`+value.qty+`</td>
                                        <td>`+value.amount+`</td>
                                        <td>`+value.created_at+`</td>
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
                                        <td>`+value.created_at+`</td>
                                    </tr>
                            `;
                            console.log(value)
                    })
                    $('#list_stocks').empty().append(list_stocks);


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
            $('#category').attr('disabled', false);
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
                        if(key == 'category_id'){
                            $("#category").select2("trigger", "select", {
                                data: { id: value }
                            });
                        }



                        if(key == 'image1'){
                            $('#current_image1').attr("src", '/assets/img/products/'  + value);
                        }

                    })
                    $('#hidden_id').val(id);
                    $('#action_button').val('Update');
                    $('#action').val('Edit');
                }
            })
        });





        $('#myForm').on('submit', function(event){
            event.preventDefault();
            $('.form-control').removeClass('is-invalid')
            var action_url = "{{ route('admin.products.store') }}";
            var type = "POST";

            if($('#action').val() == 'Edit'){
                var id = $('#hidden_id').val();
                action_url = "/admin/products/update/" + id;
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
                                                        buttons += '<button type="button" name="remove" remove="'+value+'" class="remove btn btn-sm btn-danger form-control">Remove</button> <br>'

                                                    $('#td_action').empty().append(buttons);

                                                }
                                        })

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
    });
</script>
@endsection




