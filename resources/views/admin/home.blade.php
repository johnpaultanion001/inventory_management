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
                <p class="text-sm mb-0 text-capitalize">SALES FOR TODAY</p>
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
            <h4 class="text-sm mb-0 text-capitalize text-primary">Sold product as of today</h4>
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
            <h4 class="text-sm mb-0 text-capitalize text-primary">Sales product as of today</h4>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
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
  $(function(){
        var dataSales = JSON.parse(`<?php echo $sales_results; ?>`);
        var salesChart = $("#salesChart");

        var dataSold = JSON.parse(`<?php echo $sold_results; ?>`);
        var soldChart = $("#soldChart");

    

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

        new Chart(salesChart, {
            type: "line",
            data: dataSales,
            options: options
        });

        new Chart(soldChart, {
            type: "line",
            data: dataSold,
            options: options
        });


    });
</script>
@endsection




