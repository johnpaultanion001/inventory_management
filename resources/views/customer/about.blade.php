@extends('../layouts.customer')
@section('navbar')
    @include('../partials.customer.navbar')
@endsection

@section('content')
<header class="py-2 banner">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center">
            <h4 class="">ABOUT US {{$test}}</h4>
        </div>
        <div class="card">
            <div class="card-body text-center">
            <p>
            The XNDX Couture is an online tailor shop for women's custom clothing. We pride ourselves on delivering good quality and stylish clothing to see our clients breathe life into our pieces.
We offer personalised fashion solutions to ensure that every woman get only the best outfit.
<br>
<br>
<br>

If you want to customize clothes you can contact us in our social media accounts for other concerns.
            </p>
            </div>
         
        </div>
    </div>
</header>

<section class="py-5" style="min-height: 70vh;">
    <div class="row">
      
    </div>
    
</section>

@endsection

@section('script')
<script>

</script>
@endsection






