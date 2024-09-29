@component('admin.component')
@slot('title') Customer Banner  @endslot
@slot('subTitle')Customer Banner list @endslot
@slot('content')
<div class="text-right col-12">
    @can('Create Role')
    <a href="{{ route('admin.customerbanner.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Customer Banner</button>
    </a>
    @endcan
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Banner Image </th>
                <th> Name </th>
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
<script type="text/javascript">
    $(function () {
          var table = $('#myTable').DataTable({
              processing: true,
              serverSide: true,
              order: [],
              ajax: "{{ route('admin.customerbanner.index') }}",

                "columns": [
                    {
                        "data": "image",
                        "render": function(data, type, row) {
                            console.log(row)
                            return ' <img src="'+row.image+'" alt="Image"> ' ;
                        },
                    },
                    {
                        "data": "name",
                    },
                    {
                        "data": "status",
                        "render": function(data, type, row) {
                            console.log(row)
                            if(row.status == 1){
                                return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="customerBanner" checked> <span class="slider round"></span> </label> ' ;
                            }else{
                                return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="customerBanner"> <span class="slider round"></span> </label> ' ;
                            }
                        },
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                        console.log(row)
                            return ' <ul>  <li ><a href=" {{ url('admin/editCustomerBanner') }}/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>  <li><a href="#" ><button class="btn btn-primary btn-sm" id="remove" data-id="' + data +'">Delete<button></a></li> </ul>';

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

                    var url = '{{ route('admin.customerbanner.delete',["id" => ":id"]) }}';
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

