@component('admin.component')
@slot('title') Charges @endslot
@slot('subTitle')Charges @endslot
@slot('content')

<div class="text-right col-12">
    <a href="{{route('admin.charges.add')}} ">
        <button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add Charges</button>
    </a>

</div>

<div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th> Name </th>
                <th> Amount </th>
                <th> Minimum Cart Amount </th>
                <th> Start Time </th>
                <th> End Time </th>
                <th> Occurring </th>
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
            ajax: "{{ route('admin.charges.index') }}",

            "columns": [
                {
                    "data": "name",
                },
                {
                    "data": "amount",
                },
                {
                    "data": "minimum_cart_value",
                },
                {
                    "data": "start_time",
                },
                {
                    "data": "end_time",
                },
                {
                    "data": "occurring",
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.status == 1){
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="charges" checked> <span class="slider round"></span> </label> ' ;
                        }else{
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="charges"> <span class="slider round"></span> </label> ' ;
                        }
                    },
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        console.log(row)
                        if (row.id !== 1 && row.id !== 2) {
                            return ' <ul>  <li ><a href=" {{ url('admin/editCharge') }}/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>  <li><a href="#" ><button class="btn btn-primary btn-sm" id="remove" data-id="' + data +'">Delete<button></a></li> </ul>';
                        }
                        return ' <ul>  <li ><a href=" {{ url('admin/editCharge') }}/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>  </ul>';
                    },
                },

            ],
        });
    });

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

                var url = '{{ route('admin.charges.delete',["id" => ":id"]) }}';
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


</script>

@endslot

@endcomponent
