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
                            <div class="col-md-4">
                                <h4 class="mb-0 text-uppercase" id="titletable">Sales Reports</h4>
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
                            <div class="col-md-4">
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
                                    <th>ORDER ID</th>
                                    <th>PRODUCT</th>
                                    <th>PRICE</th>
                                    <th>SOLD</th>
                                    <th>AMOUNT</th>
                                    <th>ORDER AT</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase font-weight-bold">
                                @foreach($sales as $order)
                                        <tr>
                                            <td>
                                                {{$order->id ?? ''}}
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
                                    <th>DATE:</th>
                                    <th>{{$ldate}}</th>
                                    <th >USER:</th>
                                    <th >{{auth()->user()->name}}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-2">
                    <div class = "card p-3">
                        <canvas id="salesChart"></canvas>
                    </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalChart" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times text-primary"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div class="text-center pt-1 bg-gradient-primary shadow-primary text-white">
                                    <h4 class="mb-0 text-white" id="sales">02</h4>
                                    <p class="text-sm mb-0 text-capitalize">SALES</p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-header p-3 pt-2">
                                <div class="text-center pt-1 bg-gradient-info shadow-primary text-white">
                                    <h4 class="mb-0 text-white" id="predic">02</h4>
                                    <p class="text-sm mb-0 text-capitalize">PREDICTION</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3>Product Orders</h3>
                <div class="table-responsive">
                    <table class="table display" id="table_chart" width="100%">
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
                        <tbody class="text-uppercase font-weight-bold" id="list_chart">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="{{ asset('js/chart.js') }}"></script>
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
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
            }, 0);

            profit = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
            }, 0);


            $(api.column(5).footer()).html(number_format(total, 2,'.', ','));
            $(api.column(6).footer()).html(number_format(profit, 2,'.', ','));


        },
    });

    let ctx = document.getElementById('salesChart');
     let salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [
                    {
                        label: 'Sales Chart',
                        data: @json($data),
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        borderWidth: 3
                    },
                    {
                        label: 'Prediction',
                        data: @json($datap),
                        backgroundColor: "rgba(19, 161, 52, 0.13)",
                        borderColor: "rgba(19, 161, 52, 0.13)",
                        borderWidth: 3
                    },
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });



        ctx.addEventListener('click', function(evt) {
        var firstPoint = salesChart.getElementAtEvent(evt)[0];
            if (firstPoint) {
                var label = salesChart.data.labels[firstPoint._index];
                var value = salesChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];

                // alert('Label: ' + label + "\nValue: " + value);

                $('#modalChart').modal('show');
                $('.modal-title').text('FILTER DATE: '+ label);

                $.ajax({
                    url :"/admin/chart_reports/"+label,
                    data: { filter : $('#filter_dd').val()},
                    dataType:"json",
                    beforeSend:function(){
                        //$("#action_button").attr("disabled", true);
                    },
                    success:function(data){
                        //$("#action_button").attr("disabled", false);
                        var chart_data = "";
                        $('#sales').text(number_format(data.sales, 2,'.', ','));
                        $('#predic').text(number_format(data.predic, 2,'.', ','));
                        console.log(data.filter);
                        $.each(data.result, function(key,value){
                           var new_date = moment(value.created_at).format('DD-MM-YYYY');
                            chart_data += `
                                        <tr>
                                            <td>
                                                `+value.id+`
                                            </td>
                                            <td>
                                                `+value.description+`
                                            </td>
                                            <td>
                                                `+value.price+`
                                            </td>
                                            <td>
                                                `+value.qty+`
                                            </td>
                                            <td>
                                                `+value.amount+`
                                            </td>
                                            <td>
                                                `+new_date+`
                                            </td>
                                        </tr>
                            `;
                        })
                        $('#list_chart').empty().append(chart_data);
                        $('#table_chart').DataTable({
                            bDestroy: true,
                            responsive: true,
                            scrollY: 500,
                            scrollCollapse: true,
                            buttons: [
                                {
                                    extend: 'excel',
                                    className: 'd-none',
                                    title: title,
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'print',
                                    title:  '<center>' + header + '</center>',
                                    className: 'd-none',

                                }
                            ],
                        });

                    }
                })
            }


        });


});



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




