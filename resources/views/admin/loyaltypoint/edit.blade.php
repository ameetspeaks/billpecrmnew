@component('admin.component')
@slot('title') Loyalty Point @endslot
@slot('subTitle') Loyalty Point edit @endslot
@slot('content')

<form action="{{route('admin.loyaltypoint.update')}}" class="row forms-sample w-full" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="loyalty_id" value="{{$point->id}}">
    <div class="form-group col-md-6 col-12">
        <label for="packageSelect">Select Modules:</label>
        <select class="form-control"  name="modules_id" required>
            <option value="">Select Modules</option>
            @foreach($modules as $module)
            <option value="{{$module->id}}" {{$point->modules_id == $module->id ? 'selected' : ''}}>{{$module->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6 col-12 err_1_INR_point_amount">
        <label><b>1 INR Point Amount</b></label>
        <input type="text" name="one_INR_point_amount"  class="form-control" placeholder="1 INR Point Amount" value="{{$point->one_INR_point_amount}}"  required>
    </div>

    <div class="form-group col-md-6 col-12 err_min_point_per_order">
        <label><b>Maximum Loyalty Point Per Order</b></label>
        <input type="text" name="min_point_per_order"  class="form-control" placeholder="Minimun Loyalty Point Per Order" value="{{$point->min_point_per_order}}" required>
    </div>

    <div class="form-group col-md-6 col-12 err_max_point_to_convert">
        <label><b>Minimum Point To Convert</b></label>
        <input type="text" name="max_point_to_convert" value="{{$point->max_point_to_convert}}"  class="form-control" placeholder="Maximum Point To Convert" required>
    </div>

    <div class="form-group col-md-6 col-12 mt-3">
        <button type="submit" class="btn bg-primary text-white">Submit</button>
        <a href="{{ route('admin.loyaltypoint.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>

</form>
@endslot
@slot('script')

@endslot
@endcomponent
