@extends('../layouts.admin')
@section('sub-title','Sales Reports')
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
                            <div class="col-md-5">
                                <h4 class="mb-0 text-uppercase" id="titletable">Salesforcast</h4>
                                <b class="mb-0 text-uppercase">{{$title_filter}}</b>
                            </div>
                            <div class="col-md-4">
                                @if(request()->is('admin/sales_reports/fbd/*'))
                                <div class="form-group">
                                   <label for="from">FROM:</label>
                                   <input type="date" name="from" id="from" class="form-control">
                                   <label for="to">TO:</label>
                                   <input type="date" name="to" id="to" class="form-control">
                                   <button class="btn-primary btn btn-sm mt-2 btn_filter_date">SUBMIT</button>
                                </div>
                                @endif

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="filter_dd" id="filter_dd" class="select2" style="width: 100%;">
                                        <option value="fbd" {{ request()->is('admin/sales_reports/fbd/*') ? 'selected' : '' }}>FILTER BY FROM AND TO DATE</option>
                                        <option value="daily" {{ request()->is('admin/sales_reports/daily/*') ? 'selected' : '' }}>DAILY</option>
                                        <option value="weekly" {{ request()->is('admin/sales_reports/weekly/*') ? 'selected' : '' }}>WEEKLY</option>
                                        <option value="monthly" {{ request()->is('admin/sales_reports/monthly/*') ? 'selected' : '' }}>MONTHLY</option>
                                        <option value="yearly" {{ request()->is('admin/sales_reports/yearly/*') ? 'selected' : '' }}>YEARLY</option>
                                        <option value="all" {{ request()->is('admin/sales_reports/all/*') ? 'selected' : '' }}>ALL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ORDER ID</th>
                                    <th scope="col">CATEGORY</th>
                                    <th scope="col">PRODUCT</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">SOLD</th>
                                    <th scope="col">AMOUNT</th>
                                    <th scope="col">ORDER AT</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase font-weight-bold">
                                @foreach($sales as $order)
                                        <tr>
                                            <td>
                                                {{$order->id ?? ''}}
                                            </td>
                                            <td>
                                                {{$order->category ?? ''}}
                                            </td>
                                            <td>
                                                {{$order->product->description ?? ''}}
                                            </td>
                                            <td>
                                                {{$order->price ?? ''}}
                                            </td>
                                            <td>
                                                {{$order->qty ?? ''}}
                                            </td>

                                            <td>
                                                {{ number_format($order->amount ?? '' , 2, '.', ',') }}

                                            </td>
                                            <td>
                                                {{ $order->created_at->format('M j , Y h:i A') }}
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="text-uppercase font-weight-bold">
                                <tr>
                                    <th scope="col">DATE:</th>
                                    <th scope="col">{{$ldate}}</th>
                                    <th  scope="col">USER:</th>
                                    <th  scope="col">{{auth()->user()->name}}</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-2">

                <div class = "card p-3">
                        <div class="col-md-5">
                            <div class="form-group">
                                    <b class="mb-0 text-uppercase" id="title_chart">Filter by year:</b>
                                    <select name="filter_year" id="filter_year" class="select2 form-control" style="width: 100%;">
                                        @foreach($years_dropdown as $years)
                                            <option value="{{$years['year'] ?? ''}}"> {{$years['year'] ?? ''}} @if($years['year'] > date('Y') ) (Forcast) @endif</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div id="bar_chart_value">

                            </div>
                        </div>


                </div>
            </div>
    </div>


    <div class="modal fade" id="formModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times text-primary"></i>
                    </button>

                    </div>
                    <div class="modal-body row  d-flex justify-content-center">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead class="thead-dark text-center">
                                    <tr class="table-dark">
                                        <th scope="col">Category</th>
                                        <th scope="col">Year</th>
                                        <th scope="col">Month</th>
                                        <th scope="col">Demand</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" id="list_2024">

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <img id="regression" width="100%" height="100%" class="d-inline-block align-top" alt="Loading">
                        </div>



                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
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
    $('.datatable-table').DataTable({
        bDestroy: true,
        responsive: true,
        scrollY: 500,
        scrollCollapse: true,
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
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[^\d.-]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };


            total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
            }, 0);

            profit = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
            }, 0);


            $(api.column(4).footer()).html(number_format(total, 2,'.', ','));
            $(api.column(5).footer()).html(number_format(profit, 2,'.', ','));


        },
    });

    var currentTime = new Date()
    var year = currentTime.getFullYear()
    $('#filter_year').val(year);

    $('#filter_year').on("change", function(event){
        filter_year = $(this).val();
        bar_chart_value(filter_year);
    });
    bar_chart_value(year)
});



function bar_chart_value(filter_year){
    $.ajax({
        url :"/admin/forcasts/bar_charts_value/"+filter_year,
        type: "get",
        dataType: "HTMl",
        beforeSend: function() {
            $('#bar_chart_value').hide();
            $('#title_chart').text('Processing...')
        },
        success: function(response){
            $('#title_chart').text('Filter by year:')
            $('#bar_chart_value').show();
            $("#bar_chart_value").html(response);
        }
    })
}


function table_chart(){
    $('#table_chart').DataTable({
        bDestroy: true,
        responsive: true,
        scrollY: 500,
        scrollCollapse: true,
    });
}


var filter_type = "";
$('#filter_dd').on("change", function(event){
        filter_type = $(this).val();

        window.location.href = '/admin/sales_reports/'+filter_type+'/'+filter_type+'/'+filter_type;

});

$('.btn_filter_date').on("click", function(event){
        var from = $('#from').val();
        var to = $('#to').val();
        if(from == ""){
            alert('From date field is required')
        }else if(to == ""){
            alert('To date field is required')
        }
        else{
            window.location.href = '/admin/sales_reports/fbd/'+from+'/'+to;
        }
});




</script>
@endsection




