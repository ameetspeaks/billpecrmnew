@component('admin.component')
@slot('title') User @endslot
@slot('subTitle') User list @endslot
@slot('content')
<div class="text-right col-12">
     <a href="{{ route('admin.user.add') }}"><button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add user</button></a> 
     <a href="{{ route('admin.user.export') }}"><button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Export</button></a>
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Name</th>
                <th> Email</th>
                <th> Phone</th>
                <th> Role </th>
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
    $(function () {
          var table = $('#myTable').DataTable({
              processing: true,
              serverSide: true,
              order: [],
              ajax: "{{ route('admin.user.index') }}",
          
            "columns": [
                {
                    "data": "name",
                },
                {
                    "data": "email",
                },
                {
                    "data": "whatsapp_no",
                },
                {
                    "data": "role.name",
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                     console.log(row)
                        return ' <ul>  <li ><a href=" {{ url('admin/editUser') }}/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li> </ul>';

                    },
                },
            ],

          });
    });

    // $(document).on('click', '#remove', function(){
    //     var id = $(this).attr('data-id');
        
    //     Swal.fire({
    //         title: "Are you sure?",
    //         text: "You want to delete!",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonText: "Yes, delete it!"
    //         }).then(function(result) {
    //         if(result.value){

    //             var url = '{{ route('admin.store.delete',["id" => ":id"]) }}';
    //             url = url.replace(':id', id);
    //             $.ajax({
    //                 type: 'GET',
    //                 url: url,
    //                 success: function(data)
    //                 {
    //                     if(data.status == false){
    //                         Swal.fire(data.title,data.message,data.type);
    //                     }
    //                     Swal.fire(
    //                         "Deleted!",
    //                         "Deleted successfully.",
    //                         "success"
    //                     ).then(function() {
    //                         $('.table').DataTable().ajax.reload();
    //                     });
    //                 }
    //             });

    //         }
    //     });
    // })

</script>

@endslot
@endcomponent

