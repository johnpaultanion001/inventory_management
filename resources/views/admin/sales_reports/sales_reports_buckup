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
                        <div >
                            <h6>FILTER BY YEAR:</h6>
                            <input type="checkbox" class="btn-check" id="btn-check-2021"  autocomplete="off">
                            <label class="btn btn-outline-dark" for="btn-check-2021">2021</label>

                            <input type="checkbox" class="btn-check" id="btn-check-2022"  autocomplete="off">
                            <label class="btn btn-outline-dark" for="btn-check-2022">2022</label>

                            <input type="checkbox" class="btn-check" id="btn-check-2023" checked autocomplete="off">
                            <label class="btn btn-outline-dark" for="btn-check-2023">2023</label>

                            <input type="checkbox" class="btn-check" id="btn-check-2024"  autocomplete="off">
                            <label class="btn btn-outline-dark" for="btn-check-2024">2024</label>
                        </div>

                        <div class="row">
                            <div class="chart_2023">
                                <h5>PRODUCT DEMAND (2023)</h5>
                                <h6>From: Jan 1, 2023 To: Dec 31, 2023</h6>
                                <canvas id="salesChart"></canvas>
                            </div>
                            <div class="chart_2024">
                                <h5>PRODUCT DEMAND (2024)</h5>
                                <h6>From: Jan 1, 2024 To: Dec 31, 2024</h6>
                                <canvas id="salesChart2024"></canvas>
                            </div>
                            <div class="chart_2021">
                                <h5>PRODUCT DEMAND (2021)</h5>
                                <h6>From: Jan 1, 2021 To: Dec 31, 2021</h6>
                                <canvas id="salesChart2021"></canvas>
                            </div>
                            <div class="chart_2022">
                                <h5>PRODUCT DEMAND (2022)</h5>
                                <h6>From: Jan 1, 2022 To: Dec 31, 2022</h6>
                                <canvas id="salesChart2022"></canvas>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="{{ asset('js/chart.js') }}"></script>
<script>


$(function () {
    $('.chart_2023').show();
    $('.chart_2024').hide();
    $('.chart_2021').hide();
    $('.chart_2022').hide();



    $("#btn-check-2021").on("click", function(){
        if($("#btn-check-2021").is(":checked")) {
            $('.chart_2021').show();
        } else {
            $('.chart_2021').hide();

        }
    });

    $("#btn-check-2022").on("click", function(){
        if($("#btn-check-2022").is(":checked")) {
            $('.chart_2022').show();
        } else {
            $('.chart_2022').hide();
        }
    });

    $("#btn-check-2023").on("click", function(){
        if($("#btn-check-2023").is(":checked")) {
            $('.chart_2023').show();
        } else {
            $('.chart_2023').hide();
        }
    });

    $("#btn-check-2024").on("click", function(){
        if($("#btn-check-2024").is(":checked")) {
            $('.chart_2024').show();
        } else {
            $('.chart_2024').hide();
        }
    });

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

    //2023
    let ctx = document.getElementById('salesChart');
    let salesChart = new Chart(ctx, {
        type: 'bar',
        fill: true,
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Beverages',
                    data: @json($montly_sold[0]),
                    borderColor: "gold",
                    borderWidth: 3
                },
                {
                    label: 'Canned Foods',
                    data: @json($montly_sold[1]),
                    borderColor: "pink",
                    borderWidth: 3
                },
                {
                    label: 'Condiments',
                    data: @json($montly_sold[2]),
                    borderColor: "rgba(153, 102, 255, 0.2)",
                    borderWidth: 3
                },
                {
                    label: 'Food Area',
                    data: @json($montly_sold[3]),
                    borderColor: "blue",
                    borderWidth: 3
                },
                {
                    label: 'Personal Care',
                    data: @json($montly_sold[4]),
                    borderColor: "green",
                    borderWidth: 3
                },
                {
                    label: 'Soap Area',
                    data: @json($montly_sold[5]),
                    borderColor: "red",
                    borderWidth: 3
                },
                {
                    label: 'Others',
                    data: @json($montly_sold[6]),
                    borderColor: "#111",
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





    //2021
    let ctx2021 = document.getElementById('salesChart2021');
    let salesChart2021 = new Chart(ctx2021, {
        type: 'bar',
        fill: true,
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Beverages',
                    data: @json($montly_sold2021[0]),
                    borderColor: "gold",
                    borderWidth: 3
                },
                {
                    label: 'Canned Foods',
                    data: @json($montly_sold2021[1]),
                    borderColor: "pink",
                    borderWidth: 3
                },
                {
                    label: 'Condiments',
                    data: @json($montly_sold2021[3]),
                    borderColor: "rgba(153, 102, 255, 0.2)",
                    borderWidth: 3
                },
                {
                    label: 'Food Area',
                    data: @json($montly_sold2021[2]),
                    borderColor: "blue",
                    borderWidth: 3
                },

                {
                    label: 'Personal Care',
                    data: @json($montly_sold2021[4]),
                    borderColor: "green",
                    borderWidth: 3
                },
                {
                    label: 'Soap Area',
                    data: @json($montly_sold2021[5]),
                    borderColor: "red",
                    borderWidth: 3
                },
                {
                    label: 'Others',
                    data: @json($montly_sold2021[6]),
                    borderColor: "#111",
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

    //2022
    let ctx2022 = document.getElementById('salesChart2022');
    let salesChart2022 = new Chart(ctx2022, {
        type: 'bar',
        fill: true,
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Beverages',
                    data: @json($montly_sold2022[0]),
                    borderColor: "gold",
                    borderWidth: 3
                },
                {
                    label: 'Canned Foods',
                    data: @json($montly_sold2022[1]),
                    borderColor: "pink",
                    borderWidth: 3
                },

                {
                    label: 'Condiments',
                    data: @json($montly_sold2022[3]),
                    borderColor: "rgba(153, 102, 255, 0.2)",
                    borderWidth: 3
                },
                {
                    label: 'Food Area',
                    data: @json($montly_sold2022[2]),
                    borderColor: "blue",
                    borderWidth: 3
                },
                {
                    label: 'Personal Care',
                    data: @json($montly_sold2022[4]),
                    borderColor: "green",
                    borderWidth: 3
                },
                {
                    label: 'Soap Area',
                    data: @json($montly_sold2022[5]),
                    borderColor: "red",
                    borderWidth: 3
                },
                {
                    label: 'Others',
                    data: @json($montly_sold2022[6]),
                    borderColor: "#111",
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

    //2024
    let ctx2024 = document.getElementById('salesChart2024');
    let salesChart2024 = new Chart(ctx2024, {
        type: 'bar',
        fill: true,
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Beverages',
                    data: @json($montly_sold2024[0]),
                    borderColor: "gold",
                    borderWidth: 3
                },
                {
                    label: 'Canned Foods',
                    data: @json($montly_sold2024[1]),
                    borderColor: "pink",
                    borderWidth: 3
                },
                {
                    label: 'Condiments',
                    data: @json($montly_sold2024[3]),
                    borderColor: "rgba(153, 102, 255, 0.2)",
                    borderWidth: 3
                },
                {
                    label: 'Food Area',
                    data: @json($montly_sold2024[2]),
                    borderColor: "blue",
                    borderWidth: 3
                },

                {
                    label: 'Personal Care',
                    data: @json($montly_sold2024[4]),
                    borderColor: "green",
                    borderWidth: 3
                },
                {
                    label: 'Soap Area',
                    data: @json($montly_sold2024[5]),
                    borderColor: "red",
                    borderWidth: 3
                },
                {
                    label: 'Others',
                    data: @json($montly_sold2024[6]),
                    borderColor: "#111",
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

    console.log("test:"+@json($montly_sold2024));



    ctx.addEventListener('click', function(evt) {
        var firstPoint = salesChart.getElementAtEvent(evt)[0];
        if (firstPoint) {
            var label = salesChart.data.labels[firstPoint._index];
            var value = salesChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
            var legend =  salesChart.data.datasets[firstPoint._datasetIndex].label;


            window.open("/admin/salesforcast/"+legend+"/"+label+"/2023");

        }


    });

    ctx2021.addEventListener('click', function(evt) {
        var firstPoint = salesChart2021.getElementAtEvent(evt)[0];
        if (firstPoint) {
            var label = salesChart2021.data.labels[firstPoint._index];
            var value = salesChart2021.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
            var legend =  salesChart2021.data.datasets[firstPoint._datasetIndex].label;

            // alert('Label: ' + label + "\nValue: " + value);
            window.open("/admin/salesforcast/"+legend+"/"+label+"/2021");
        }


    });
    ctx2022.addEventListener('click', function(evt) {
        var firstPoint = salesChart2022.getElementAtEvent(evt)[0];
        if (firstPoint) {
            var label = salesChart2022.data.labels[firstPoint._index];
            var value = salesChart2022.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
            var legend =  salesChart2022.data.datasets[firstPoint._datasetIndex].label;

            window.open("/admin/salesforcast/"+legend+"/"+label+"/2022");
        }


    });

    ctx2024.addEventListener('click', function(evt) {
        var firstPoint = salesChart2024.getElementAtEvent(evt)[0];
        if (firstPoint) {
            var label = salesChart2024.data.labels[firstPoint._index];
            var value = salesChart2024.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
            var legend =  salesChart2024.data.datasets[firstPoint._datasetIndex].label;

            $('#formModal').modal('show');
            $('.modal-title').text('View Chart');
            $.ajax({
                url :"/admin/forcast/2024/edit",
                dataType:"json",
                data:{'month':label, 'category':legend},
                beforeSend:function(){
                },
                success:function(data){

                    var list_2024 = "";
                    $.each(data.forcasting, function(key,value){

                        list_2024 += `
                                    <tr class=`+value.class+`>
                                        <td>`+value.category+`</td>
                                        <td>`+value.year+`</td>
                                        <td>`+value.month+`</td>
                                        <td>`+value.demand+`</td>
                                    </tr>
                            `;
                    })
                    list_2024 += `
                                    <tr class="table-dark">
                                        <td><b>Top Products</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                            `;
                    $.each(data.tp2024, function(key,value){
                        var id = key + 1;
                        list_2024 += `
                                    <tr class="table-secondary">
                                        <td><b>`+id+`</b></td>
                                        <td></td>
                                        <td></td>
                                        <td><span class="bg-success badge">`+value.description+`</span></td>
                                    </tr>
                            `;
                    })


                    $('#list_2024').empty().append(list_2024);
                    $('#regression').attr('src',data.regression);

                    console.log(data.tp2024);


                }
            })

        }


    });
});

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




