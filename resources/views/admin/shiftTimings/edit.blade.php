@component('admin.component')
@slot('title') Shift Timings @endslot

@slot('subTitle') Shift timings detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.shiftTimings.update') }}" name="moduleData" method="POST">
    @csrf
    <input type="hidden" name="shiftID" value="{{$shiftTimings->id}}">
    <div class="form-group col-6">
        <label>Type</label>
        <select class="form-control h-11" name="type">
            <option value="Full Time" @selected($shiftTimings->type == "Full Time")>Full Time</option>
            <option value="Part Time" @selected($shiftTimings->type == "Part Time")>Part Time</option>
        </select>
    </div>
    <div class="form-group col-6">
        <label>Name</label>
        <input type="text" name="name" class="form-control" placeholder="Shift Name" value="{{$shiftTimings->name}}" required>
    </div>
    <div class="form-group col-6">
        <label>From</label>
        <select class="form-control h-11" name="from">
            @for ($i = 0; $i <= 24; $i++)
                <option value="{{ sprintf("%02d", $i) }}:00" @selected($shiftTimings->from == sprintf("%02d", $i).":00")>{{ sprintf("%02d", $i) }}:00</option>
            @endfor
        </select>
    </div>
    <div class="form-group col-6">
        <label>To</label>
        <select class="form-control h-11" name="to">
            @for ($i = 0; $i <= 24; $i++)
                <option value="{{ sprintf("%02d", $i) }}:00" @selected($shiftTimings->to == sprintf("%02d", $i).":00")>{{ sprintf("%02d", $i) }}:00</option>
            @endfor
        </select>
    </div>



    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.shiftTimings.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')

@endslot
@endcomponent

