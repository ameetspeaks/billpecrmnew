@component('admin.component')
@slot('title') Sub units @endslot
@slot('subTitle') Edit Sub units @endslot
@slot('content')
 
<form class="forms-sample w-full row" action="{{ route('admin.subunit.update') }}" method="POST">
    @csrf
    <input type="hidden" name="subunit_id" value="{{$subunit->id}}">

    <div class="form-group col-6 err_module">
        <label>Units</label>
        <select class="form-control h-11 " name="unit_id">
            <option value="" class="font-medium">select units</option>
            @foreach ($units as $unit)
            <option value="{{ $unit->id }}" {{$subunit->unit_id == $unit->id ? 'selected' : ''}}>{{ $unit->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_module"></span>
    </div>

    <div class="form-group col-md-6  err_name">
        <label>Name</label>
        <input type="text" name="name" class="form-control name" placeholder="New Sub Unit Name" value="{{$subunit->name}}">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>
  

    <div class="mt-4 col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" >Submit</button>
        <a href="{{ route('admin.subunit.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>


@endslot
@slot('script')

@endslot
@endcomponent
