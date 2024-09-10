<?php $page = 'manage-stocks'; ?>
@extends('store.storeAdmin.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
           
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Manage Stock</h4>
                        <h6>Manage your stock</h6>
                    </div>
                </div>
            </div>

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Store</th>
                                    <th>Stock</th>
                                    <th class="text-center no-sort">Action</th>
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


     <!-- Add Inventory -->
     <div class="modal fade" id="add-stock">
        <div class="modal-dialog modal-dialog-centered custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Add Stock</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body custom-modal-body">
                            <b id="product_name"></b>
                            <input type="hidden" name="product_id" id="product_id">
                          
                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" required>
                                <span id="error-msgstock" style="color:red;"></span>
                            </div>
                            <div class="modal-footer-btn">
                                <a href="javascript:void(0);" class="btn btn-cancel me-2"
                                    data-bs-dismiss="modal">Cancel</a>
                                <a href="javascript:void(0);" class="btn btn-submit addStock">Submit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Inventory -->


    <script>

        $(function () {
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                orderby:[],
                ajax: "{{ route('store.manage-stocks') }}",
                
                "columns": [
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            console.log(row)
                            if(row.product_image){
                                return ' <div class="productimgname"> <a href="javascript:void(0);" class="product-img stock-img"> <img src="'+row.product_image +'" alt="product"> </a><a href="javascript:void(0);">'+row.product_name +'</a></div> ' ;
                            }else{
                                var firstLetter = row.product_name.slice(0,1);
                               return ' <div class="productimgname"> <button type="button" class="btn btn-light">'+firstLetter+'</button><a href="javascript:void(0);">'+row.product_name +'</a></div> ' ;
                            }
                        },
                    },
                    {
                        "data": "product_category.name",
                    },
                    {
                        "data": "store.shop_name",
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            console.log(row)
                               return '<td> <div class="product-quantity"><div class="quantity" data-type="-" data-id="'+row.id+'"><i class="fa fa-minus-circle aria-hidden="true"></i></div><input type="text" class="quntity-input'+row.id+'" value="'+row.stock +'" ><div class="quantity" data-type="+" data-id="'+row.id+'"><i class="fa fa-plus-circle"  data-type="+" aria-hidden="true"></i></div></div> </td>' ;
                        },
                    }, 
                    {
                        "data": "id",
                        "render": function(data, type, row) {
                            console.log(row)
                               return ' <a class="addStockmodel" data-stock = "'+row.stock +'" data-id = "'+row.id +'" ><i data-feather="edit" class="feather-edit"></i></a><a class="confirm-text p-2" href="javascript:void(0);"><button class="btn btn-primary btn-sm addStockSave" data-id = "'+row.id +'">Save</button></a> ' ;
                        },
                    },              
                ],
            });
        });

        $(document).on('click', '.quantity', function(){
            var type = $(this).attr('data-type');
            var id = $(this).attr('data-id');
            var input = $('.quntity-input'+id).val();

            if(type == '-'){
                $('.quntity-input'+id).val(parseInt(input) - parseInt(1));
            }
            if(type == '+'){
                $('.quntity-input'+id).val(parseInt(input) + parseInt(1));
            }
            
        })


        $(document).on('click', '.addStockmodel', function(){
            var stock = $(this).attr('data-stock');
            var id = $(this).attr('data-id');

            $('#product_id').val(id);
            $('#stock').val(stock);
            $('#add-stock').modal('show');
        })

        $(document).on('click', '.addStock', function(){
            var product_id = $('#product_id').val();
            var stock = $('#stock').val();
            $('#global-loader').show();
            if(stock){
                $('#error-msgstock').text(' ');
                $.ajax({
                    url: "{{ route('store.product.addStock') }}",
                    method: 'post',
                    data: { "_token" : "{{csrf_token()}}", 'product_id': product_id , 'stock': stock},
                    success: function(data){
                        console.log(data)
                        if(data.success == true){
                            $('#add-stock').modal('hide');
                            $('#example').DataTable().ajax.reload();
                        }
                        $('#global-loader').hide();
                    }
                });
            }else{
                $('#error-msgstock').text('Stock is required');
            }
        })

        $(document).on('click', '.addStockSave', function(){
            var product_id = $(this).attr('data-id');
            var stock = $('.quntity-input'+product_id).val();
          
            $('#global-loader').show();
            if(stock){
                $('#error-msgstock').text(' ');
                $.ajax({
                    url: "{{ route('store.product.addStock') }}",
                    method: 'post',
                    data: { "_token" : "{{csrf_token()}}", 'product_id': product_id , 'stock': stock},
                    success: function(data){
                        console.log(data)
                        if(data.success == true){
                            $('#add-stock').modal('hide');
                            $('#example').DataTable().ajax.reload();
                        }
                        $('#global-loader').hide();
                    }
                });
            }else{
                $('#error-msgstock').text('Stock is required');
            }
        })
    </script>
@endsection
