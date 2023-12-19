<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <h6 class="text-uppercase text-dark text-center">Triple J Savers Mart</h6>
            <h6 class="text-uppercase text-dark text-center">Brgy san jose, Antipolo City</h6>
            <h6 class="text-uppercase text-dark text-center">0911-222-3333</h6>
            <hr style="border-top: 2px dashed gray;">
            <div class="justify-content-between"  style="display:flex;">
                <p class="text-uppercase text-dark">DATE: {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y / h:i:s A')}}</p>
                <p class="text-uppercase text-dark">ORDER #: {{$order->id ?? ''}}</p>
            </div>
            <hr style="border-top: 2px dashed gray;">
            <div class="col-12">
                <div class="row ">
                    @foreach($order->deliveries as $order_product)
                        <div class="col-6">
                            <p>{{$order_product->qty ?? ''}} - {{$order_product->product->description ?? ''}}</p>
                        </div>
                        <div class="col-6 text-right">
                            <p>₱ {{ number_format($order_product->total ?? '' , 2, '.', ',') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr style="border-top: 2px dashed gray;">
            <div class="col-12">
                <div class="row">
                        <div class="col-6">
                            <p class="text-uppercase text-dark">SUBTOTAL</p>
                        </div>
                        <div class="col-6 text-right">
                            <p class="text-uppercase text-dark">₱ {{ number_format($order->deliveries->sum->total ?? '' , 2, '.', ',') }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-uppercase text-dark">TOTAL</p>
                        </div>
                        <div class="col-6 text-right">
                            <p class="text-uppercase text-dark">₱ {{ number_format($order->deliveries->sum->total ?? '' , 2, '.', ',') }}</p>
                        </div>

                </div>
            </div>

        </div>
    </div>

</div>
