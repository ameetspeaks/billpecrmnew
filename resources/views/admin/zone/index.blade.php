@component('admin.component')
@slot('title') zone @endslot
@slot('subTitle') zone list @endslot
@slot('content')
<div class="text-right col-12">
  
    <a href="{{ route('admin.zone.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Zone</button>
    </a>

</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
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
              ajax: "{{ route('admin.zone.index') }}",
            //   columns: [
            //       {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            //       {data: 'name', name: 'name'},
            //       {data: 'action', name: 'action'},
            //   ]

            "columns": [
                {
                    "data": "name",
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        console.log(row)
                        if(row.status == 1){
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="zone" checked> <span class="slider round"></span> </label> ' ;
                        }else{
                            return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="zone"> <span class="slider round"></span> </label> ' ;
                        }
                    },
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                     
                        return ' <a href=" {{ url('admin/editZone') }}/' + data +'" " class="text-primary d-inline-block edit-item-btn"><button class="btn btn-primary btn-sm">Edit<button></a>';

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
</script>
@endslot
@endcomponent

