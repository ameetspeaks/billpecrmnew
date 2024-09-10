<?php $page = 'customers'; ?>
@extends('store.storeAdmin.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Supplier List</h4>
                        <h6>Manage your Supplier</h6>
                    </div>
                </div>
                <div class="page-btn">
                    <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#add-units"><i
                            data-feather="plus-circle" class="me-2"></i>Add New Supplier</a>
                </div>
            </div>

            @include('store.storeAdmin.layout.partials.session')

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table " id="example">
                            <thead>
                                <tr>
                                    <th>Supplier Name</th>
                                    <th>Supplier Number</th>
                                    <th>Supplier Email</th>
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

    <!-- Add Customer -->
    <div class="modal fade" id="add-units">
        <div class="modal-dialog modal-dialog-centered custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Add Customer</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <form class="row forms-sample w-full" action="{{ route('store.user.store') }}"  method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="role_type" value="3">
                            <input type="hidden" name="type" value="Supplier">
                               <div class="row">
                                    <div class="col-lg-4 pe-0">
                                        <div class="mb-3">
                                            <label class="form-label">Customer Name</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pe-0">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pe-0">
                                        <div class="input-blocks">
                                            <label class="mb-2">Phone</label>
                                            <input class="form-control" name="whatsapp_no" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer-btn">
                                    <button type="button" class="btn btn-cancel me-2"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Customer -->

    <!-- Edit Customer -->
    <div class="modal fade" id="edit-units">
        <div class="modal-dialog modal-dialog-centered custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Edit Customer</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <form class="row forms-sample w-full" action="{{ route('store.user.update') }}"  method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="role_type" value="3">
                            <input type="hidden" name="type" value="Supplier">
                            <input type="hidden" name="id" id="user_id">

                               <div class="row">
                                    <div class="col-lg-4 pe-0">
                                        <div class="mb-3">
                                            <label class="form-label">Customer Name</label>
                                            <input type="text" name="name" id="name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pe-0">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" id="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pe-0">
                                        <div class="input-blocks">
                                            <label class="mb-2">Phone</label>
                                            <input class="form-control" name="whatsapp_no" id="phones" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer-btn">
                                    <button type="button" class="btn btn-cancel me-2"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Customer -->

    <script>

        $(function () {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('store.suppliers') }}",
                
                "columns": [
                    {
                        "data": "name",
                    },
                    {
                        "data": "whatsapp_no",
                    },
                    {
                        "data": "email",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            console.log(row)
                            return '<a id="editUser" data-id="'+data+'" data-name="'+row.name+'" data-phone="'+row.whatsapp_no+'" data-email="'+row.email+'"><i data-feather="edit" class="feather-edit"></i></a><a class="confirm-text p-2" id="remove" data-id="'+row.id+'"><i data-feather="trash-2" class="feather-trash-2"></i></a> ' ;
                        },
                    },               
                ],
            });
        });


        $(document).on('click','#editUser', function(){
            var id = $(this).attr("data-id");
            var name = $(this).attr("data-name");
            var phone = $(this).attr("data-phone");
            var email = $(this).attr("data-email");

            $('#user_id').val(id);
            $('#name').val(name);
            $('#phones').val(phone);
            $('#email').val(email);

            $('#edit-units').modal('show');
        })

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

                    var url = '{{ route('store.user.delete',["id" => ":id"]) }}';
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
