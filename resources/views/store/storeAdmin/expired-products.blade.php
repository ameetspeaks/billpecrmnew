<?php $page = 'expired-products'; ?>
@extends('store.storeAdmin.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Expired Products</h4>
                        <h6>Manage your expired products</h6>
                    </div>
                </div>
            </div>

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Store</th>
                                    <th>Expiry</th>
                                    <th>Status</th>
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
            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('store.expired-products') }}",
                
                "columns": [
                    {
                        "data": "product_image",
                        "render": function(data, type, row) {
                            console.log(row)
                            if(row.product_image){
                                return ' <div class="productimgname"> <a href="javascript:void(0);" class="product-img stock-img"><img src="'+row.product_image+'"alt="product"></a></div> ';
                            }else{
                                var firstLetter = row.product_name.slice(0,1);
                                return '<button type="button" class="btn btn-light">'+firstLetter+'</button>';
                            }
                        },
                    },
                    {
                        "data": "product_name",
                    },
                    {
                        "data": "category.name",
                    },
                    {
                        "data": "store.shop_name",
                    },
                    {
                        "data": "expiry",
                    },
                    {
                        "data": "status",
                        "render": function(data, type, row) {
                            console.log(row)
                            if(row.status == 1){
                                return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="product" checked> <span class="slider round"></span> </label> ' ;
                            }else{
                                return ' <label class="switch"> <input type="checkbox" class="changeStatus" data-id=" ' + row.id + ' " data-statusName="product"> <span class="slider round"></span> </label> ' ;
                            }
                        },
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            console.log(row)
                                
                            return ' <a href=" {{ url('store/editProduct') }}/' + data +'" " ><i data-feather="edit" class="feather-edit"></i></a><a href="#" id="remove" data-id="'+row.id+'"> <i data-feather="trash-2" class="feather-trash-2"></i></a>';
                            
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

                    var url = '{{ route('store.product.delete',["id" => ":id"]) }}';
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
