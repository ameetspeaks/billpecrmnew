@component('admin.component')
@slot('title') Add module @endslot

@slot('subTitle') add module detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.module.store') }}" method="POST">
    @csrf
    <div class="form-group col-6 err_module">
        <label>Store Type</label>
        <select class="form-control h-11" name="store_type_id" required>
            <option value="" class="font-medium">select store type</option>
            @foreach ($StoreTypes as $StoreType)
            <option value="{{ $StoreType->id }}" >{{ $StoreType->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_module"></span>
    </div>

    <div class="form-group col-6 err_name">
        <label>System Module Name</label>
        <input type="text" name="name" class="form-control" placeholder="System Module Name">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>


    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.module.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')
<script>

   
</script>
@endslot
@endcomponent

