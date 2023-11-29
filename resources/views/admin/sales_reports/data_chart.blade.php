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
                            <div class="col-md-12">
                                <h4 class="mb-0 text-uppercase" id="titletable">Salesforcast</h4>
                                <p class="mb-0 text-uppercase">{{$title_filter}}</p>
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
                                            <td class="text-center">
                                                {{$order->qty ?? ''}}
                                            </td>

                                            <td class="text-center">
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
                                    <th scope="col">DATE: {{$ldate}}</th>
                                    <th scope="col"></th>
                                    <th  scope="col">USER: {{auth()->user()->name}}</th>
                                    <th  scope="col"></th>
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



});
</script>
@endsection




