@extends('../layouts.admin')
@section('sub-title','Categories')
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
                            <div class="col-md-10">
                                <h4 class="mb-0 text-uppercase" id="titletable">Manage Style</h4>
                                <br>
                                <button class="btn-dark btn-sm button_style" type="NAVBAR">NAVBAR</button>
                                <button class="btn-dark btn-sm button_style" type="BANNER">BANNER</button>
                                <button class="btn-dark btn-sm button_style" type="FOOTER">FOOTER</button>
                                <button class="btn-dark btn-sm button_style" type="SLIDER">SLIDER</button>
                                
                            </div>
                            <form method="post" id="myForm" class="contact-form">
                                @csrf
                                <div class="card">
                                       
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 styles navbar_section">
                                                    <div class="form-group">
                                                        <h6>Navbar Color:</h6>
                                                        <input id="navbar_color" name="navbar_color" type="color" class="form-control" value="{{$styles->navbar_color}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Navbar Text Color:</h6>
                                                        <input id="navbar_text_color" name="navbar_text_color" type="color" class="form-control" value="{{$styles->navbar_text_color}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Navbar Logo:</h6>
                                                        <input id="navbar_logo" name="navbar_logo"  accept="image/*" type="file" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Current Image:</h6>
                                                        <img src="/assets/img/{{$styles->navbar_logo}}" width="70" height="70" class="d-inline-block align-top" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 styles banner_section">
                                                    <div class="form-group">
                                                        <h6>Banner Color:</h6>
                                                        <input id="banner_color" name="banner_color" type="color" class="form-control" value="{{$styles->banner_color}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Banner Text Color:</h6>
                                                        <input id="banner_text_color" name="banner_text_color" type="color" class="form-control" value="{{$styles->banner_text_color}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Bannere Image:</h6>
                                                        <input id="banner_logo" name="banner_logo"  accept="image/*" type="file" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Current Image:</h6>
                                                        <img src="/assets/img/{{$styles->banner_logo}}" width="70" height="70" class="d-inline-block align-top" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 styles footer_section">
                                                    <div class="form-group">
                                                        <h6>Footer Color:</h6>
                                                        <input id="footer_color" name="footer_color" type="color" class="form-control" value="{{$styles->footer_color}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Footer Text Color:</h6>
                                                        <input id="footer_text_color" name="footer_text_color" type="color" class="form-control" value="{{$styles->footer_text_color}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Footer Image:</h6>
                                                        <input id="footer_logo" name="footer_logo"  accept="image/*" type="file" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Current Image:</h6>
                                                        <img src="/assets/img/{{$styles->footer_logo}}" width="70" height="70" class="d-inline-block align-top" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 styles slider_section">
                                                  
                                                    <div class="form-group">
                                                        <h6>Slider Image 1:</h6>
                                                        <input id="slider_image1" name="slider_image1"  accept="image/*" type="file" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Current Image:</h6>
                                                        <img src="/assets/img/{{$styles->slider_image1}}" width="600" height="150" class="d-inline-block align-top" alt="">
                                                    </div>

                                                    <div class="form-group">
                                                        <h6>Slider Image 2:</h6>
                                                        <input id="slider_image2" name="slider_image2"  accept="image/*" type="file" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Current Image:</h6>
                                                        <img src="/assets/img/{{$styles->slider_image2}}" width="600" height="150" class="d-inline-block align-top" alt="">
                                                    </div>

                                                    <div class="form-group">
                                                        <h6>Slider Image 3:</h6>
                                                        <input id="slider_image3" name="slider_image3"  accept="image/*" type="file" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Current Image:</h6>
                                                        <img src="/assets/img/{{$styles->slider_image3}}" width="600" height="150" class="d-inline-block align-top" alt="">
                                                    </div>

                                                    <div class="form-group">
                                                        <h6>Slider Image 4:</h6>
                                                        <input id="slider_image4" name="slider_image4"  accept="image/*" type="file" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Current Image:</h6>
                                                        <img src="/assets/img/{{$styles->slider_image4}}" width="600" height="150" class="d-inline-block align-top" alt="">
                                                    </div>

                                                    <div class="form-group">
                                                        <h6>Slider Image 5:</h6>
                                                        <input id="slider_image5" name="slider_image5"  accept="image/*" type="file" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>Current Image:</h6>
                                                        <img src="/assets/img/{{$styles->slider_image5}}" width="600" height="150" class="d-inline-block align-top" alt="">
                                                    </div>
                                                </div>

                                                <div class="col-md-10 mx-auto text-center">
                                                     <input type="submit" name="action_button" id="action_button" class="btn btn-lg  btn-dark" value="Submit" />
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </form>
                        </div>
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
    $('.styles').hide();
    $('.navbar_section').show();
});

$(document).on('click', '.button_style', function(){
    var type = $(this).attr('type');
    if(type == 'NAVBAR'){
        $('.styles').hide();
        $('.navbar_section').show();
    }
    if(type == 'BANNER'){
        $('.styles').hide();
        $('.banner_section').show();
    }
    if(type == 'FOOTER'){
        $('.styles').hide();
        $('.footer_section').show();
    }
    if(type == 'SLIDER')
    {
        $('.styles').hide();
        $('.slider_section').show();
    }
});

$('#myForm').on('submit', function(event){
    event.preventDefault();
    $('.form-control').removeClass('is-invalid')
    var action_url = "{{ route('admin.styles.update') }}";
    var type = "POST";

    $.ajax({
        url: action_url,
        method:type,
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData: false,

        dataType:"json",
        beforeSend:function(){
            $("#action_button").attr("disabled", true);
            $("#action_button").attr("value", "Loading..");
        },
        success:function(data){
            $("#action_button").attr("disabled", false);
            $("#action_button").attr("value", "Submit");

            if(data.errors){
                $.each(data.errors, function(key,value){
                    if(key == $('#'+key).attr('id')){
                        $('#'+key).addClass('is-invalid')
                        $('#error-'+key).text(value)
                    }
              
                })
            }
            if(data.success){
                $('.form-control').removeClass('is-invalid')
                $('#myForm')[0].reset();
                $.confirm({
                title: 'Confirmation',
                content: data.success,
                type: 'green',
                buttons: {
                        confirm: {
                            text: 'confirm',
                            btnClass: 'btn-blue',
                            keys: ['enter', 'shift'],
                            action: function(){
                                location.reload();
                            }
                        },
                        
                    }
                });
            }
            
        }
    });
});




</script>
@endsection




