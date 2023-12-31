@extends('../layouts.customer')

@section('content')
<header class="py-5" style="
background: #F2994A;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #F2C94C, #F2994A);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #F2C94C, #F2994A); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

">
    <div class="container ">
        <div class="text-center">
          <img src="/assets/img/logo.jpeg" alt="" width = "10%">
          <h1 style="color:#C50901; -webkit-text-stroke-width: 2px;
  -webkit-text-stroke-color: #AE9E00; font-weight: bold;">Triple J Savers Mart</h1>
        </div>
    </div>
</header>

<section class="py-5" style="margin-top: -100px; height: 60vh;">
        <div class="row gx-8 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-10 justify-content-center">
           <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                  @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <label class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                        <label class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <label class="form-label">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                    <div class="text-center">
                    <button type="submit" class="btn btn-primary text-primary w-100 my-4 mb-2">
                        {{ __('Reset Password') }}
                    </button>
                    </div>

                </form>
              </div>
          </div>
        </div>
</section>
@endsection

@section('script')
<script>

</script>
@endsection








