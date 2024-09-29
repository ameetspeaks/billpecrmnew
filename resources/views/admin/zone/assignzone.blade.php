@component('admin.component')
@slot('title') Assign Zone @endslot

@slot('subTitle') add Assign detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.zone.assignstoreupdate') }}" name="moduleData" method="POST">
    @csrf
    <div class="form-group col-6 err_name">
        <label>Zone</label>
        <select class="form-control select selectZone" name="zone_id" id="zone_id" required>
            <option value="">Select Zone</option>
            @foreach($zones as $zone)
            <option value="{{$zone->id}}">{{$zone->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-6 err_name">
        <label>Store</label>
        <select class="form-control selectStore" name="store_id[]" id="store_id" multiple required>
            <option value="">Select Store</option>
            @foreach($stores as $store)
            <option value="{{$store->id}}">{{$store->shop_name}}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        {{-- <a href="{{ route('admin.zone.assignZone') }}"><div class="btn btn-light">Cancel</div></a> --}}
    </div>
</form>
@endslot
@slot('script')

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\Setting::where('type','map_api_key')->first()->value}}&callback=initialize&libraries=drawing,places&v=3.49"></script>
<script>
    $('.select').select2().trigger('change');
    $('.selectStore').select2({ placeholder: "Select Store" }).trigger('change');
</script>
@endslot
@endcomponent

