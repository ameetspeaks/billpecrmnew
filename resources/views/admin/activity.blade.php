@component('admin.component')
@slot('title') Activity @endslot
@slot('subTitle') Activity list @endslot
@slot('content')

<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Action </th>
                <th> Message </th>
                <th> Created AT </th>
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
              ajax: "{{ route('admin.activity') }}",
            //   columns: [
            //       {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            //       {data: 'name', name: 'name'},
            //       {data: 'action', name: 'action'},
            //   ]

            "columns": [
                {
                    "data": "action",
                },
                {
                    "data": "message",
                },
                {
                   "data": "datecurrent",
                },
            ],

          });
        });
</script>
@endslot
@endcomponent

