<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('sub-title') | {{ trans('panel.site_title') }}</title>

    <!-- Favicon -->
    <!-- <link rel="icon" type="image/x-icon" href="/assets/img/sample_image/logo_white.png" /> -->
    <link rel="icon" href="/assets/img/logo.jpeg" type="image/icon type">

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <!-- css -->
    <!-- Icons -->
    <link href="{{ asset('/admin/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <!-- CSS Files -->
   <link href="{{ asset('/admin/css/material-dashboard.css?v=3.0.0') }}" type="text/css" rel="stylesheet" />



    <!-- datatables -->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />


    @yield('third_party_stylesheets')
    @stack('page_css')

    <style>
         .navbar-vertical.navbar-expand-xs .navbar-collapse {
      height: calc(100vh - 160px) !important;
  }
        .select2-container--default .select2-selection--single {
            border: 1px solid white;
            border-radius: 4px;
            height: auto;
        }
        .modal-backdrop
        {
            opacity:0.5 !important;
        }
        .select2 {
            border: solid 1px gray;

            border-radius: 4px;
            color: #111;
            padding: 0.625rem 0.75rem;
        }
        .receipt-body{
            overflow: auto;
            max-height: 270px;
        }
        .counter.counter-lg {
        top: 1px !important;
        font-weight: bold;
        position: absolute;
        }

        .form-control:focus{
            border: solid 1px #111 !important;
        }
        .form-control{
            border: solid 1px gray !important;
            padding: 0.625rem 0.75rem !important;
            line-height: 1.3 !important;
            -webkit-appearance: auto !important;
            appearance: auto !important;
        }
        .form-control .is-invalid{
            border: 1px solid red !important;
            padding: 0.625rem 0.75rem;
            line-height: 1.3 !important;
        }
        .bg-gradient-dark{
            background: #F2994A !important;
            background: -webkit-linear-gradient(to right, #F2C94C, #F2994A) !important; /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #F2C94C, #F2994A) !important;/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
        .text-primary  , .page-link{
            color: #C50901 !important;
            font-weight: bold !important;
        }

        .btn-dark {
            color: #fff !important;
            background-color: #F2C94C !important;
            border-color: #F2C94C !important;
        }

        .btn-primary , .bg-primary {
            color: #fff !important;
            background-color: #F2C94C !important;
            border-color: #F2C94C !important;
        }

        .btn-check:checked + .btn-outline-dark, .btn-check:active + .btn-outline-dark, .btn-outline-dark:active, .btn-outline-dark.active, .btn-outline-dark.dropdown-toggle.show {
            color: #fff;
            background-color: #F2C94C !important;
            border-color: #F2C94C !important;
        }
        .ui-autocomplete{
            z-index:1050 !important;
        }


    </style>
</head>
    <body class="g-sidenav-show " style="
background: #C50901;
">
        <!-- sidebar -->
        @yield('sidebar')

        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

                    @yield('navbar')
                    @yield('content')
                    @yield('footer')



        </main>

        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

        <form method="post" id="myBackupForm" class="contact-form">
            @csrf
            <div class="modal fade" id="formBackupModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title">Verify your password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times text-primary"></i>
                        </button>

                        </div>
                        <div class="modal-body">

                            <div class="form-group">

                                <label class="form-label">Input your current password to confirm  <span class="text-danger">*</span></label>
                                <input type="password" name="current_password" id="current_password" class="form-control disabled" >
                                <span class="invalid-feedback" role="alert">
                                    <strong id="error-current_password"></strong>
                                </span>


                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn  btn-primary" value="Submit" />
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- JQuery Scripts -->
        <script src="{{ asset('/admin/vendor/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('/admin/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('/admin/vendor/js-cookie/js.cookie.js') }}"></script>
        <script src="{{ asset('/admin/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('/admin/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>

        <!-- Scripts -->
        <script src="{{ asset('/admin/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('/admin//js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/admin/js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="{{ asset('/admin/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="{{ asset('/admin/js/material-dashboard.min.js?v=3.0.0') }}"></script>

        <script>
            var win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
                }
        </script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

        <!-- datatables -->
        <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>



        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

        <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://unpkg.com/@coreui/coreui@2.1.16/dist/js/coreui.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>



        <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('assets/vendor/demo/chart-pie-demo.js') }}"></script>




        <script>
  $(function() {
        let copyButtonTrans = 'COPY'
        let csvButtonTrans = 'CSV'
        let excelButtonTrans = 'EXCEL'
        let pdfButtonTrans = 'PDF'
        let printButtonTrans = 'PRINT / PDF'
        let colvisButtonTrans = 'VIEW'

        let languages = {
        'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json'
        };

        $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn btn-sm mt-1 btn-default ' })
        $.extend(true, $.fn.dataTable.defaults, {
        language: {
            url: languages['{{ app()->getLocale() }}']
        },

        order: [],
        scrollX: true,
        pageLength: 10,
        dom: 'lBfrtip<"actions">',
        buttons: [

            {
            extend: 'excel',
            className: 'btn-dark btn-sm m-2',
            text: excelButtonTrans,
            exportOptions: {
                columns: ':visible'
            },
            footer: true
            },
            {
            extend: 'print',
            className: 'btn-dark btn-sm m-2',
            text: printButtonTrans,
            orientation : 'landscape',
            exportOptions: {
                columns: ':visible'
            },
            customize: function ( win ) {
                    $(win.document.body).find('h1')
                        .css( 'font-size', '25px' )
                        .css('margin-top', '30px')
                        .css('margin-bottom', '30px');
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .addClass( 'text-center mt-2' )
                        .prepend(
                            '<img src="/assets/img/logo.jpeg"/>'
                        );
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', '8px' );


            },
            footer: true
            },

            {
            extend: 'colvis',
            className: 'btn-dark btn-sm m-2',
            text: colvisButtonTrans,
            exportOptions: {
                columns: ':visible'
            },
            footer: true

            }
        ]
        });

        $.fn.dataTable.ext.classes.sPageButton = '';
        });

    </script>

        <script>

        var itemInStock = false;

        $(document).ready(function () {
        $('.dropdown_list').hide();
        });

        $("#notification_bell").click(function(){
            changeStatus();
        });

        function changeStatus(){
            if( itemInStock === false){
            $('.dropdown_list').show();
            itemInStock = true;

            } else{
            $('.dropdown_list').hide();
            itemInStock = false;
            }
        }


        $(document).on('click', '#btn_backup', function(){
           $('#formBackupModal').modal('show');
        });

        $('#myBackupForm').on('submit', function(event){
        event.preventDefault();
        $('.form-control').removeClass('is-invalid')
        var action_url = "{{ route('admin.orders.backup') }}";
        var type = "POST";


            $.ajax({
                url: action_url,
                method:type,
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                },
                success:function(data){
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
                        $('#myBackupForm')[0].reset();
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
                                        window.location.href = '/admin/download_backup';
                                    }
                                },

                            }
                        });
                        $('#formBackupModal').modal('hide');
                    }

                }
            });
        });
    </script>
        @yield('script')
    </body>
</html>
