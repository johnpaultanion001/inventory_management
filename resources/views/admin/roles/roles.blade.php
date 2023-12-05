@extends('../layouts.admin')
@section('sub-title','Roles')
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
                                <h4 class="mb-0 text-uppercase" id="titletable">Manage Roles</h4>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route("admin.roles.create") }}"  class="btn btn-sm btn-dark">NEW ROLE</a>
                            </div>

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" width="100%">
                            <thead class="text-uppercase thead-white">
                                <tr class="text-uppercase">
                                    <th scope="col">Action</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Permissions</th>
                                </tr>
                            </thead>
                            <tbody class="font-weight-bold">
                                @foreach($roles as $key => $role)
                                    <tr data-entry-id="{{ $role->id ?? '' }}">
                                        <td>
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-info">EDIT ROLE</a>
                                        </td>
                                        <td>
                                            {{  $role->id ?? '' }}
                                        </td>
                                        <td>
                                            {{  $role->title ?? '' }}
                                        </td>
                                        <td>
                                            @foreach($role->permissions as $key => $item)
                                                <span class="badge badge-dark bg-primary">{{ $item->title }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    $.extend(true, $.fn.dataTable.defaults, {
      sale: [[ 1, 'desc' ]],
      pageLength: 25,
      'columnDefs': [{ 'orderable': false, 'targets': 0 }],
    });
    $('.datatable-table:not(.ajaxTable)').DataTable({ buttons: dtButtons })
      $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
          $($.fn.dataTable.tables(true)).DataTable()
              .columns.adjust();
      });
  });
</script>
@endsection


