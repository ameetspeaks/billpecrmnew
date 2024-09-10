@component('admin.component')
@slot('title') Template Type @endslot
@slot('subTitle') Template Type list @endslot
@slot('content')
<div class="text-right col-12">
    <a href="{{ route('admin.template.type.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Template Type</button>
    </a>
  
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th> Template Type</th>
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
            ajax: "{{ route('admin.template.type') }}",
            
            "columns": [
                {
                    "data": "name",
                },
            
                {
                    "data": "id",
                    "render": function(data, type, row) {
                        console.log(row)
                        return ' <a href=" {{ url('admin/Edit-TemplateType') }}/' + data +'" "><button class="btn btn-success btn-sm">Edit<button></a>';
                    },
                },
               
            ],
        });
    });

</script>
@endslot
@endcomponent

