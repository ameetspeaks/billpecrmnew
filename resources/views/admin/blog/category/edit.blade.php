@component('admin.component')
@slot('title') Edit blog @endslot

@slot('subTitle') Edit blog detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.blog.category.update') }}" method="POST">
    @csrf
    <input type="hidden" name="blogcatid" value="{{$blogCategory->id}}">
    <div class="form-group col-6 err_name">
        <label>Name</label>
        <input type="text" name="name" class="form-control" placeholder="New Category" value="{{$blogCategory->name}}">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="mt-4 col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" >Submit</button>
        <a href="{{ route('admin.blog.category') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')
<script>

</script>
@endslot
@endcomponent

