@component('admin.component')
@slot('title') Edit @endslot

@slot('subTitle') Edit detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route("admin.perKmRateByZone.update") }}" name="moduleData" method="POST">
    @csrf
    <input type="hidden" name="zoneID" value="{{ $zone->id }}">
    <div class="form-group col-6 err_name">
        <label>Zone name</label>
        <input type="text" class="form-control" value="{{ $zone->name }}" readonly>
    </div>

    <div class="form-group col-6 err_name">
        <label>Per KM Rate</label>
        <input type="number" name="per_km_rate" class="form-control" step="any" value="{{ @$zone->per_km_rate }}">
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.perKmRateByZone.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')

@endslot
@endcomponent

