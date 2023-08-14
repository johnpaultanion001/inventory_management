@extends('../layouts.customer')
@section('navbar')
    @include('../partials.customer.navbar')
@endsection


@section('content')
@php
    $layoutStyles = App\Models\LayoutStyle::where('id', 1)->first();
@endphp

<header class="py-5 banner">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center">
            <img src="/assets/img/{{$layoutStyles->banner_logo}}" alt="" width = "20%">
        </div>
    </div>
</header>

<section class="py-5">
        <div class="col-xl-4 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
                <div class="card-body">
                        <div class="card-header text-center">
                            <h3 class="card-title title-up">
                            THANK YOU FOR REGISTERING PLEASE WAIT FOR A RESPONSE
                            FOR AN ADMINISTRATOR TO CONFIRM YOUR REGISTRATION ESTIMATED TIME OF
                            2-8 HOURS
                            </h3> 

                        </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('script')
<script>

</script>
@endsection
