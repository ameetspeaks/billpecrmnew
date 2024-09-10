@component('admin.component')
@slot('title') List Gallery Images @endslot
@slot('subTitle') @endslot
@slot('content')
@if($errors->any())
{{$errors}}
@endif
<style>

 
 

 
    .copyIcon{
    position: absolute;
    right: 4px;
    top: 4px;
    background: red;
    padding: 9px;
    border-radius: 5px;
    cursor: pointer;
    display: none;
    }

    .pics:hover .copyIcon, .pics:focus .copyIcon{
        display: block !important;
    }

    .copyIcon:hover{
        background-color: rgb(224, 5, 5);
    }

  

    .videoss{
        display: flex;
flex-wrap: wrap;
padding: 0 4px;
    }

    .col-video{
        flex: 25%;
max-width: 25%;
padding: 0 4px;
    }
    .gallery {
-webkit-column-count: 3;
-moz-column-count: 3;
column-count: 3;
-webkit-column-width: 33%;
-moz-column-width: 33%;
column-width: 33%;

}

.gallery .pics {
-webkit-transition: all 350ms ease;
transition: all 350ms ease;
cursor: pointer;
}

.gallery .animation {
-webkit-transform: scale(1);
-ms-transform: scale(1);
transform: scale(1);
}

@media (max-width: 768px) {
.gallery {
-webkit-column-count: 2;
-moz-column-count: 2;
column-count: 2;
-webkit-column-width: 100%;
-moz-column-width: 100%;
column-width: 100%;
}
}

@media (max-width: 450px) {
.gallery {
-webkit-column-count: 1;
-moz-column-count: 1;
column-count: 1;
-webkit-column-width: 100%;
-moz-column-width: 100%;
column-width: 100%;
}
}

@media (max-width: 400px) {
.btn.filter {
padding-left: 1.1rem;
padding-right: 1.1rem;
}
}
</style>

<form class="row col-12  p-0 forms-sample w-full" name="formSubmitGallery " id="formSubmitGallery" enctype="multipart/form-data" method="POST">
    <!-- <div class="form-group col-12 col-md-6">
        <label>Category</label>
        @csrf
        <input type="hidden" name="user_id" value="">
        <select class="form-control h-11" id="category" name="category" >
             <option disabled value="" selected>Select Category</option> 
             @foreach ($categorys as $category)
                <option value="{{$category->id}}" >{{$category->name}}</option> 
             @endforeach
        </select>
       
    </div>
    <div class="form-group  col-12 col-md-6">
        <label>Sub Category</label>
        @csrf 
        <select class="form-control h-11" id="subcategory" onchange="$('#formSubmitGallery').submit();" name="subcategory" >
             <option disabled selected>Select Sub Category</option> 
        </select>
      
    </div>   -->
</form>

<section class="mt-8">
    <div class="container">
        <div class="section-title center-title text-center mb-5 rounded p-3">
            <h2 class="removeText" style="font-size: 30px">Gallery</h2>
        </div> 
        <div class="gallery" id="gallery">
             @for($i = 0; $i < count($gallery); $i++)
                <div class="mb-3 pics animation all 2" style="position: relative">
                    <i onclick="copyText(this)"  data-image_link="{{$gallery[$i]->image}}" class="text-white fa fa-clone copyIcon"> 
                        <span class="tooltiptext" id="myTooltip">Copy</span> 
                    </i> 
                    <img class=" img-fluid" src="{{$gallery[$i]->image}}" alt="">
                </div>
             @endfor 
        </div> 
    </div> 
    </section>
 
 
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

function copyText(element){
        const el = document.createElement('textarea'); 
        var copyText=$(element).attr("data-image_link");
        console.log(copyText);
        el.value = copyText;  
        el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
        el.style.position = 'absolute';                 
        el.style.left = '-9999px';                      // Move outside the screen to make it invisible
        document.body.appendChild(el);                  // Append the <textarea> element to the HTML document
        const selected =            
            document.getSelection().rangeCount > 0        // Check if there is any content selected previously
            ? document.getSelection().getRangeAt(0)     // Store selection if found
            : false;                                    // Mark as false to know no selection existed before
        el.select();                                    // Select the <textarea> content
        document.execCommand('copy');                   // Copy - only works as a result of a user action (e.g. click events)
        document.body.removeChild(el);                  // Remove the <textarea> element
    if (selected) {                                 // If a selection existed before copying
        document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
        document.getSelection().addRange(selected);   // Restore the original selection
    }
}
    
</script>
@endslot
@endcomponent

