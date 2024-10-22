@component('admin.component')
@slot('title') Add Sub Zone @endslot

@slot('subTitle') add sub Zone detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.subzone.store') }}" name="moduleData" method="POST">
    @csrf
    <div class="form-group col-6 err_zone">
        <label>Zone</label>
        <select class="form-control" name="zone_id" required>
            <option value="">Select Zone</option>
            @foreach($zones as $zone)
            <option value="{{$zone->id}}">{{$zone->name}}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 err_zone"></span>
    </div>
    <div class="form-group col-6 err_name">
        <label>Sub Zone Name</label>
        <input type="text" name="name" class="form-control" placeholder="Sub Zone Name" required>
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-6 err_zone">
        <label>Store</label>
        <select class="form-control select" name="store_id[]" multiple required>
            <option value="">Select Zone</option>
            @foreach ($stores as $store)
                <option value="{{ $store->id }}">{{ $store->shop_name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 err_zone"></span>
    </div>
    
    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.subzone.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')
<script>
    $('.select').select2({ placeholder: "Select Store" }).trigger('change');
</script>
@endslot
@endcomponent

