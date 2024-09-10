@component('admin.component')
@slot('title') Product @endslot
@slot('subTitle') Product list @endslot
@slot('content')


<div class="text-right col-12">
    <a href="{{ route('admin.product.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add product</button>
    </a>
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
                <th> Image </th>
                <th> Name </th>
                <th> Category</th>
                <th> Store</th> 
                <th> Status </th>
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
            ajax: "{{ route('admin.product.getDatatable') }}",
            
            "columns": [
                {
                    "data": "product_image",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.product_image){
                            return ' <img src="'+row.product_image+'" alt="Image"> ' ;
                        }else{
                            var firstLetter = row.product_name.slice(0,1);
                            return '<button type="button" class="btn btn-light">'+firstLetter+'</button>';
                        }
                    },
                },
                {
                    "data": "product_name",
                },
                {
                    "data": "category.name",
                },
                {
                    "data": "store.shop_name",
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.status == 1){
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="product" checked> <span class="slider round"></span> </label> ' ;
                        }else{
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="product"> <span class="slider round"></span> </label> ' ;
                        }
                    },
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        console.log(row)
                            
                        return ' <ul>  <li ><a href=" {{ url('admin/editProduct') }}/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>  <li><a href="#" ><button class="btn btn-primary btn-sm" id="remove" data-id="' + data +'">Delete<button></a></li>  </ul>';
                        
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
