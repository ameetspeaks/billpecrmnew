@component('admin.component')
@slot('title') Add Offer Template @endslot

@slot('subTitle') add offer template detail @endslot
@slot('content')
<form class="row forms-sample w-full" action="{{ route('admin.template.offer.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group col-6 err_name">
        <label><b>Template Category</b></label>
        <select class="form-control h-11" name="category_id" required>
            <option value="">Select Category</option>
            @foreach($categories as $categorie)
            <option value="{{$categorie->id}}">{{$categorie->name}}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-6 errmsg_product">
        <label><b>Product</b></label>
        <select class="form-control h-11" name="product_id" required>
            <option value="">Select Product</option>
            @foreach($products as $product)
            <option value="{{$product->id}}">{{$product->product_name}}</option>
            @endforeach
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_product"></span>
    </div>

    <div class="form-group col-6 err_name">
        <label><b>Offer</b></label>
        <input type="text" name="name" class="form-control" placeholder="Offer Name" required>
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>
    
    <div class="form-group col-6">
        <label><b>Image</b></label>
        <input type="file" name="productImage[]"  class="form-control" id="changeImg" multiple required>
        <span class="text-xs text-red-500 mt-2 errmsg_image"></span>
        <!-- <div class="col-3  border-2 border-dark px-0 p-2 rounded-lg mt-3">
            <img id="ItemImg2" src="{{ asset('public/admin/images/default_image.png') }}" alt="your image" class="rounded-lg" style="width: 100%" />
        </div> -->
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.template.offer') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')
<script>
</script>
@endslot
@endcomponent

