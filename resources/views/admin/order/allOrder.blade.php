@component('admin.component')
    @slot('title')
        Order
    @endslot
    @slot('subTitle')
        Order list
    @endslot
    @slot('content')
        <div class="text-right col-12">
            {{-- <a href="{{ route('admin.product.add') }}">
                <button type="button" class="btn btn-outline-secondary btn-fw text-capitalize">Add product</button>
            </a> --}}
            {{-- <button type="button" class="btn btn-outline-secondary btn-fw  text-capitalize">Export</button>
            <button type="button" class="btn btn-outline-secondary btn-fw  text-capitalize">Import</button> --}}
        </div>

        <div class="text-right col-12">
            <span class="text-xs text-red-500 mt-2 errmsg_productExcel"></span>
            <div>
                <ul id="showExportError">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="text-right col-12">
            <span class="text-xs text-green-500 mt-2 successmsg_productExcel"></span>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th> Order Id</th>
                        <th> Order Date</th>
                        <th> Customer Information</th>
                        <th> Store</th>
                        <th> Total Amount</th>
                        <th> Order Status</th>
                        <th> Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    @endslot
    @slot('script')
        <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

        <script>
            $(function() {
                var table = $('.table').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [],
                    ajax: "{{ route('admin.order.allOrder') }}",

                    "columns": [{
                            "data": "id",
                            "name": "id"
                        },
                        {
                            "data": "created_at",
                            "name": "created_at",
                            "render": function(data, type, row) {
                                const date = new Date(data);

                                const padZero = num => (num < 10 ? '0' + num : num);

                                const formatAMPM = date => {
                                    let hours = date.getHours();
                                    const minutes = padZero(date.getMinutes());
                                    // const seconds = padZero(date.getSeconds());
                                    const ampm = hours >= 12 ? 'PM' : 'AM';
                                    hours = hours % 12;
                                    hours = hours ? hours : 12;
                                    // return `${padZero(hours)}:${minutes}:${seconds} ${ampm}`;
                                    return `${padZero(hours)}:${minutes} ${ampm}`;
                                };

                                const formattedDate =
                                    `${date.getFullYear()}-${padZero(date.getMonth() + 1)}-${padZero(date.getDate())} ${formatAMPM(date)}`;

                                return formattedDate;
                            },

                        },
                        {
                            "data": "customer_name",
                            "name": "customer_name"
                        },
                        {
                            "data": "shop_name",
                            "name": "shop_name"
                        },
                        {
                            "data": "total_amount",
                            "name": "total_amount"
                        },
                        {
                            "data": "order_status",
                            "name": "order_status"
                            // "render": function(data, type, row) {
                            //     console.log(row)
                            //     return ' <button class="btn btn-primary btn-sm">'+row.order_status.name+'<button> ';
                            // },
                        },
                        {
                            "data": "action",
                            "name": "action"
                        },

                    ],
                });

                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                    cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                    forceTLS: true
                });

                var channel = pusher.subscribe('order-tracking');


                channel.bind('order-tracker', function(data) {
                    console.log('Event Data - ', data);
                    table.ajax.reload(null, false);

                });

                var pusher2 = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                    cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
                });

                var channel2 = pusher2.subscribe('admin-order-alert');
                channel2.bind('new-order', function(data) {
                    //     reload the table
                    table.ajax.reload(null, false);
                });

                // // Bind to the event for order tracking updates
                // channel.bind('App\\Events\\OrderTrackingUpdated', function(data) {
                //     // Assuming you want to update the order list with the new status or some table
                //     // Clear the existing table data and add the new data from the event
                //     table.clear().rows.add(data['order']).draw();

                //     // Log the received data (for debugging purposes)
                //     console.log(JSON.stringify(data['order']));
                // });

            });


            //remove product
            $(document).on('click', '#remove', function() {
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to delete!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                    if (result.value) {

                        var url = '{{ route('admin.product.delete', ['id' => ':id']) }}';
                        url = url.replace(':id', id);
                        $.ajax({
                            type: 'GET',
                            url: url,
                            success: function(data) {
                                if (data.status == false) {
                                    Swal.fire(data.title, data.message, data.type);
                                }
                                Swal.fire(
                                    "Deleted!",
                                    "Deleted successfully.",
                                    "success"
                                ).then(function() {
                                    $('.table').DataTable().ajax.reload();
                                });
                            }
                        });

                    }
                });
            })

            //change status
            $(document).on('click', '.changeStatus', function() {
                var id = $(this).attr('data-id');
                var statusName = $(this).attr('data-statusName');

                $.ajax({
                    url: "{{ route('admin.centralLibrary.changeStatus') }}",
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': id,
                        'statusName': statusName
                    },
                    success: function(data) {
                        console.log(data)
                        $('.table').DataTable().ajax.reload();
                    }
                });

            })
        </script>
    @endslot
@endcomponent
