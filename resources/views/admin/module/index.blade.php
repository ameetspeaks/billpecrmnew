@component('admin.component')
@slot('title') module @endslot
@slot('subTitle') module list @endslot
@slot('content')
<div class="text-right col-12">
    <a href="{{ route('admin.module.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Module</button>
    </a>

</div>
<div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th> Name </th>
                <th> Store Type </th>
                <th> Online Store </th>
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
            ajax: "{{ route('admin.module.getDatatable') }}",

            "columns": [
                {
                    "data": "name",
                },
                {
                    "data": "store_type.name",
                },

                {
                    "data": "online",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.online == 1){
                            return ' <label class="switch"> <input type="checkbox" class="changeOnlineStatus" data-id=" ' + row.id + ' " data-statusName="module" checked> <span class="slider round"></span> </label> ' ;
                        }else{
                            return ' <label class="switch"> <input type="checkbox" class="changeOnlineStatus" data-id=" ' + row.id + ' " data-statusName="module"> <span class="slider round"></span> </label> ' ;
                        }
                    },
                },

                {
                    "data": "status",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.status == 1){
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="module" checked> <span class="slider round"></span> </label> ' ;
                        }else{
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="module"> <span class="slider round"></span> </label> ' ;
                        }
                    },
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        console.log(row)
                        return ' <a href=" {{ url('admin/editModule') }}/' + data +'" "><button class="btn btn-success btn-sm">Edit<button></a>';
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

    //change Online status
    $(document).on('click','.changeOnlineStatus', function(){
        var id = $(this).attr('data-id');
        var statusName = $(this).attr('data-statusName');

        $.ajax({
                url: "{{ route('admin.module.changeOnlineStatus') }}",
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

