@component('admin.component')
@slot('title') Attributes @endslot
@slot('subTitle') Update Attributes @endslot
@slot('content')
 
<form class="forms-sample w-full row" action="{{ route('admin.attribute.update') }}" method="POST">
    @csrf
    <input type="hidden" name="attribute_id" value="{{$attribute->id}}">

    <div class="form-group col-12 col-md-6  err_name">
        <label>Name</label>
        <input type="text" name="name" class="form-control name" value="{{$attribute->name}}" placeholder="New Attribute Name">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>
  

    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700">Submit</button>
        <a href="{{ route('admin.attribute.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>


@endslot
@slot('script')

@endslot
@endcomponent
