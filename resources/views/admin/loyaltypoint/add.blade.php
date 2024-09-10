@component('admin.component')
@slot('title') Loyalty Point @endslot
@slot('subTitle') Loyalty Point add @endslot
@slot('content')

<form action="{{route('admin.loyaltypoint.store')}}" class="row forms-sample w-full" name="sendNotificationsForm" id="sendNotificationsForm" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group col-md-6 col-12">
        <label for="packageSelect">Select Modules:</label>
        <select class="form-control"  name="modules_id" required>
            <option value="">Select Modules</option>
            @foreach($modules as $module)
            <option value="{{$module->id}}">{{$module->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6 col-12 err_1_INR_point_amount">
        <label><b>1 INR Point Amount</b></label>
        <input type="text" name="one_INR_point_amount"  class="form-control" placeholder="1 INR Point Amount" required>
    </div>

    <div class="form-group col-md-6 col-12 err_min_point_per_order">
        <label><b>Maximum Loyalty Point Per Order</b></label>
        <input type="text" name="min_point_per_order"  class="form-control" placeholder="Minimun Loyalty Point Per Order" required>
    </div>

    <div class="form-group col-md-6 col-12 err_max_point_to_convert">
        <label><b>Minimum Point To Convert</b></label>
        <input type="text" name="max_point_to_convert"  class="form-control" placeholder="Maximum Point To Convert" required>
    </div>

    <div class="form-group col-md-6 col-12 mt-3">
        <button type="submit" class="btn bg-primary text-white">Submit</button>
        <a href="{{ route('admin.loyaltypoint.index') }}"><div class="btn btn-light">Cancel</div></a>
    </div>

</form>
@endslot
@slot('script')


    <script>

    $('.select').select2({ placeholder: "Select Module" }).trigger('change');
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
