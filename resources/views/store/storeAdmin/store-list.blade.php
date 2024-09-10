<?php $page = 'store-list'; ?>
@extends('store.storeAdmin.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Store List</h4>
                        <h6>Manage your Store</h6>
                    </div>
                </div>
                <div class="page-btn">
                    <a href="{{ route('store.add-store') }}" class="btn btn-added" ><i
                            data-feather="plus-circle" class="me-2"></i>Add New Store</a>
                </div>
            </div>

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th>User name </th>
                                    <th>Store name </th>
                                    <th>Store Address</th>
                                    <th>Store Package</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>

    <script>
        $(function () {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('store.store-list') }}",
                
                "columns": [
                    {
                        "data": "user.name",
                    },
                    {
                        "data": "shop_name",
                    },
                    
                    {
                        "data": "address",
                    },
                    {
                        "data": "package.name",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            console.log(row)
                            return '<a href="{{url('store/editStore')}}/'+ data +'" "><i data-feather="edit" class="feather-edit"></i></a><a class="confirm-text p-2" id="remove" data-id="'+row.id+'"><i data-feather="trash-2" class="feather-trash-2"></i></a> ' ;
                        },
                    },               
                ],
            });
        });

        //remove product
        $(document).on('click', '#remove', function(){
            var id = $(this).attr('data-id');
            // alert(id)
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
                }).then(function(result) {
                if(result.value){

                    var url = '{{ route('store.delete',["id" => ":id"]) }}';
                    url = url.replace(':id', id);
                    $.ajax({
                        type: 'GET',
                        url: url,
                        success: function(data)
                        {
                            if(data.status == false){
                                Swal.fire(data.title,data.message,data.type);
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

    </script>
@endsection
