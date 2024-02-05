@extends('../layouts.admin')
@section('sub-title','Inventory Reports')
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
                            <div class="col-md-6">
                                <h4 class="mb-0 text-uppercase" id="titletable">Inventory Reports as OF ({{$ldate}})</h4>
                            </div>
                            <div class="col-md-6 row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="category_dd" id="category_dd" class="select2" style="width: 100%;">
                                            <option value="">FILTER CATEGORY</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->name}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="filter_date">Filter Date: </label>
                                        <input type="date" id="filter_date" name="filter_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">CATEGORY</th>
                                    <th  scope="col">CODE</th>
                                    <th scope="col">DESCRIPTION</th>
                                    <th scope="col">BEGINNING INVENTORY</th>
                                    <th scope="col">SALES INVENTORY</th>
                                    <th scope="col">DELIVERY INVENTORY</th>
                                    <th scope="col">BACK ORDER</th>
                                    <th scope="col">PHYSICAL COUNT(+)</th>
                                    <th scope="col">PHYSICAL COUNT(-)</th>
                                    <th scope="col">ENDING INVENTORY</th>

                                </tr>
                            </thead>

                            <tbody class="text-uppercase font-weight-bold">
                                @foreach($productss as $product)
                                    <tr>
                                        <td>
                                            {{  $product['category'] ?? '' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{   $product['code'] ?? '' }}</span>
                                        </td>

                                        <td>
                                            {{  $product['description'] ?? '' }}
                                        </td>
                                        <td>
                                             {{  $product['beginning_inventory'] ?? '' }}
                                        </td>
                                        <td>
                                             {{  $product['sales_inventory'] ?? '' }}
                                        </td>
                                        <td>
                                             {{  $product['delivery_inventory'] ?? '' }}
                                        </td>
                                        <td>
                                             {{  $product['bad_order'] ?? '' }}
                                        </td>
                                        <td>
                                             {{  $product['phy_add'] ?? '' }}
                                        </td>
                                        <td>
                                             {{  $product['phy_minus'] ?? '' }}
                                        </td>
                                        <td>
                                             {{  $product['ending_inventory'] ?? '' }}
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
    @section('footer')
        @include('../partials.admin.footer')
    @endsection
@endsection


@section('script')
<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    $.extend(true, $.fn.dataTable.defaults, {
    pageLength: 25,
    'columnDefs': [{ 'orderable': false, 'targets': 0 }],
    });

    var table = $('.datatable-table:not(.ajaxTable)').DataTable({ buttons: dtButtons });
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
        });

    $('.select2').select2();

    $('#category_dd').on('change', function () {
        table.columns(0).search( this.value ).draw();
    });


});

$('#filter_date').on("input", function() {
    filter_date = this.value;
    console.log(filter_date);
    window.location.href = '/admin/inventory_reports/'+filter_date;

});




</script>
@endsection




