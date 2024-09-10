<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        
        
        <link rel="shortcut icon" href="<?php echo e(asset('public/admin/upload/1697545073-652e7b7162bf7.png')); ?>" />
        <link rel="stylesheet" href="<?php echo e(asset('public/admin/multiSelector/filter_multi_select.css')); ?>" />
    
         
        <link rel="stylesheet" href="<?php echo e(asset('public\admin\customFiles\css\custom.css')); ?>" /> 
        

        

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BillPe Billing.</title>
        <title>Thank you for Shopping.</title>
        <meta name="description" content="Thank you for Shopping.">
        <meta property="og:title" content="BillPe Billing." />
        <meta property="og:image" content="https://i0.wp.com/billpe.co.in/wp-content/uploads/2023/09/billpe-150.150.png?w=150&ssl=1" />
        <meta property="og:image:width" content="300" />
        <meta property="og:image:height" content="300" />
        <meta property="og:site_name" content="Vyapar App" />
        <meta property="og:description" content="BillPe Billing. Thank you for Shopping." />
        <meta name="yandex-verification" content="5559b59e64695360" />
        <meta name="p:domain_verify" content="a4daf9a199884bb7abe56019ffc09c32" />
        <meta charset="utf-8">
        <meta name="csrf-token" content="eBR4LlvOKKYnBEMolB4zMSbx9HjBxGtcymxWSXHS">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msvalidate.01" content="CE7B00AD9AFC15DAD1D261A43F989093" />
    
        <title>
            billpe - admin
       </title>
    
        
     
        <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendors/typicons.font/font/typicons.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('public/admin/imageDropdown/dist/css/dd.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('public/admin/vendors/css/vendor.bundle.base.css')); ?>">
       
        <link rel="stylesheet" href="<?php echo e(asset('public/admin/css/vertical-layout-light/style.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('public/admin/css/custom.css')); ?>">
       
         
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
       
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    
        
        
        <link href="<?php echo e(asset('public/admin/searchDropDown/select2.min.css')); ?>" rel="stylesheet" />
    
       
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    
        
        <link rel="stylesheet" href="<?php echo e(asset("public\admin\select2\select2.css")); ?>">
       
    
        <style>
              ::after, ::before{
                  border-color:red !important;
                }
    
                .loader,
            .loader:after {
                border-radius: 50%;
                width: 10em;
                height: 10em;
            }
            .loader {            
                margin: 60px auto;
                font-size: 10px;
                position: relative;
                text-indent: -9999em;
                z-index: 999999;
                border-top: 1.1em solid #e3e3e3;
                border-right: 1.1em solid #e3e3e3;
                border-bottom: 1.1em solid #e3e3e3;
                border-left: 1.1em solid #31855e;
                -webkit-transform: translateZ(0);
                -ms-transform: translateZ(0);
                transform: translateZ(0);
                -webkit-animation: load8 1.1s infinite linear;
                animation: load8 1.1s infinite linear;
            }
            @-webkit-keyframes load8 {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }
                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }
            @keyframes load8 {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }
                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }
            #loadingDiv {
                position:absolute;;
                top:0;
                left:0;
                width:100%;
                height:100%;
                background-color:transparent;
            }
    
          /* Multiple Select DropDwon PLugins */
          .ms-parent button span{
            top: 50%;
              left: 50%;
              transform: translate(-105%,-50%);
          }
          .ms-parent button{
            border:none !important;
            height: 18px;
          }

          /* @page {
            size: A4;
            margin: 1cm;
            } */

            @print {
                size:auto;
                size: 56mm 100mm;
                margin: 0;
            }

            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            /* body {
            margin: 0;
            padding: 0;
            } */

           
    
        </style>
        
    
    </head>
    <body>
    </div>
    <div class="row">
        <div class="col-md-3"> </div>
       
        <div class="col-md-6">
           
            <div class="max-w-xs m-auto" style="background-color: #f3f8a7">
                <div class="text-right col-12 pt-4">
                    <?php if($billHistory->customer_name && $billHistory->customer_number): ?>
                        <form action="<?php echo e(route('sharebilltowhatsapp')); ?>"  method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                            <input type="hidden" name="bill_id" value="<?php echo e($billHistory->id); ?>">
                            <input type="hidden" name="customer_name" value="<?php echo e($billHistory->customer_name); ?>">
                            <input type="hidden" name="customer_number" value="<?php echo e($billHistory->customer_number); ?>">
                            
                            <button type="submit" class="btn btn-outline-secondary btn-fw bg-blue-600 text-black  text-capitalize hidden-print">Share</button>
                            <button type="button" onclick="printPage()" class="btn btn-outline-secondary btn-fw bg-blue-600 text-black  text-capitalize hidden-print">Print</button>
                        </form>
                    <?php else: ?>
                        <button type="button" class="btn btn-outline-secondary btn-fw bg-blue-600 text-black  text-capitalize customerShare" data-bs-toggle="modal" data-bs-target="#customer">Share</button>
                        <button type="button" onclick="printPage()" class="btn btn-outline-secondary btn-fw bg-blue-600 text-black  text-capitalize hidden-print">Print</button>
                    <?php endif; ?>
                </div>
                
                <div class="text-center mb-3">
                 
                    <img src="<?php echo e($billHistory->store?->store_image ? $billHistory->store?->store_image : asset('public/admin/images/png-shop-1.png')); ?>" alt="User Image" class="rounded-lg" style="width: 50px; height: 50px" />

                    <div class="">
                        <h2 class="text-2xl font-bold text-blue-500 "><?php echo e($billHistory->store?->shop_name); ?></h2>
                        <div>
                            Address: <?php echo e($billHistory->store?->address); ?>

                        </div>
                        <div class="mt-1 d-flex justify-content-center">
                            <span>Phone</span> <span>:</span> <span><?php echo e($billHistory->store?->user->whatsapp_no); ?></span>
                        </div>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-blue-500 " style="text-align: center;">TAX INVOICE</h2>
                <div class="order-info-id text">
                   <div class="d-flex pl-4"><span><b> Invoice No. </b></span> <span>&nbsp;</span> <?php echo e($billHistory?->bill_number); ?><span></span></div>
                    <div class="font-size-sm text-body  pl-4" >
                        <span>Customer Name: 
                        </span>
                        <span class="font-weight-bold"> <?php echo e($billHistory->customer_name); ?></span>
                    </div>
                    <div class="font-size-sm text-body pl-4"  >
                        <span>Customer Phone :
                        </span>
                        <span class="font-weight-bold"><?php echo e($billHistory->customer_number); ?></span>
                    </div>
                    <div class="pl-4">
                        Date and Time: <?php echo e($billHistory->created_at->format('d/m/y h:i ')); ?>

                        <?php if($billHistory->token): ?>
                        <span style="    float: right;margin-right: 40px;">Token No:<?php echo e($billHistory->token->token_no); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
               

                <hr class="pt-2 pb-0">
              
                    <table class="table invoice--table text-black ">
                        <thead class="border-0">
                            <tr class="border-0">
                                <th class=" px-4 py-2 text-left text-body  pl-5">Items</th>
                                <th class="text-center px-4 py-2">Price</th>
                                <th class="text-center px-4 py-2">Qtn</th>
                                <th class="text-center px-4 py-2">Discount</th>
                                <th class="text-center px-4 py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $totaldiscount=0;
                            ?>
                           
                            <?php $__currentLoopData = json_decode($billHistory->product_detail); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                
                                <td class="text-left font-bold px-0 py-0 text-break text-body  pl-5">
                                    <?php echo e($item->product_name); ?>

                                </td>
                                <td class="text-center px-2 py-1">
                                    ₹ <?php echo e($item->price); ?> 
                                </td>
                                <td class="text-center px-2 py-1">
                                    <?php echo e($item->qtn); ?>  
                                </td>
                                <td class="text-center px-2 py-1">
                                    ₹ <?php echo e($item->discount); ?> 
                                </td>
                                <td class="text-center px-2 py-1">
                                    ₹ <?php echo e($item->total_amount); ?> 
                                </td>
                               
                                <?php
                                 $totaldiscount=$totaldiscount+$item->discount;
                                ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
                        </tbody>
                       
                    </table>
                       
                    <div class="checkout--info">
                       
                        
                        
                        <dl class="row text-right">
                            <dt class="col-6 text-left">Extra Discount:</dt>
                            <dd class="col-6 text-center">
                                ₹ <?php echo e($billHistory->discount); ?>

                            </dd>
                          
                            <dt class="col-6 total text-left">Total Paid Amount:</dt>
                            <dd class="col-6 total text-center font-bold text-green-700 text-lg">
                                ₹ <?php echo e($billHistory->total_amount); ?>

                            </dd>
                            <dt class="col-6 total text-left">Items:</dt>
                            <dd class="col-6 total text-center font-bold text-green-700 text-lg">
                                <?php echo e(count(json_decode($billHistory->product_detail))); ?>

                            </dd>
                        </dl>
                    </div>

                    <hr class="pt-2 pb-0">
              
                <div class="top-info mt-1">
                    
                    <b style="margin-left: 260px;">You Have Saved: <?php echo e($totaldiscount+$billHistory->discount); ?></b>
                    <div class=" text-center my-2">Thanks You! Visit Again</div>
                   
                </div>
                <br>
                <!-- <div class="copyright text-center font-bold text-blue-500 pb-4">
                    ©
                    Powered by BillPe @2023
                </div> -->
            </div>    
        </div>
        <div class="col-md-3"> </div>
    </div>



    <!-- Add Customer -->
    <div class="modal fade" id="customersharebill">
        <div class="modal-dialog modal-dialog-centered custom-modal-two">
            <div class="modal-content">
            <form action="<?php echo e(route('sharebilltowhatsapp')); ?>"  method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Customer Detail</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <input type="hidden" name="bill_id" value="<?php echo e($billHistory->id); ?>">
                        <div class="modal-body custom-modal-body">
                            <div class="mb-3">
                                <label class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                <span id="error-msgCustomername" style="color:red;"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Customer Number</label>
                                <input type="number" class="form-control" id="customer_number" name="customer_number" required>
                                <span id="error-msgCustomerNumber" style="color:red;"></span>
                            </div>
                            <div class="modal-footer-btn">
                                <!-- <a href="javascript:void(0);" class="btn btn-cancel me-2 close"
                                    data-bs-dismiss="modal">Cancel</a>
                                <a type="submit" href="javascript:void(0);" class="btn btn-submit">Submit</a> -->
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- Add Customer -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
     <!-- Include Popper.js (required for Bootstrap) -->
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <!-- Include Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

   <script>
    //    window.print();
   </script>
   <script>
    function printPage() {
      // Apply the print styles
      var link = document.createElement('link');
      link.rel = 'stylesheet';
      link.type = 'text/css';
      link.href = 'path/to/print.css';
      document.head.appendChild(link);
    
      // Trigger the print dialog
      window.print();
    
      // Remove the added link element to avoid affecting the screen view
      document.head.removeChild(link);


    //   var divcontent = document.getElementById("mybilldata").innerHTML;
    //   var a = window.open('', '');
    //   a.document.write('<html><title>Billpe Pos</title>');
    //   a.document.write('<body style="font-family: fangsong;">');
    //   a.document.write(divcontent);
    //   a.document.write('</body></html>');
    //   a.document.close();
    //   a.print();
    }

    $('.customerShare').click(function(){
        $('#customersharebill').modal('show');
    })

    $('.close').click(function(){
        $('#customersharebill').modal('hide');
    })
    </script>
          
        
    </body>
</html>



<?php /**PATH /home4/billp5kj/public_html/resources/views/invoice.blade.php ENDPATH**/ ?>