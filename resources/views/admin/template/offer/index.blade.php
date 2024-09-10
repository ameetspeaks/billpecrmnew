@component('admin.component')
@slot('title') Offer @endslot
@slot('subTitle') Offer Template list @endslot
@slot('content')
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
    .offerImg {
        -webkit-column-count: 3;
        -moz-column-count: 3;
        column-count: 3;
        -webkit-column-width: 33%;
        -moz-column-width: 33%;
        column-width: 33%;
    }

    .offerImg .pics {
    -webkit-transition: all 350ms ease;
    transition: all 350ms ease;
    cursor: pointer;
    }

    .offerImg .animation {
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
    }

    @media (max-width: 768px) {
    .offerImg {
    -webkit-column-count: 2;
    -moz-column-count: 2;
    column-count: 2;
    -webkit-column-width: 100%;
    -moz-column-width: 100%;
    column-width: 100%;
    }
    }

    @media (max-width: 450px) {
    .offerImg {
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

    <div class="text-right col-12">
        <a href="{{ route('admin.template.offer.add') }}">
            <button type="button" class="btn btn-outline-secondary btn-fw">Add Template</button>
        </a> 
    </div>

    <div class="form-group col-12 col-md-6">
        <label>Category</label>
        @csrf
        <input type="hidden" name="user_id" value="">
        <select class="form-control h-11" id="category" name="category" >
            <option disabled value="" selected>Select Category</option> 
            @foreach ($cate as $ind=> $c)
                <option value="{{$c->id}}" data-index="{{$ind}}">{{ucwords($c->name)}}</option> 
            @endforeach
        </select>
        @error('category')
        <p class="text-red-500 pb-3 mt-2 font-bold">{{$message}}</p>
        @enderror
    </div>

    <section class="mt-8">
        <div class="container">
            @if(count($offerTemp) > 0)
            <div class="section-title center-title text-center mb-5 rounded p-3">
                <h2 class="removeText" style="font-size: 25px">Offer Template Gallery</h2>
            </div> 
            @endif
            <div class="offerImg" id="offerImg">
                @foreach($offerTemp as $offerTemps)
                    <div class="mb-3 pics animation all 2" style="position: relative">
                        <!-- <i class="text-white fa fa-clone copyIcon"><a href=""><span class="tooltiptext" id="myTooltip">Edit</span></a></i> -->
                        <img class="img-fluid" src="{{$offerTemps->image}}" alt="">
                    </div>
                @endforeach 
            </div> 
        </div> 
    </section>
@endslot
@slot('script')
<script>
   
    $(document).on('change', '#category', function(){
        var cate = $(this).val();

        var url = '{{ route("admin.template.offer.fetchOfferGallery",[":cate"])}}';
        url=url.replace(":cate",cate);
           
        $.ajax({
                type: 'GET',
                url: url,
                processData: false,
                contentType: false,
                dataType: 'json', 
                dataSrc: "",
                success: function(data)
                {
                    console.log(data);
                    if(data.status == 1){
                    
                        var offerImg='';
                        $(".removeText").text("Offer Template Gallery");
                        data.data.forEach(element => {
                            offerImg+=`
                        
                        
                        <div class="mb-3 pics animation all 2" style="position: relative">
                        
                            <img class="img-fluid" src="${element.image}" alt="">
                        </div>
                        `;
                        });
                        $("#offerImg").empty().append(offerImg);

                    }else{
                        $(".removeText").text("");
                        $("#offerImg").empty().append("");
                    } 

            },
            error:function(err){
                console.log("err");
                console.log(err);
            }
        });
    })

</script>
@endslot
@endcomponent


