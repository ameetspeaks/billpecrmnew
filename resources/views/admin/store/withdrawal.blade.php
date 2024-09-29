@component('admin.component')
@slot('title') Withdrawal History @endslot
@slot('subTitle') Withdrawal History list @endslot
@slot('content')

<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Store</th>
                <th> Amount</th>
                <th> Status</th>
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
              ajax: "{{ route('admin.store.withdrawal') }}",

            "columns": [
                {
                    "data": "store.shop_name",
                },
                {
                    "data": "amount",
                },
                {
                    "data": "statusvalue.name",
                },
            ],

          });
    });
</script>

@endslot
@endcomponent

