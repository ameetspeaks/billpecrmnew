@component('admin.component')
@slot('title') Bill History @endslot
@slot('subTitle') Bill History list @endslot
@slot('content')

<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Store</th>
                <th> Payment Id</th>
                <th> Order Id</th>
                <th> Payment Amount</th>
                <th> Payment Mode </th>
                <th> Payment Status</th>
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
              ajax: "{{ route('admin.store.billHistory') }}",
          
            "columns": [
                {
                    "data": "store.shop_name",
                },
                {
                    "data": "cf_payment_id",
                },
                {
                    "data": "order_id",
                },
                {
                    "data": "payment_amount",
                },
                {
                    "data": "payment_group",
                },
                {
                    "data": "payment_status",
                    "render": function(data, type, row) {
                        if(row.payment_status == 'SUCCESS'){
                            return ' <button class="btn btn-primary btn-sm">'+row.payment_status+'</button> ';
                        }else{
                            return ' <button class="btn btn-danger btn-sm">'+row.payment_status+'</button> ';
                        }

                    },
                },
            ],

          });
    });
</script>

@endslot
@endcomponent

