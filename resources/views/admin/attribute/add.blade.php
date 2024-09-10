@component('admin.component')
@slot('title') Attributes @endslot
@slot('subTitle') Add Attributes @endslot
@slot('content')
 
<form class="forms-sample w-full row" action="{{ route('admin.attribute.store') }}" method="POST">
    @csrf
    <div class="form-group col-12 col-md-6  err_name">
        <label>Name</label>
        <input type="text" name="name" class="form-control name" placeholder="New Attribute Name">
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
