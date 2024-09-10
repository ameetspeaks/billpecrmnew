<?php $page = 'product-list'; ?>
@extends('store.storeAdmin.layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            @component('store.storeAdmin.components.breadcrumb')
                @slot('title')
                    Product List
                @endslot
                @slot('li_1')
                    Manage your products
                @endslot
                @slot('li_2')
                    {{ route('store.add-product') }}
                @endslot
                @slot('li_3')
                    Add New Product
                @endslot
            @endcomponent

            <!-- <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Product List</h4>
                        <h6>Manage your products</h6>
                    </div>
                </div>
            </div> -->

            @include('store.storeAdmin.layout.partials.session')

           

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                 
                    <div class="table-responsive product-list">
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- <th class="no-sort">
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th> -->
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Store</th>
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
            ajax: "{{ route('store.product.getDatatable') }}",
            
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

    
    // Select file for Import Excel file

    $('#productExcelBtn').click(function(){
            $("#productExcel").click();
    });

    $("#productExcel").change(function(){
            $("#importFileForm").submit();
    });

    $("#importFileForm").submit(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = document.importFileForm;
        console.log(form);
        var formData = new FormData(form);
        var url = '{{route('store.product.uploadProductExcel')}}';
        $("#hideSpinner").show();
        $.ajax({
            type: 'POST',
            url: url,
            processData: false,
            contentType: false,
            dataType: 'json',
            data: formData,
            dataSrc: "",
            complete: function(data)
            {
                $("#hideSpinner").hide();
                $("#importFileForm").trigger('reset');
                $('#showExportError').empty();
            },
            success: function(data)
            {
                console.log("yes");
                console.log(data);
                if(data.status==0){
                    $(".errmsg_productExcel").text(data.error1.productExcel[0]);
                }else if(data.status==1){
                    $(".errmsg_productExcel").text("");
                    $(".successmsg_productExcel").text(data.success);
                    $('.table').DataTable().ajax.reload();
                }else{
                    $(".errmsg_productExcel").text(data.error);
                }

            },error:function(error){
                console.log("no");
                console.log(error);
                console.log(error.responseJSON);
                if(error.responseJSON.errors!=undefined){
                    $(".errmsg_productExcel").text(error.responseJSON.errors[0][0]);
                }else{

                    $(".errmsg_productExcel").text(error.statusText);

                }

                $(".successmsg_productExcel").text("");

            }

        }); //End Ajax

    }) //End Submit Form

    $("#exportFileForm").submit(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        alert("ll")
        var form = document.importFileForm;
        console.log(form);
        var formData = new FormData(form);
        var url = '{{route('store.product.uploadProductExcel')}}';
        $("#hideSpinner").show();
        $.ajax({
            type: 'POST',
            url: url,
            processData: false,
            contentType: false,
            dataType: 'json',
            data: formData,
            dataSrc: "",
            complete: function(data)
            {
                $("#hideSpinner").hide();
                $("#importFileForm").trigger('reset');
                $('#showExportError').empty();
            },
            success: function(data)
            {
                console.log("yes");
                console.log(data);
                if(data.status==0){
                    $(".errmsg_productExcel").text(data.error1.productExcel[0]);
                }else if(data.status==1){
                    $(".errmsg_productExcel").text("");
                    $(".successmsg_productExcel").text(data.success);
                    $('.table').DataTable().ajax.reload();
                }else{
                    $(".errmsg_productExcel").text(data.error);
                }

            },error:function(error){
                console.log("no");
                console.log(error);
                console.log(error.responseJSON);
                if(error.responseJSON.errors!=undefined){
                    $(".errmsg_productExcel").text(error.responseJSON.errors[0][0]);
                }else{

                    $(".errmsg_productExcel").text(error.statusText);

                }

                $(".successmsg_productExcel").text("");

            }

        }); //End Ajax

    }) //End Submit Form
 
</script>
@endsection
