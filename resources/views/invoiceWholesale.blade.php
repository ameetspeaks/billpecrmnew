<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
        {{-- Fav Icon --}}
        <link rel="shortcut icon" href="{{ asset('public/admin/upload/1697545073-652e7b7162bf7.png') }}" />
        <link rel="stylesheet" href="{{ asset('public/admin/multiSelector/filter_multi_select.css') }}" />
    
        {{-- My Custom Files --}} 
        <link rel="stylesheet" href="{{ asset('public\admin\customFiles\css\custom.css') }}" /> 
        {{-- END:: My Custom Files --}}

        {{-- <meta property="og:title" content="Bill Pay" />
        <meta property="og:description" content="Description of your page." />
        <meta property="og:image" content="https://assetsblog.bsbportal.com/wp-content/uploads/2023/10/ICC-Cricket-World-Cup-2023-India-vs-Pakistan-Ahmedabad.jpg" />
        <meta property="og:url" content="https://admin.billpe.co.in/invoice" /> --}}

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
    
        
     
        <link rel="stylesheet" href="{{ asset('public/admin/vendors/typicons.font/font/typicons.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/imageDropdown/dist/css/dd.css')}}">
        <link rel="stylesheet" href="{{ asset('public/admin/vendors/css/vendor.bundle.base.css') }}">
       
        <link rel="stylesheet" href="{{ asset('public/admin/css/vertical-layout-light/style.css') }}">
        <link rel="stylesheet" href="{{ asset('public/admin/css/custom.css') }}">
       
         
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
       
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    
        
        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
        <link href="{{ asset('public/admin/searchDropDown/select2.min.css') }}" rel="stylesheet" />
    
       
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    
        {{-- Multiple selector --}}
        <link rel="stylesheet" href="{{asset("public\admin\select2\select2.css")}}">
       
    
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
          @page {
            size: A4;
            margin: 1cm;
            }

            body {
            margin: 0;
            padding: 0;
            }

           
    
        </style>
        
    
    </head>
    <body>
    </div>
    <div class="row">
        <div class="col-md-3"> </div>
       
        <div class="col-md-6">
           
            <div class="max-w-xs m-auto" style="background-color: #f3f8a7">
                <div class="text-right col-12 pt-4">
                    <button type="button" onclick="printPage()" class="btn btn-outline-secondary btn-fw bg-blue-600 text-black  text-capitalize">Print</button>
                </div>
                <div class="text-center mb-3">
                 
                    <img src="{{ $wholesalebillHistory->store?->store_image ? $wholesalebillHistory->store?->store_image : asset('public/admin/images/png-shop-1.png') }}" alt="User Image" class="rounded-lg" style="width: 50px; height: 50px" />

                    <div class="">
                        <h2 class="text-2xl font-bold text-blue-500 ">{{$wholesalebillHistory->store?->shop_name}}</h2>
                        <div>
                            Address: {{$wholesalebillHistory->store?->address}}
                        </div>
                        <div class="mt-1 d-flex justify-content-center">
                            <span>Phone</span> <span>:</span> <span>{{$wholesalebillHistory->store?->user->whatsapp_no}}</span>
                        </div>
                    </div>
                </div>

                <div class="order-info-id text">
                   <div class="d-flex pl-4"><span><b> Bill No. </b></span> <span>&nbsp;</span> {{$wholesalebillHistory?->id}}<span></span></div>
                    <div class="font-size-sm text-body  pl-4" >
                        <span>Name: 
                        </span>
                        <span class="font-weight-bold"> {{$wholesalebillHistory->wholeseller_name}}</span>
                    </div>
                    <div class="font-size-sm text-body pl-4"  >
                        <span>Phone :
                        </span>
                        <span class="font-weight-bold">{{$wholesalebillHistory->wholeseller_number}}</span>
                    </div>
                    <div class="pl-4">
                        Date and Time: {{$wholesalebillHistory->created_at->format('d/m/y h:i ')}}
                    </div>
                </div>
               

                <hr class="pt-2 pb-0">
              
                    <table class="table invoice--table text-black ">
                        <thead class="border-0">
                            <tr class="border-0">
                                <th class=" px-4 py-2 text-left text-body  pl-5">Items</th>
                                <th class="text-center px-4 py-2">Qtn</th>
                                <th class="text-center px-4 py-2">Price</th>
                                <th class="text-center px-4 py-2">Value</th>
                                {{-- <th class="text-center px-4 py-2">Total</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sub_total=0;
                            @endphp
                           
                            @foreach (json_decode($wholesalebillHistory->product_detail) as $item)
                            <tr>
                                
                                <td class="text-left font-bold px-0 py-0 text-break text-body  pl-5">
                                    {{$item->product_name}}
                                </td>
                                
                                <td class="text-center px-2 py-1">
                                    {{$item->qtn}}  
                                </td>
                                <td class="text-center px-2 py-1">
                                    ₹ {{$item->price}} 
                                </td>
                                <td class="text-center px-2 py-1">
                                    ₹ {{(int)$item->qtn*(int)$item->price}} 
                                </td>
                                {{-- <td class="text-center font-bold px-0 py-0">
                                    
                                    ₹ {{(int)$item->qtn*(int)$item->price}}
                                </td> --}}
                                @php
                                 $sub_total=(int)$sub_total+(int)$item->qtn*(int)$item->price;
                                @endphp
                            </tr>
                            @endforeach
        
                        </tbody>
                       
                    </table>
                       
                    <div class="checkout--info">
                       
                        
                        {{-- <dl class="row text-right">
                            <dt class="col-6 text-left">Sub Total
                                (TAX Included)
                                :</dt>
                            <dd class="col-6 text-center">
                                  ₹ {{$sub_total}}</dd></dd>
                            <dt class="col-6  text-left">Discount:</dt>
                            <dd class="col-6  text-center">
                                + ₹  {{$wholesalebillHistory->discount}}
                            </dd>
                          
                            <dt class="col-6 total text-left">Total:</dt>
                            <dd class="col-6 total text-center font-bold text-green-700 text-lg">
                                {{(int)$sub_total-(int)$wholesalebillHistory->discount}}</dd>
                        </dl> --}}
                        <dl class="row text-right">
                            <dt class="col-6 text-left">Sub Total:</dt>
                            <dd class="col-6 text-center">
                                ₹ {{$sub_total}}
                            </dd>
                            <dt class="col-6 text-left">Total item MRP:</dt>
                            <dd class="col-6 text-center">
                                ₹ {{$sub_total+(int)$wholesalebillHistory->discount}}
                            </dd>

                            <dt class="col-6  text-left">Discount:</dt>
                            <dd class="col-6  text-center">
                                -  {{$wholesalebillHistory->discount}}
                            </dd>
                          
                            <dt class="col-6 total text-left">Total Paid Amount:</dt>
                            <dd class="col-6 total text-center font-bold text-green-700 text-lg">
                                ₹ {{(int)$sub_total}}</dd>
                        </dl>
                    </div>

                    <hr class="pt-2 pb-0">
              
                <div class="top-info mt-1">
                    {{-- <img src="https://admin.shrimatiji.store/public/assets/admin/img/invoice-star.png" alt=""
                        class="w-100"> --}}
                    <div class=" text-center my-2">Thanks You! Visit Again</div>
                   
                </div>
                <br>
                <div class="copyright text-center font-bold text-blue-500 pb-4">
                    ©
                    Powered by BillPe @2023
                </div>
            </div>    
        </div>
        <div class="col-md-3"> </div>
    </div>
    
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
    }
    </script>
          
        
    </body>
</html>



