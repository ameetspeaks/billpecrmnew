@component('admin.component')
@slot('title') Category @endslot
@slot('subTitle') Category list @endslot
@slot('content')
<div class="text-right col-12">
    <a href="{{ route('admin.category.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add category</button>
    </a>
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th> Image </th>
                <th> Name </th>
                <th> Module Name</th>
                <th> Featured</th>
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
            ajax: "{{ route('admin.category.getDatatable') }}",

            "columns": [
                {
                    "data": "image",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.image){
                            return ' <img src="'+row.image+'" alt="Image"> ' ;
                        }else{
                            var firstLetter = row.name.slice(0,1);
                            return '<button type="button" class="btn btn-light">'+firstLetter+'</button>';
                        }
                    },
                },
                {
                    "data": "name",
                },
                {
                    "data": "module.name",
                },
                {
                    "data": "featured",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.featured == 1){
                            return ' <label class="switch"> <input type="checkbox" class="changeFeatured" data-id=" ' + row.id + ' " data-changeFeatured="category" checked> <span class="slider round"></span> </label> ' ;
                        }else{
                            return ' <label class="switch"> <input type="checkbox" class="changeFeatured" data-id=" ' + row.id + ' " data-changeFeatured="category"> <span class="slider round"></span> </label> ' ;
                        }
                    },
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.status == 1){
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="category" checked> <span class="slider round"></span> </label> ' ;
                        }else{
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="category"> <span class="slider round"></span> </label> ' ;
                        }
                    },
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        console.log(row)
                            return ' <ul>  <li ><a href=" {{ url('admin/editCategory') }}/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>  <li><a href="#" ><button class="btn btn-primary btn-sm" id="remove" data-id="' + data +'">Delete<button></a></li>  </ul>';

                    },
                },
            ],
        });
    });


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

                var url = '{{ route('admin.category.delete',["id" => ":id"]) }}';
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

    //change Featured
    $(document).on('click','.changeFeatured', function(){
        var id = $(this).attr('data-id');
        var changeFeatured = $(this).attr('data-changeFeatured');
        $.ajax({
                url: "{{ route('admin.centralLibrary.changeFeatured') }}",
                method: 'post',
                data: { "_token" : "{{csrf_token()}}", 'id': id , 'changeFeatured': changeFeatured},
                success: function(data){
                   console.log(data)
                   $('.table').DataTable().ajax.reload();
                }
        });

    })
</script>
@endslot
@endcomponent
