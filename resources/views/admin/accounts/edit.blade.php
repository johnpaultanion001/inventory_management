
@extends('../layouts.admin')
@section('sub-title','Accounts - Edit')
@section('navbar')
    @include('../partials.admin.navbar')
@endsection
@section('sidebar')
    @include('../partials.admin.sidebar')
@endsection


@section('content')


<div class="card mt--6">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0" id="titletable">Accounts - Edit</h3>
            </div>

        </div>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.accounts.update", [$account->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">Name :</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $account->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif

            </div>
            <div class="form-group">
                <label class="required" for="email">Email :</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $account->email) }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif

            </div>
            <div class="form-group">
                <label class="required" for="password">Password :</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif

            </div>
            <div class="form-group">
                <label class="required" for="roles">Roles</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-sm select-all" style="border-radius: 0">Select All</span>
                    <span class="btn btn-info btn-sm deselect-all" style="border-radius: 0">Deselect All</span>
                </div>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $account->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </div>
                @endif

            </div>
            <br>
            <div class="form-group text-right">
                <a href="{{ route("admin.accounts.index") }}" class="btn-secondary btn">Back</a>
                <button class="btn btn-dark " type="submit"> Submit</button>
            </div>
        </form>
    </div>
</div>

     <!-- Footer -->
     @section('footer')
        @include('../partials.admin.footer')
    @endsection
@endsection
@section('script')
<script type="text/javascript">
    $(function () {
        $('.select-all').click(function () {
            let $select2 = $(this).parent().siblings('.select2')
            $select2.find('option').prop('selected', 'selected')
            $select2.trigger('change')
        })
        $('.deselect-all').click(function () {
            let $select2 = $(this).parent().siblings('.select2')
            $select2.find('option').prop('selected', '')
            $select2.trigger('change')
        })

        $('.select2').select2()

        $('.treeview').each(function () {
        var shouldExpand = false
        $(this).find('li').each(function () {
        if ($(this).hasClass('active')) {
        shouldExpand = true
        }
        })
        if (shouldExpand) {
        $(this).addClass('active')
        }
        })
    });
</script>
@endsection
