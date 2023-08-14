
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
        <div class="justify-content-center col-lg-7 mx-auto">
           <div class="card z-index-0 fadeIn3 fadeInBottom">
              
              <div class="card-body">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                  @csrf
                      <div class="text-center">
                        <br>
                        <br>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-label">Name <span class="text-danger">*</span></label>
                              <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name') }}" required autocomplete="name" autofocus>
                              @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                        </div>
                         <div class="col-lg-6">
                              <div class="form-group">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                         </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                              <input type="number" id="contact_number" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number') }}"   required autocomplete="contact_number">
                              @error('contact_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label text-uppercase" >Upload( Valid id) <span class="text-danger">*</span></label>
                                <input type="file" id="id_image" name="id_image" accept="image/*" class=" form-control font-weight-bold @error('id_image') is-invalid @enderror">
                                @error('id_image')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                          </div>
                          @php
                            $cities = App\Models\ShippingFee::orderBy('city','asc')->get();
                          @endphp
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-label">Your City (Based on your id)<span class="text-danger">*</span></label>
                              <select name="city" id="city" class="form-control select2">
                                  @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->city}}</option>
                                  @endforeach
                              </select>
                              @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-label">Complete Address (Based on your id)<span class="text-danger">*</span></label>
                              <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}"   required autocomplete="address">
                              @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                         
                          <div class="col-lg-6">
                              <div class="form-group">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"  id="password"  name="password" required autocomplete="new-password" >
                            
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                              </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password-confirm" name="password_confirmation"  required autocomplete="new-password">
                            </div>
                          </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn btn-dark w-100 my-4 mb-2">REGISTER</button>
                      </div>
                      
                      <p class="mt-4 text-sm text-center">
                        Already a member?
                        <a href="/login" class="text-dark font-weight-bold">LOGIN</a>
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






