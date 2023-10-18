@extends('../layouts.admin')
@section('sub-title','Dashboard')
@section('navbar')
    @include('../partials.admin.navbar')
@endsection
@section('sidebar')
    @include('../partials.admin.sidebar')
@endsection

@section('content')
<div class="container-fluid py-4">
      <div class="row">

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-primary text-center mt-n4 position-absolute">
                <i class="fas fa-list" style="font-size: 17px"></i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">PRODUCTS FOR TODAY</p>
                <h4 class="mb-0">{{$products_today->count()}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0">Total Product <span class="text-success text-sm font-weight-bolder">{{$products->count()}}</span></p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-success text-center mt-n4 position-absolute">
                <i class="material-icons opacity-10 text-primary">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">CUSTOMER FOR TODAY</p>
                <h4 class="mb-0">{{$customers_today->count()}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0">Total Customer <span class="text-success text-sm font-weight-bolder">{{$customers->count()}}</span></p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-info text-center mt-n4 position-absolute">
                <i class="fas fa-shopping-cart text-dark" style="font-size: 17px"></i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">ORDERS FOR TODAY</p>
                <h4 class="mb-0">{{$orders_today->count()}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0">Total Order <span class="text-success text-sm font-weight-bolder">{{$orders->count()}}</span></p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-info text-center mt-n4 position-absolute">
                <i class="fas fa-shopping-cart text-info" style="font-size: 17px"></i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">SALES AS OF TODAY</p>
                <h4 class="mb-0">{{ number_format($sales_today ?? '0' , 2, '.', ',') }}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0">Total Sales <span class="text-success text-sm font-weight-bolder">{{ number_format($sales ?? '0' , 2, '.', ',') }}</span></p>
            </div>
          </div>
        </div>
        <div class="col-xl-12 mt-3">
          <div class="card">
            <div class="card-body">
            <h4 class="text-sm mb-0 text-uppercase text-primary">Sold product as of today ({{$ldate}})</h4>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="soldChart"></canvas>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-xl-12 mt-3">
          <div class="card">
            <div class="card-body">
            <h4 class="text-sm mb-0 text-uppercase text-primary">Sales product as of today ({{$ldate}})</h4>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-xl-12 mt-3">
          <div class="card">
            <div class="card-body">
            <h4 class="text-sm mb-0 text-capitalize text-primary">Product lower stock ( < 5 )</h4>
                <div class="card-body">
                    <div class="table-responsive">
                            <table class="table display" cellspacing="0" width="100%">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th scope="col">Product Code</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Stock</th>
                                    </tr>
                                </thead>
                                <tbody class="text-uppercase font-weight-bold text-center">
                                    @foreach($productsLowerStocks as $product)
                                        <tr>

                                            <td>
                                                {{  $product->code ?? '' }}
                                            </td>
                                            <td>
                                                {{  $product->description ?? '' }}
                                            </td>
                                            <td>
                                                {{  $product->stock ?? '' }}
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
                                    <p class="text-sm mb-0 text-capitalize">SALES LAST MONTH</p>

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
<script>
  $(function(){
        var dataSales = JSON.parse(`<?php echo $sales_results; ?>`);
        let salesChart = document.getElementById('salesChart');

        var dataSold = JSON.parse(`<?php echo $sold_results; ?>`);
        let soldChart =  document.getElementById('soldChart');



        var dataSales = {
            labels: dataSales.label,
            datasets: [
            {
                label: "SALES:",
                data: dataSales.data,

                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,

            }
            ]
        };

        var dataSold = {
            labels: dataSold.label,
            datasets: [
            {
                label: "SOLD:",
                data: dataSold.data,

                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,

            }
            ]
        };

        var options = {
            maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                },
        };


        let sales = new Chart(salesChart, {
            type: "line",
            data: dataSales,
            options: options
        });

        let sold =  new Chart(soldChart, {
            type: "line",
            data: dataSold,
            options: options
        });

        salesChart.addEventListener('click', function(evt) {
            var firstPoint = sales.getElementAtEvent(evt)[0];
            if (firstPoint) {
                var label = sales.data.labels[firstPoint._index];
                var value = sales.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];

                // alert('Label: ' + label + "\nValue: " + value);

                $('#modalChart').modal('show');
                $('.modal-title').text('PRODUCT CODE: '+ label);

                $.ajax({
                    url :"/admin/chart_reports/"+label,
                    data: { filter : "home"},
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

        soldChart.addEventListener('click', function(evt) {
            var firstPoint = sold.getElementAtEvent(evt)[0];
            if (firstPoint) {
                var label = sold.data.labels[firstPoint._index];
                var value = sold.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];

                // alert('Label: ' + label + "\nValue: " + value);

                $('#modalChart').modal('show');
                $('.modal-title').text('PRODUCT CODE: '+ label);

                $.ajax({
                    url :"/admin/chart_reports/"+label,
                    data: { filter : "home"},
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
</script>
@endsection




