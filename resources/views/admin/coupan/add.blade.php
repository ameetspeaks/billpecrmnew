@component('admin.component')
@slot('title') Add Coupan @endslot

@slot('subTitle') add Coupan detail @endslot
@slot('content')

<form class="row forms-sample w-full" action="{{ route('admin.coupan.store') }}"  method="POST">
    @csrf
    <div class="form-group col-4 err_name">
        <label>Coupan Name</label>
        <input type="text" name="name" class="form-control" placeholder="Coupan Name" required>
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <div class="form-group col-4 err_code">
        <label>Coupan Code</label>
        <input type="text" name="code" class="form-control" placeholder="Coupan Code" required>
        <span class="text-xs text-red-500 mt-2 errmsg_code"></span>
    </div>

   
    <div class="form-group col-4 errmsg_discount%">
        <label>Discount</label>
        <input type="number" name="discount" class="form-control" placeholder="Discount" required>
        <span class="text-xs text-red-500 mt-2 errmsg_discount%"></span>
    </div>

    <div class="form-group col-4 errmsg_discount₹">
        <label>Discount Type</label>
        <select class="form-control" name="discountType" required>
            <option value="">Select Type</option>
            <option value="%">%</option>
            <option value="₹">₹</option>
        </select>
        <span class="text-xs text-red-500 mt-2 errmsg_discount₹"></span>
    </div>

    <div class="form-group col-4 err_start_date">
        <label>Start Date</label>
        <input type="date" name="start_date" class="form-control" placeholder="Start Date" required>
        <span class="text-xs text-red-500 mt-2 errmsg_start_date"></span>
    </div>

    <div class="form-group col-4 err_end_date">
        <label>End Date</label>
        <input type="date" name="end_date" class="form-control" placeholder="Start Date" required>
        <span class="text-xs text-red-500 mt-2 errmsg_end_date"></span>
    </div>

    <div class="form-group col-4 err_minimum_purchase">
        <label>Minimum Purchase</label>
        <input type="number" name="minimum_purchase" class="form-control" placeholder="Minimum Purchase" required>
        <span class="text-xs text-red-500 mt-2 errmsg_minimum_purchase"></span>
    </div>

    <div class="form-group col-md-4 col-12 err_package">
        <label for="packageSelect">Select Package:</label>
        <select class="form-control form-group h-11" id="packageSelect" name="package">
            <option value="all">All</option>
            <option value="trial">Trial</option>
            <option value="paid">Paid</option>
        </select>
    </div>

    <div class="form-group col-md-4 col-12 err_store">
        <label for="packageSelect">Select Store:</label>
        <select class="form-control select" name="selected_stores[]" id="store" multiple>
            @foreach ($stores as $store)
                <option value="{{ $store->id }}">{{ $store->shop_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-4 col-12">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="{{ route('admin.coupan.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
@endslot
@slot('script')


<script>
    $('.select').select2({ placeholder: "Select Store" }).trigger('change');
    $(document).on('change','#packageSelect', function(){
        var packageSelect = $('#packageSelect').val();
       
        $.ajax({
                url: '{{ route('admin.getStoreByPackage') }}',
                method: 'post',
                data: { "_token" : "{{csrf_token()}}", 'packageSelect': packageSelect },
                success: function(data){
                    console.log(data)
                    $('#store').empty();
                    $.each(data.stores, function(index, value){  
                        console.log(value)
                        store = '<option value="'+value.id+'">'+value.shop_name+'</option>'
                        $('#store').append(store);
                    }) 
                }
        });
    })
</script>
@endslot
@endcomponent

