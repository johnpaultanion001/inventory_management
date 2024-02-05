<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <div class="row justify-content-md-center text-center">

                    <div class="col-md-10">
                    <img src="/assets/img/logo.jpeg" width="70px" class="d-inline-block align-top logo-resibo mb-2" alt="">
                        <h6 class="text-uppercase text-dark">TRIPLE J SAVERS MART </h6>
                        <h6 class="text-uppercase text-dark">Cabuyao Laguna (0118 Banay-banay Cabuyao)</h6>
                        <h6 class="text-uppercase text-dark">0911-222-3333</h6>
                    </div>
                </div>
            </div>

            <hr style="border-top: 2px dashed gray;">
            <div class="justify-content-between"  style="display:flex;">
                <p class="text-uppercase text-dark">DATE: {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y / h:i:s A')}}</p>
                <p class="text-uppercase text-dark">ORDER #: {{$order->id ?? ''}}</p>
            </div>
            <p>{{$order->supplier ?? ''}}</p>
            <hr style="border-top: 2px dashed gray;">
            <div class="col-12">
                <div class="row ">
                    @foreach($order->deliveries as $order_product)
                        <div class="col-6">
                            <p>{{$order_product->qty ?? ''}} - {{$order_product->product->description ?? ''}}({{$order_product->product->code ?? ''}})(EXP:{{$order_product->expiration ?? ''}})</p>
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
                        <div class="col-6">
                            <small class="text-uppercase text-dark">PREPARED BY: {{$order->user->name}}</small>
                        </div>
                        <div class="col-6 text-right">
                        </div>

                </div>
            </div>

        </div>
    </div>

</div>
