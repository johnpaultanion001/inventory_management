@extends('../layouts.admin')
@section('sub-title','Orders')
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
                            <div class="col-md-11">
                                <h4 class="mb-0 text-uppercase" id="titletable">Manage Orders</h4>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" cellspacing="0" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">ORDER ID</th>

                                    <th scope="col">CUSTOMER NAME</th>
                                    <th scope="col">PRODUCT BUY</th>
                                    <th scope="col">AMOUNT</th>
                                    <th scope="col">ORDER AT</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase font-weight-bold">
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <button type="button" name="status" status="{{  $order->id ?? '' }}"  action_type="STATUS"
                                                class="btn btn-sm
                                                @if($order->status == 'PENDING')
                                                    btn-warning status
                                                @elseif($order->status == 'APPROVED')
                                                    btn-success status
                                                @else
                                                    btn-danger
                                                @endif">
                                                {{$order->status}}

                                            </button>
                                            <br>
                                            @if($order->status == 'CANCELLED')
                                            <small> Reason of Cancel: {{$order->cancel_reason}}</small>

                                            @endif
                                        </td>
                                        <td>
                                            {{  $order->id ?? '' }}
                                        </td>

                                        <td>
                                            {{  $order->user->name ?? '' }}
                                        </td>
                                        <td>

                                            @foreach($order->orderproducts as $product_order)
                                                <span class="badge bg-success">{{$product_order->qty}} {{$product_order->product->name}} * {{$product_order->price}} = {{ number_format($product_order->amount ?? '' , 2, '.', ',') }}</span>


                                                <br>
                                            @endforeach


                                        </td>
                                        <td>
                                            ₱ {{ number_format($order->orderproducts->sum('amount')  ?? '' , 2, '.', ',') }}
                                        </td>
                                        <td>
                                            {{ $order->created_at->format('M j , Y h:i A') }}
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
        });

        $('.datatable-table:not(.ajaxTable)').DataTable({ buttons: dtButtons });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
            });
    });



</script>
@endsection




