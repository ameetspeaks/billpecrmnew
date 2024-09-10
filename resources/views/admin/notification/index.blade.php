@component('admin.component')
@slot('title') Notfication @endslot
@slot('subTitle') Notfication History @endslot
@slot('content')

<div class="text-right col-12">
    @can('Create Role')
    <a href="{{ route('admin.notification.send') }}">
        <button type="button" class="btn btn-outline-secondary btn-fw">Send Notification</button>
    </a>
    @endcan
</div>

<canvas id="userChart"></canvas>



<div class="table-responsive mt-3">
    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th> Date Time </th>
                <th> Notification Title </th>
                <th> Delivered </th>
                <th> Not Delivered </th>
            </tr>
        </thead>
        <tbody>
          
        </tbody>
    </table>
</div>
@endslot
@slot('script')
<script>
    var ctx = document.getElementById('userChart').getContext('2d');
    var chart = new Chart(ctx, {

        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset            
        data: {
            labels:  @json($data->pluck('creation_date')),
            datasets: [{
                            label: "Delivered",
                            backgroundColor: '#38b05a',
                            borderColor: '#ed133f',
                            data: @json($data->pluck('notification_delivered')),
                        },
                        {
                            label: "Not delivered",
                            backgroundColor: '#ed133f',
                            borderColor: '#38b05a',
                            data: @json($data->pluck('notification_not_delivered')),
                        }]
        },
        // Configuration options go here
        options: {}
    });






    $(function () {
          var table = $('#myTable').DataTable({
              processing: true,
              serverSide: true,
              order: [],
              ajax: "{{ route('admin.notification.getDatatable') }}",
          
                "columns": [
                    {
                        "data": "creation_date",
                    },
                    {
                        "data": "title",
                    },
                    {
                        "data": "notification_delivered",
                    },
                    {
                        "data": "notification_not_delivered",
                    },
                ],

          });
        });
</script>
@endslot
@endcomponent

