@component('admin.component')
@slot('title') Shift Timings  @endslot
@slot('subTitle') Shift timings list @endslot
@slot('content')
<div class="text-right col-12">
    @can('Create Shift Timings')
    <a href="{{ route('admin.shiftTimings.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Shift Timings</button>
    </a>
    @endcan
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Type </th>
                <th> Name </th>
                <th> From - To </th>
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
              ajax: "{{ route('admin.shiftTimings.index') }}",

                "columns": [
                    {
                        "data": "type",
                    },
                    {
                        "data": "name",
                    },
                    {
                        "data": "from",
                        "render": function(data, type, row) {
                            return moment(row.from, "HH:mm").format("hh:mm A") + ' - ' + moment(row.to, "HH:mm").format("hh:mm A");
                        },
                    },
                    {
                        "data": "status",
                        "render": function(data, type, row) {
                            if(row.status == 1){
                                return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="shiftTimings" checked> <span class="slider round"></span> </label> ' ;
                            }else{
                                return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="shiftTimings"> <span class="slider round"></span> </label> ' ;
                            }
                        },
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            let actionButton = `<ul>`;
                            @can("Edit Shift Timings")
                                actionButton += `<li ><a href=" {{ url('admin/shift-timings/edit') }}/${ data }" ><button class="btn btn-success btn-sm">Edit<button></a></li>`;
                            @endcan
                            @can("Delete Shift Timings")
                                    actionButton += `<li ><a href="{{ url('admin/shift-timings/delete') }}/${ data }" class="delete_shift"><button class="btn btn-danger btn-sm">Delete<button></a></li>`;
                            @endcan
                            actionButton += `</ul>`;

                            return actionButton;
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
        //change status
        $(document).on('click','.delete_shift', function(e){
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if(result.value){
                    window.location.href = href;
                }
            });
        })
</script>
@endslot
@endcomponent

