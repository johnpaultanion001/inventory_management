@extends('../layouts.customer')
@section('navbar')
    @include('../partials.customer.navbar')
@endsection

@section('content')


<header class="py-5 banner">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center">
           <!-- <img src="/" alt="" width = "20%"> -->
           <h2>LOGO</h2>
        </div>
    </div>
</header>

<section class="py-5">
        <div class="col-xl-4 mx-auto">
           <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                      <div class="text-center">
                      </div>
                        <label class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                        <label class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      <div class="text-center">
                        <button type="submit" class="btn btn-dark w-100 my-4 mb-2">LOGIN</button>

                      </div>
                      <p class="mt-4 text-sm text-center">
                        <a href="/password/reset/">FORGOT PASSWORD?</a>
                      </p>

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
