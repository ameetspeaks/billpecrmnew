<!-- Your Blade View Code -->
@component('admin.component')
@slot('title') Trial User Detail @endslot
@slot('subTitle') Trial User Details @endslot
@slot('content')
<div class="text-right col-12">
  
    <a href="{{ route('admin.exportTrialUser') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Export</button>
    </a>

</div>

    <div class="table-responsive mt-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> User Name </th>
                    <th> User Phone </th>
                    <th> Shop Name </th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </div>
@endslot
@slot('script')
<script>
    var table;

    $(document).ready(function () {
        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: "{{ route('admin.viewTrialUser') }}",
            },
          
            "columns": [
                {
                    "data": "user.name",
                },
                {
                    "data": "user.whatsapp_no",
                },
                {
                    "data": "shop_name",
                },
            ],
        });
    });
</script>
@endslot
@endcomponent
