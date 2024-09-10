@component('admin.component')
@slot('title') Loyalty Point  @endslot
@slot('subTitle')Loyalty Point  list@endslot
@slot('content')
<div class="text-right col-12">
    @can('Create Role')
    <a href="{{ route('admin.loyaltypoint.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Loyalty Point</button>
    </a>
    @endcan
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Module Name </th>
                <th> 1 INR Point </th>
                <th> Maximum Point </th>
                <th> Minimun point to convert </th>
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
              ajax: "{{ route('admin.loyaltypoint.index') }}",

                "columns": [
                    {
                        "data": "module.name",
                    },
                    {
                        "data": "one_INR_point_amount",
                    },
                    {
                        "data": "min_point_per_order",
                    },
                    {
                        "data": "max_point_to_convert",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                        console.log(row)
                            return ' <ul>  <li ><a href=" {{ url('admin/editLoyalty') }}/' + data +'" " ><button class="btn btn-success btn-sm">Edit<button></a></li>  <li><a href="#" ><button class="btn btn-primary btn-sm" id="remove" data-id="' + data +'">Delete<button></a></li> </ul>';

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

                    var url = '{{ route('admin.loyaltypoint.delete',["id" => ":id"]) }}';
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

