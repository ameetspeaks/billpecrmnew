<?php $page = 'low-stocks'; ?>
@extends('store.storeAdmin.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            
            <div class="table-tab">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active">Low Stocks</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
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
                                                <th>Stock</th>
                                                <th>Low Stock</th>
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
            </div>
        </div>
    </div>

    <script>

        $(function () {
            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('store.low-stocks') }}",
                
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
                        "data": "stock",
                    },
                    {
                        "data": "low_stock",
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
