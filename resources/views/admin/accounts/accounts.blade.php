@extends('../layouts.admin')
@section('sub-title','Accounts')
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
                                <h4 class="mb-0 text-uppercase" id="titletable">Manage Accounts</h4>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route("admin.accounts.create") }}"  class="btn btn-sm btn-dark">NEW ACCOUNT</a>
                            </div>

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-table display" width="100%">
                            <thead class="text-uppercase thead-white">
                                <tr class="text-uppercase">
                                  <th  scope="col">ACTIONS</th>
                                  <th  scope="col">NAME</th>
                                  <th  scope="col">EMAIL</th>
                                  <th  scope="col">ROLES</th>
                                  <th scope="col">CREATED AT</th>
                                </tr>
                            </thead>
                            <tbody class="font-weight-bold">
                                @foreach($accounts as $account)
                                <tr>
                                  <td>
                                    <a href="{{ route('admin.accounts.edit', $account->id) }}" class="btn btn-sm btn-info">EDIT ACCOUNT</a>
                                  </td>

                                  <td>
                                      {{  $account->name ?? '' }}
                                  </td>
                                  <td>
                                      {{  $account->email ?? '' }}
                                  </td>
                                   <td>
                                        @foreach($account->roles as $key => $item)
                                            <span class="badge badge-dark bg-success">{{ $item->title }}</span>
                                        @endforeach
                                    </td>

                                  <td>
                                      {{ $account->created_at->format('M j , Y h:i A') }}
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


