@component('admin.component')
@slot('title') Add Gallery Image @endslot
@slot('subTitle') @endslot
@slot('content')
@if($errors->any())
{{$errors}}
@endif
 
<form class="row col-12  p-0 forms-sample w-full" enctype="multipart/form-data" action="{{route('admin.gallery.store')}}" method="POST">
    <div class="form-group col-12 col-md-6">
        <label>Category</label>
        @csrf
        <input type="hidden" name="user_id" value="">
        <select class="form-control h-11" id="category" name="category" >
             <option disabled selected>Select Category</option> 
             @foreach ($categorys as $ind=>$category)
                <option value="{{$category->id}}" data-index="{{$ind}}">{{$category->name}}</option> 
             @endforeach
        </select>
     
    </div>
    <div class="form-group  col-12 col-md-6">
        <label>Product</label>
        @csrf 
        <select class="form-control h-11" id="product_id" name="product_id" >
             <option disabled selected>Select Product</option> 
        </select>
    
    </div>

    <div class="form-group  col-12 col-md-6">
        <label>Select Multiple Images</label>
        <input type="file"   class="form-control" multiple name="image[]" id="image" > 
    </div>
  

    <div class="text-left col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700">Add Images</button>
    </div>
</form>

 
 
@endslot
@slot('script')
<script>
$(function(){
    $('form').on('change','#category',function(){
        
         var cate_index=$("option:selected",this).attr("data-index");
         
         var cateData=@json($categorys);
         var subCate=cateData[cate_index];
         var data='';
         data+=`<option value="" disabled selected>Select Product List</option>`;
         subCate.products.forEach(element => {
            data+=`<option value="${element.id}" >${element.product_name}</option>`;
         });

         $("#product_id").empty().append(data);
    })
    
})
    
</script>
@endslot
@endcomponent

