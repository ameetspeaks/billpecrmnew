@component('admin.component')
@slot('title') permissions @endslot
@slot('subTitle') permissions list @endslot
@slot('content')
<div class="text-right col-12">
    <a href="{{ route('admin.permission.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Permission</button>
    </a>
</div>
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Name </th>
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
              ajax: "{{ route('admin.permission.getDatatable') }}",
                "columns": [
                    {
                        "data": "name",
                    },
                ],

          });
        });
</script>
@endslot
@endcomponent

