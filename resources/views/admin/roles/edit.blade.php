
@extends('../layouts.admin')
@section('sub-title','Roles - Edit')
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
            <h3 class="mb-0" id="titletable">Role - Edit</h3>
        </div>

        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("admin.roles.update", [$role->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">Title</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $role->title) }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif

            </div>
            <div class="form-group">
                <label class="required" for="permissions">Permissions</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-sm select-all" style="border-radius: 0">Select All</span>
                    <span class="btn btn-info btn-sm deselect-all" style="border-radius: 0">Deselect All</span>
                </div>
                <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple required>
                    @foreach($permissions as $id => $permissions)
                        <option value="{{ $id }}" {{ (in_array($id, old('permissions', [])) || $role->permissions->contains($id)) ? 'selected' : '' }}>{{ $permissions }}</option>
                    @endforeach
                </select>
                @if($errors->has('permissions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('permissions') }}
                    </div>
                @endif

            </div>
            <br>
            <div class="form-group text-right">
                <a href="{{ route("admin.roles.index") }}" class="btn-secondary btn">Back</a>
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
