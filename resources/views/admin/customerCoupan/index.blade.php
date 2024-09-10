@component('admin.component')
@slot('title') Customer Coupan @endslot
@slot('subTitle')Customer Coupan list @endslot
@slot('content')

<div class="text-right col-12">
    <a href="{{route('admin.customerCoupan.add')}} ">
        <button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add Coupan</button>
    </a>

</div>

<div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th> Title </th>
                <th> Sub Heading </th>
                <th> Discount </th>
                <th> Start Date </th>
                <th> End Date </th>
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
            ajax: "{{ route('admin.customerCoupan.index') }}",

            "columns": [
                {
                    "data": "title",
                },
                {
                    "data": "sub_heading",
                },
                {
                    "data": "discount",
                },
                {
                    "data": "start_date",
                },
                {
                    "data": "end_date",
                },
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        console.log(row)
                        return ' <a href="#" ><button class="btn btn-primary btn-sm" id="remove" data-id="' + data +'">Delete<button></a>';
                    },
                },

            ],
        });
    });

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

                var url = '{{ route('admin.customerCoupan.delete',["id" => ":id"]) }}';
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
