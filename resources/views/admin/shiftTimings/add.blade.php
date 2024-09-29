@component('admin.component')
@slot('title') Add Shift Timings @endslot

@slot('subTitle') Add Shift timings detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.shiftTimings.insert') }}" name="moduleData" method="POST">
    @csrf
    <div class="form-group col-6">
        <label>Type</label>
        <select class="form-control h-11" name="type">
            <option value="Full Time">Full Time</option>
            <option value="Part Time">Part Time</option>
        </select>
    </div>
    <div class="form-group col-6">
        <label>Name</label>
        <input type="text" name="name" class="form-control" placeholder="Shift Name" required>
    </div>
    <div class="form-group col-6">
        <label>From</label>
        <select class="form-control h-11" name="from">
            @for ($i = 0; $i <= 24; $i++)
                <option value="{{ sprintf("%02d", $i) }}:00">{{ sprintf("%02d", $i) }}:00</option>
            @endfor
        </select>
    </div>
    <div class="form-group col-6">
        <label>To</label>
        <select class="form-control h-11" name="to">
            @for ($i = 0; $i <= 24; $i++)
                <option value="{{ sprintf("%02d", $i) }}:00">{{ sprintf("%02d", $i) }}:00</option>
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

