@component('admin.component')
@slot('title') Delivery Partner  @endslot
@slot('subTitle')Delivery Partner list @endslot
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
                <th> Phone </th>
                <th> Aadhar Number </th>
                <th> Driving Licence </th>
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
              ajax: "{{ route('admin.deliveryPartner.index') }}",

                "columns": [
                    {
                        "data": "delivery_boy_detail.name",
                    },
                    {
                        "data": "delivery_boy_detail.whatsapp_no",
                    },
                    {
                        "data": "delivery_boy_detail.aadhar_number",
                    },
                    {
                        "data": "delivery_boy_detail.driving_licence",
                    },
                    {
                        "data": "status",
                        "render": function(data, type, row) {
                            let account_status_class;
                            if(row.account_status == "Approved") {
                                account_status_class = "btn-success";
                            } else if (row.account_status == "Rejected") {
                                account_status_class = "btn-primary";
                            } else {
                                account_status_class = "btn-info";
                            }
                            return '<button class="btn '+account_status_class+' btn-sm">'+row.account_status+'</button>';
                        },
                    },
                    {
                        "data": "user_id",
                        "render": function(data, type, row) {
                            return ' <ul>  <li ><a href=" {{ url('admin/viewDeliveryPartner') }}/' + data +'" ><button class="btn btn-success btn-sm">View<button></a></li></ul>';
                        },
                    },
                ],

          });
        });
</script>
@endslot
@endcomponent

