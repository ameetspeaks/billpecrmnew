@component('admin.component')
@slot('title') units @endslot
@slot('subTitle') Add units @endslot
@slot('content')
 
<form class="forms-sample w-full row" action="{{ route('admin.unit.store') }}" method="POST">
    @csrf

    <div class="form-group col-6 err_module">
        <label>Modules</label>
        <select class="form-control h-11" name="module_id">
            <option value="" class="font-medium">select module</option>
            @foreach ($modules as $module)
            <option value="{{ $module->id }}" >{{ $module->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_module"></span>
    </div>

    <div class="form-group col-6 err_module">
        <label>Attribute</label>
        <select class="form-control h-11" name="attribute_id">
            <option value="" class="font-medium">select attribute</option>
            @foreach ($attributes as $attribute)
            <option value="{{ $attribute->id }}" >{{ $attribute->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_module"></span>
    </div>

    <div class="form-group col-md-6  err_name">
        <label>Name</label>
        <input type="text" name="name" class="form-control name" placeholder="New Unit Name">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>
  

    <div class="mt-4 col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" >Submit</button>
        <a href="{{ route('admin.unit.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>


@endslot
@slot('script')

@endslot
@endcomponent
