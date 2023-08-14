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
        <form class="myform" method="POST" action="{{ route('verification.resend') }}">
              @csrf
              <div class="card z-index-0 fadeIn3 fadeInBottom">
                <div class="card-body">
                            <div class="card-header text-center">
                                <h2>Verify your email address</h2>
                                    @if (session('resent'))
                                        <p class="text-success">
                                            {{ __('A fresh verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                <p class="card-title title-up">
                                    We've sent an email to <b>{{auth()->user()->email}}</b> to verify your email address and activate your account. The link in the email will expire in 60 minutes.
                                    <button type="submit" class="btn-primary">Click here</button> if you did not receive an email
                                </p> 

                            </div>
                    </div>
              </div>
            
            </form>
        </div>
</section>
@endsection

@section('script')
<script>

</script>
@endsection
