@extends('../layouts.admin')
@section('sub-title','Inventories')
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
                            <h4 class="mb-0 text-uppercase" id="titletable">Manage Products</h4>
                        </div>
                        <div class="col-md-2">
                            <a href="/admin/products/product/detail" target="_black" class="text-uppercase create_record btn btn-dark">SCAN PRODUCT</a>
                            <button type="button" name="create_record" id="create_record" class="text-uppercase create_record btn btn-dark">New Product</button>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="unit_dd" id="unit_dd" class="select2" style="width: 100%;">
                                    <option value="">FILTER UNIT</option>
                                    <option value="PCS">PCS</option>
                                    <option value="CS">CS</option>
                                </select>
                            </div>
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
                                <th scope="col">ID</th>
                                <th scope="col">IMAGE</th>
                                <th scope="col">UNIT</th>
                                <th scope="col">CODE</th>
                                <th scope="col">DESCRIPTION</th>
                                <th scope="col">CATEGORY</th>
                                <th scope="col">STOCK</th>
                                <th scope="col">UNIT PRICE</th>
                                <th scope="col">TOTAL PRICE</th>

                            </tr>
                        </thead>

                        <tbody class="text-uppercase font-weight-bold">
                            @foreach($products as $product)
                            <tr>

                                <td>
                                    {{ $product->code ?? '' }}{{ $product->id ?? '' }}
                                </td>

                                <td>
                                    @if($product->image1 == null)
                                    <img style="vertical-align: bottom;" height="100" width="100" src="{{URL::asset('/assets/img/products/no_image.png')}}" />
                                    @else
                                    <img style="vertical-align: bottom;" height="100" width="100" src="{{URL::asset('/assets/img/products/'.$product->image1)}}" />
                                    @endif

                                </td>
                                <td>
                                    {{ $product->unit ?? '' }}
                                </td>
                                <td>
                                    <span class="badge bg-warning">{{ $product->code ?? '' }}</span>
                                </td>

                                <td>
                                    {{\Illuminate\Support\Str::limit($product->description,50)}}
                                </td>
                                <td>
                                    {{ $product->category->name ?? '' }}
                                </td>

                                <td>
                                    {{ $product->stock ?? '' }}
                                </td>
                                <td>
                                    {{ $product->unit_price ?? '' }}
                                </td>
                                <td>
                                    {{ $product->price ?? '' }}
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="text-uppercase font-weight-bold">
                            <tr>
                                <th scope="col">DATE:</th>
                                <th scope="col">{{$ldate}}</th>
                                <th scope="col">USER:</th>
                                <th scope="col">{{auth()->user()->name}}</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </tfoot>
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
                            <input type="text" name="description" id="description" class="form-control disabled">
                            <span class="invalid-feedback" role="alert">
                                <strong id="error-description"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label">Code: <span class="text-danger">*</span></label>
                            <input type="text" name="code" id="code" class="form-control disabled">
                            <span class="invalid-feedback" role="alert">
                                <strong id="error-code"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label">Unit: <span class="text-danger">*</span></label>
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
                            <label class="form-label">Category: <span class="text-danger">*</span></label>
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
                            <label class="form-label">Stock: <span class="text-danger">*</span></label>
                            <input type="number" name="stock" id="stock" class="form-control disabled" value="0" step="any">
                            <span class="invalid-feedback" role="alert">
                                <strong id="error-stock"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label">Unit Price: <span class="text-danger">*</span></label>
                            <input type="number" name="unit_price" id="unit_price" class="form-control disabled" step="any">
                            <span class="invalid-feedback" role="alert">
                                <strong id="error-unit_price"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label">Expiration: </label>
                            <input type="date" name="expiration" id="expiration" class="form-control disabled">
                            <span class="invalid-feedback" role="alert">
                                <strong id="error-expiration"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group" id="image-section">
                            <label class="form-label">Image : <span class="text-danger">*</span></label>
                            <input type="file" name="image1" class="form-control image1" accept="image/*">
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
                                    <img style="vertical-align: bottom;" id="current_image1" height="150" width="150" src="" />
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
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        $.extend(true, $.fn.dataTable.defaults, {
            pageLength: 10,
            'columnDefs': [{
                'orderable': false,
                'targets': 0
            }],
        });

        var table = $('.datatable-table:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $('.select2').select2();

        $('#category_dd').on('change', function() {
            table.columns(5).search(this.value).draw();
        });

        $('#unit_dd').on('change', function() {
            table.columns(2).search(this.value).draw();
        });

    });

    $(document).on('click', '#create_record', function() {
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

    $('#myForm').on('submit', function(event) {
        event.preventDefault();
        $('.form-control').removeClass('is-invalid')
        var action_url = "{{ route('admin.products.store') }}";
        var type = "POST";

        if ($('#action').val() == 'Edit') {
            var id = $('#hidden_id').val();
            action_url = "products/update/" + id;
            type = "POST";
        }

        $.ajax({
            url: action_url,
            method: type,
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,

            dataType: "json",
            beforeSend: function() {
                $("#action_button").attr("disabled", true);
                $("#action_button").attr("value", "Loading..");
            },
            success: function(data) {
                if ($('#action').val() == 'Edit') {
                    $("#action_button").attr("disabled", false);
                    $("#action_button").attr("value", "Update");
                } else {
                    $("#action_button").attr("disabled", false);
                    $("#action_button").attr("value", "Submit");
                }
                if (data.errors) {
                    $.each(data.errors, function(key, value) {
                        if (key == $('#' + key).attr('id')) {
                            $('#' + key).addClass('is-invalid')
                            $('#error-' + key).text(value)
                        }
                        if (key == 'image1') {
                            $('.image1').addClass('is-invalid')
                            $('#error-image1').text(value)
                        }

                    })
                }
                if (data.success) {
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
                                action: function() {
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


    $('#formModal').on('shown.bs.modal', function() {
        $('#added_stock').focus();
    })
</script>
@endsection