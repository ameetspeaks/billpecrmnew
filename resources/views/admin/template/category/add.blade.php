@component('admin.component')
@slot('title') Add Category Template @endslot

@slot('subTitle') add category detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.template.category.store') }}" method="POST">
    @csrf
    <div class="form-group col-6 err_name">
        <label><b>Category Name</b></label>
        <input type="text" name="name" class="form-control" placeholder="Category Name">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.template.category') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')
<script>


</script>
@endslot
@endcomponent

