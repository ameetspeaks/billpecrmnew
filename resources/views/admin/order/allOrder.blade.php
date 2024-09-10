@component('admin.component')
@slot('title') Order @endslot
@slot('subTitle') Order list @endslot
@slot('content')


<div class="text-right col-12">
    {{-- <a href="{{ route('admin.product.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add product</button>
    </a> --}}
    {{-- <button type="button" class="btn btn-outline-secondary btn-fw  text-capitalize">Export</button>
    <button type="button" class="btn btn-outline-secondary btn-fw  text-capitalize">Import</button> --}}
</div>

<div class="text-right col-12">
 <span class="text-xs text-red-500 mt-2 errmsg_productExcel"></span>
 <div>
    <ul id="showExportError">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        @endif
    </ul>
 </div>
</div>

<div class="text-right col-12">
    <span class="text-xs text-green-500 mt-2 successmsg_productExcel"></span>
</div>

<div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th> Order Id </th>
                <th> Order Date </th>
                <th> Customer Information</th>
                <th> Store </th>
                <th> Total Amount </th>
                <th> Order Status </th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
@endslot
@slot('script')
<script>

    $(function () {
        var table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: "{{ route('admin.order.allOrder') }}",

            "columns": [
                {
                    "data": "order_number",
                },
                {
                    "data": "date",
                },
                {
                    "data": "customer.name",
                },
                {
                    "data": "store.shop_name",
                },
                {
                    "data": "total_amount",
                },
                {
                    "data": "order_status",
                    "render": function(data, type, row) {
                        console.log(row)
                        return ' <button class="btn btn-primary btn-sm">'+row.order_status.name+'<button> ';
                    },
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        console.log(row)

                        // return ' <ul>  <li ><a href=" {{ url('admin/editProduct') }}/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>  <li><a href="#" > </ul>';
                        return ' <ul>  <li ><a href=" {{ url('admin/ViewOrder') }}/' + data +'" " ><button class="btn btn-success btn-sm">View<button></a></li>  <li><a href="#" > </ul>';

                    },
                },

            ],
        });
    });


    //remove product
    $(document).on('click', '#remove', function(){
        var id = $(this).attr('data-id');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
            if(result.value){

                var url = '{{ route('admin.product.delete',["id" => ":id"]) }}';
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data)
                    {
                        if(data.status == false){
                            Swal.fire(data.title,data.message,data.type);
                        }
                        Swal.fire(
                            "Deleted!",
                            "Deleted successfully.",
                            "success"
                        ).then(function() {
                            $('.table').DataTable().ajax.reload();
                        });
                    }
                });

            }
        });
    })

    //change status
    $(document).on('click','.changeStatus', function(){
        var id = $(this).attr('data-id');
        var statusName = $(this).attr('data-statusName');

        $.ajax({
                url: "{{ route('admin.centralLibrary.changeStatus') }}",
                method: 'post',
                data: { "_token" : "{{csrf_token()}}", 'id': id , 'statusName': statusName},
                success: function(data){
                   console.log(data)
                   $('.table').DataTable().ajax.reload();
                }
        });

    })

</script>
@endslot
@endcomponent
