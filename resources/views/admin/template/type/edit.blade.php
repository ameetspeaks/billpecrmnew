@component('admin.component')
@slot('title') Edit Template Type @endslot

@slot('subTitle') edit template type detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.template.type.update') }}" method="POST">
    @csrf
    <input type="hidden" name="temTypeId" value="{{$type->id}}">
    <div class="form-group col-6 err_name">
        <label><b>Template Type Name</b></label>
        <input type="text" name="name" class="form-control" value="{{$type->name}}" placeholder="Template Type Name">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.template.type') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')
<script>


</script>
@endslot
@endcomponent

