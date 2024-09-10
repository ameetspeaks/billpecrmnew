@component('admin.component')
@slot('title') Add Role @endslot

@slot('subTitle') add Role detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.role.store') }}" name="moduleData" method="POST">
    @csrf
    <div class="form-group col-6 err_name">
        <label>Role Name</label>
        <input type="text" name="name" class="form-control" placeholder="Role Name">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-6">
        <label>Permissions</label><br>

        @foreach($permissions['allPermissionsLists'] as $permission)
        <input type="checkbox" name="permissions[]" value="{{$permission->id}}">
        <lable>{{$permission->name}}</lable>
        @endforeach
        
    </div>



    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.role.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')

@endslot
@endcomponent

