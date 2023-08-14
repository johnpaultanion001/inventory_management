<div class="col-xl-12">
    <div class="card">
        <h5 class="text-center">ORDER #: {{$order->id ?? ''}}</h5>
        <div class="card-body">
            <p class="text-uppercase text-dark">Name: {{$order->user->name ?? ''}}</p>
            <p class="text-uppercase text-dark">Address: {{$order->user->address ?? ''}}</p>
            <p class="text-uppercase text-dark">Contact #: {{$order->user->contact_number ?? ''}}</p>
            <p class="text-uppercase text-dark">Note : {{$order->note ?? ''}}</p>
            <hr style="border-top: 2px dashed gray;">
            <p class="text-uppercase text-dark">DATE: {{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y / h:i:s A')}}</p>
            <hr style="border-top: 2px dashed gray;">
            <div class="col-12">
                <div class="row">
                    @foreach($order->orderproducts as $product)
                        <div class="col-6">
                            <p>{{$product->qty ?? ''}} {{$product->product->name ?? ''}}</p> 
                        </div>
                        <div class="col-6 text-right">
                            <p>₱ {{ number_format($product->amount ?? '' , 2, '.', ',') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr style="border-top: 2px dashed gray;">
            <div class="col-12">
                <div class="row">
                   <?php
                    $subtotal = $order->orderproducts->sum->amount;
                    $service_fee = $order->shipping_fee;
                    $total = $subtotal + $service_fee;
                   ?>
                        <div class="col-6">
                            <p class="text-uppercase text-dark">SUBTOTAL</p> 
                        </div>
                        <div class="col-6 text-right">
                            <p class="text-uppercase text-dark">₱ {{ number_format($order->orderproducts->sum->amount ?? '' , 2, '.', ',') }}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-uppercase text-dark">DELIVERY FEE</p> 
                        </div>
                        <div class="col-6 text-right">
                            <p class="text-uppercase text-dark">₱ {{number_format($order->shipping_fee ?? '' , 2, '.', ',')}}</p>
                        </div>
                        <div class="col-6">
                            <p class="text-uppercase text-dark">TOTAL</p> 
                        </div>
                        <div class="col-6 text-right">
                            <p class="text-uppercase text-dark">₱ {{ number_format($total ?? '' , 2, '.', ',') }}</p>
                        </div>
                   
                </div>
            </div>
            
        </div>
    </div>
    
</div>