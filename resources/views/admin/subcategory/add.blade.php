@component('admin.component')
@slot('title') Add Sub category @endslot

@slot('subTitle')Add Sub category @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.subcategory.store') }}" method="POST">
    @csrf
    <div class="form-group col-6 err_module">
        <label>Category</label>
        <select class="form-control h-11" name="categoryId">
            <option value="" class="font-medium">select category</option>
            @foreach ($categorys as $category)
            <option value="{{ $category->id }}" >{{ $category->name }}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_module"></span>
    </div>

    <div class="form-group col-6 err_name">
        <label>Name</label>
        <input type="text" name="name[]" class="form-control" placeholder="New Sub Category">
        <div class="new_textBox">
            
        </div>
        <button class="btn btn-danger btn-sm add" type="button">Add</button>
    </div>

    <div class="mt-4 col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" >Submit</button>
        <a href="{{ route('admin.subcategory.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')
<script>
    $('.add').click(function(){
        var new_input='<input type="text" name="name[]" class="form-control" placeholder="New Sub Category" style="margin-top: 5px;">';
        $('.new_textBox').append(new_input);
    })
</script>
@endslot
@endcomponent

