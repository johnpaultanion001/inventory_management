@extends('../layouts.admin')
@section('sub-title','Sales Reports')
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
                            <div class="col-md-12">
                                <h4 class="mb-0 text-uppercase" id="titletable">Salesforcast</h4>
                                <p class="mb-0 text-uppercase">SALESFORCAST SETUP</p>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="category_dd" id="category_dd" class="select2" style="width: 100%;">
                                        <option value="">FILTER CATEGORY</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->name}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="month_dd" id="month_dd" class="select2" style="width: 100%;">
                                        <option value="">FILTER MONTH</option>
                                        <option value="JANUARY">JANUARY</option>
                                        <option value="FEBRUARY">FEBRUARY</option>
                                        <option value="MARCH">MARCH</option>
                                        <option value="APRIL">APRIL</option>
                                        <option value="MAY">MAY</option>
                                        <option value="JUNE">JUNE</option>
                                        <option value="JULY">JULY</option>
                                        <option value="AUGUST">AUGUST</option>
                                        <option value="SEPTEMBER">SEPTEMBER</option>
                                        <option value="OCTOBER">OCTOBER</option>
                                        <option value="NOVEMBER">NOVEMBER</option>
                                        <option value="DECEMBER">DECEMBER</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">CATEGORY</th>
                                    <th scope="col">MONTH</th>
                                    <th scope="col">2024</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase font-weight-bold">
                                @foreach($forcasts as $forcast)

                                        <tr>
                                            <td>
                                                {{$forcast->category ?? ''}}
                                            </td>
                                            <td>
                                                {{ date('F', mktime(0, 0, 0, $forcast->month, 10))}}
                                            </td>
                                            <td >
                                                <a class="text-info edit" style="cursor: pointer;" name="edit" edit="{{  $forcast->id ?? '' }}">{{$forcast->total ?? ''}}</a>
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>

    <form method="post" id="myForm" class="contact-form">
        @csrf
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times text-primary"></i>
                    </button>

                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col">Category</th>
                                    <th scope="col">Month</th>
                                    <th scope="col">2021</th>
                                    <th scope="col">2022</th>
                                    <th scope="col">2023</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td id="category"></td>
                                    <td class="text-uppercase" id="month"></td>
                                    <td id="2021"></td>
                                    <td id="2022"></td>
                                    <td id="2023"></td>
                                </tr>
                            </tbody>
                            </table>

                        <div class="form-group">

                            <label class="form-label">2024: <span class="text-danger">*</span></label>
                            <input type="text" name="total" id="total" class="form-control disabled" >
                            <span class="invalid-feedback" role="alert">
                                <strong id="error-total"></strong>
                            </span>


                        </div>

                        <input type="hidden" name="action" id="action" value="Add" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />

                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="action_button" id="action_button" class="btn  btn-primary" value="Save" />
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @section('footer')
        @include('../partials.admin.footer')
    @endsection
@endsection


@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="{{ asset('js/chart.js') }}"></script>
<script>


$(function () {

    var title = 'title';
    var header =  'title';
    var table =  $('.datatable-table').DataTable({
        bDestroy: true,
        responsive: true,
        pageLength: 12,
        scrollCollapse: true,
        bLengthChange: false,
        buttons: [
            {
                extend: 'excel',
                className: 'btn btn-dark m-2',
                footer: true,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                footer: true,
                className: 'btn btn-dark m-2',

            }
        ],
    });

    $('#category_dd').on('change', function () {
        table.columns(0).search( this.value ).draw();
    });

    $('#month_dd').on('change', function () {
        table.columns(1).search( this.value ).draw();
    });

    $('#myForm').on('submit', function(event){
    event.preventDefault();
    $('.form-control').removeClass('is-invalid')
    var action_url = "{{ route('admin.forcast.store') }}";
    var type = "POST";

    if($('#action').val() == 'Edit'){
        var id = $('#hidden_id').val();
        action_url = "/admin/forcast/" + id;
        type = "PUT";
    }

    $.ajax({
        url: action_url,
        method:type,
        data:$(this).serialize(),
        dataType:"json",
        beforeSend:function(){
            $("#action_button").attr("disabled", true);
        },
        success:function(data){
           $("#action_button").attr("disabled", false);

            if(data.errors){
                $.each(data.errors, function(key,value){
                    if(key == $('#'+key).attr('id')){
                        $('#'+key).addClass('is-invalid')
                        $('#error-'+key).text(value)
                    }
                    if(key == 'image'){
                        $('.image').addClass('is-invalid')
                        $('#error-image').text(value)
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
                $('#formModal').modal('hide');
            }

        }
    });
});

$(document).on('click', '.edit', function(){
    $('#formModal').modal('show');
    $('.modal-title').text('EDIT');
    $('#myForm')[0].reset();
    $('.form-control').removeClass('is-invalid');

    var id = $(this).attr('edit');
    var monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];

    $.ajax({
        url :"/admin/forcast/"+id+"/edit",
        dataType:"json",
        beforeSend:function(){
            $("#action_button").attr("disabled", true);
        },
        success:function(data){
            $("#action_button").attr("disabled", false);

            $.each(data.result, function(key,value){
                if(key == $('#'+key).attr('id')){
                    $('#'+key).val(value)
                    $('#'+key).text(value)
                }
                if(key == 'month'){
                    $('#month').text(monthNames[value - 1])
                }
            })
            $('#2021').text(data.c2021)
            $('#2022').text(data.c2022)
            $('#2023').text(data.c2023)

            $('#hidden_id').val(id);
            $('#action_button').val('Update');
            $('#action').val('Edit');
        }
    })
});



});
</script>
@endsection




