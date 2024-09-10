@component('admin.component')
@slot('title') role @endslot
@slot('subTitle') role list @endslot
@slot('content')
<div class="text-right col-12">
  
    <a href="{{ route('admin.role.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Role</button>
    </a>

</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Name </th>
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
              ajax: "{{ route('admin.role.getDatatable') }}",
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
                    "data": "id",
                    "render": function(data, type, row) {
                     
                        return ' <a href=" {{ url('admin/editRole') }}/' + data +'" " class="text-primary d-inline-block edit-item-btn"><button class="btn btn-primary btn-sm">Edit<button></a>';

                    },
                },
            ],

          });
        });
</script>
@endslot
@endcomponent

