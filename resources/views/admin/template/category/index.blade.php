@component('admin.component')
@slot('title') Category @endslot
@slot('subTitle') Category Template list @endslot
@slot('content')
<div class="text-right col-12">
    <a href="{{ route('admin.template.category.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Category</button>
    </a>
  
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th> Category Name</th>
                <th> Action</th>
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
            ajax: "{{ route('admin.template.category.getDatatable') }}",
            
            "columns": [
                {
                    "data": "name",
                },
            
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        console.log(row)
                        return ' <a href=" {{ url('admin/editTemplateCategory') }}/' + data +'" "><button class="btn btn-success btn-sm">Edit<button></a>';
                    },
                },
               
            ],
        });
    });

</script>
@endslot
@endcomponent

