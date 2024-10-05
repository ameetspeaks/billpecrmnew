@component('admin.component')
@slot('title') store @endslot
@slot('subTitle') store list @endslot
@slot('content')
<div class="text-right col-12">
     <a href="{{ route('admin.store.add') }}"><button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add store</button></a>
     <a href="{{ route('admin.store.export') }}"><button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Export</button></a>
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> User Name</th>
                <th> Phone</th>
                <th> Store Type</th>
                <th> Shop Name </th>
                <th> Address</th>
                <th> Featured</th>
                <th> Action </th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endslot
@slot('script')

<script type="text/javascript">
    $.fn.dataTable.ext.errMode = 'none';//throw
    $(function () {
          var table = $('#myTable').DataTable({
              processing: true,
              serverSide: true,
              order: [],
              ajax: "{{ route('admin.store.getDatatable') }}",

            "columns": [
                {
                    // "data": "user.name",
                    "data": function(row) {
                        return row.user?.name || '';
                    },
                },
                {
                    "data": "user.whatsapp_no",
                },
                {
                    "data": "module.name",
                },
                {
                    "data": "shop_name",
                },
                {
                    "data": "address",
                },
                {
                    "data": "featured",
                    "render": function(data, type, row) {
                        if(row.featured == 1){
                            return ' <label class="switch"> <input type="checkbox" class="changeFeatured" data-id=" ' + row.id + ' " data-changeFeatured="store" checked> <span class="slider round"></span> </label> ' ;
                        }else{
                            return ' <label class="switch"> <input type="checkbox" class="changeFeatured" data-id=" ' + row.id + ' " data-changeFeatured="store"> <span class="slider round"></span> </label> ' ;
                        }
                    },
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        return ' <ul>  <li ><a href=" {{ url('admin/editStore') }}/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>  <li><a href="#" ><button class="btn btn-primary btn-sm" id="remove" data-id="' + data +'">Delete<button></a></li>   <li ><a href=" {{ url('store/directStoreLogin') }}/' + row.id + '/' +row?.user?.unique_id+'" "  target="_blank"><button class="btn btn-danger btn-sm">Login<button></a></li> </ul>';

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

                var url = '{{ route('admin.store.delete',["id" => ":id"]) }}';
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

