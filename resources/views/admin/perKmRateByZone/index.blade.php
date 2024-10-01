@component('admin.component')
@slot('title') Per KM Rate By Zone  @endslot
@slot('subTitle') Per KM Rate By Zone list @endslot
@slot('content')
{{-- <div class="text-right col-12">
    @can('Create Role')
    <a href="{{ route('admin.deliveryPartner.add') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Add Customer Banner</button>
    </a>
    @endcan
</div> --}}
<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Name </th>
                <th> Rate </th>
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
              ajax: "{{ route('admin.perKmRateByZone.index') }}",

                "columns": [
                    {
                        "data": "name",
                    },
                    {
                        "data": "per_km_rate",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            let editUrl = "{{ route('admin.perKmRateByZone.edit', ['id' => ':id']) }}";
                            editUrl = editUrl.replace(':id', data);
                            
                            return ` <ul>  <li ><a href="${ editUrl }" ><button class="btn btn-primary btn-sm">Edit<button></a></li></ul>`;
                        },
                    },
                ],

          });
        });
</script>
@endslot
@endcomponent

