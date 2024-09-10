@component('admin.component')
@slot('title') BLog Detail @endslot
@slot('subTitle') BLog Detail list @endslot
@slot('content')
<div class="text-right col-12">
    <a href="{{ route('admin.blog.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add blog</button>
    </a>
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th> Blog Image </th>
                <th> Category Name </th>
                <th> Title </th>
                <th> Meta Title </th>
                <th> Meta Description </th>
                <th> Meta Keyword </th>
                <th> Post </th>
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
            ajax: "{{ route('admin.blog.index') }}",
            
            "columns": [
                {
                    "data": "blog_image",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.blog_image){
                            return ' <img src="'+row.blog_image+'" alt="Image"> ' ;
                        }else{
                            var firstLetter = row.title.slice(0,1);
                            return '<button type="button" class="btn btn-light">'+firstLetter+'</button>';
                        }
                    },
                },
                {
                    "data": "blog_category.name",
                },
                {
                    "data": "title",
                },
                {
                    "data": "meta_title",
                },
                {
                    "data": "meta_description",
                },
                {
                    "data": "meta_keyword",
                },
                {
                    "data": "post",
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        console.log(row)
                            return ' <ul>  <li ><a href=" {{ url('admin/editBlog') }}/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>    </ul>';
                        
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

                var url = '{{ route('admin.blog.delete',["id" => ":id"]) }}';
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


    // //change status
    // $(document).on('click','.changeStatus', function(){
    //     var id = $(this).attr('data-id');
    //     var statusName = $(this).attr('data-statusName');
        
    //     $.ajax({
    //             url: "{{ route('admin.centralLibrary.changeStatus') }}",
    //             method: 'post',
    //             data: { "_token" : "{{csrf_token()}}", 'id': id , 'statusName': statusName},
    //             success: function(data){
    //                console.log(data)
    //                $('.table').DataTable().ajax.reload();
    //             }
    //     });

    // })
</script>
@endslot
@endcomponent
