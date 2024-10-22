@extends('billpeapp.layout.app')

@section('content')

<div class="site-wrapper">
    <div class="first_nav_hero_about">
        <!-- ======== 1.1. header section ======== -->
        @include('billpeapp/layout/header')
        <!-- ======== End of 1.1. header section ========  -->
        <!-- ======== 4.1. hero section ======== -->
        <div class="container">
            <div class="pricing-hero">
                <h2 class="text-center">PRICING</h2>
                <P class="text-center">Choose the Best for your Shop.</P>
            </div>
        </div>
        <!-- ========End of 4.1. hero section ======== -->
        <!-- ========  1.9. pricing section ========  -->
        <section class="pricing pri-padd">
            <div class="container">
                <form method="post" id="packageForm">
                @csrf
                <div class="row d-flex gap-md-0 gap-sm-3 gap-2">
                    <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center pricing-bg"
                        data-aos="fade-up">
                        <div>
                            <figure><img src="{{$subscriptions[0]->image}}" alt="pric-img1" class="moving priceImagechange"></figure>
                            <figure><img src="{{url('public/billpeapp/assets/images/icon/hero_star.png')}}" alt="pric-img2"></figure>
                        </div>
                    </div>
                   
                        <input type="hidden" id="packageid" name="packageSelectID">
                        <div class="col-lg-6 col-md-6 mt-md-0 mt-sm-5 mt-5" data-aos="fade-down">
                            @foreach($subscriptions as $subscription)
                            <a href="javascript:void(0)" class="clickPrice" data-image="{{$subscription->image}}" data-id="{{$subscription->id}}">
                                <div class="pric-list">
                                    <h6>{{$subscription->name}}</h6>
                                    <div class="d-flex">
                                        <div class="d-flex justify-content-between gap-md-5 gap-sm-3 gap-3">
                                            <div class="d-flex pric-sup align-items-center">
                                                <h2>₹<?php echo round($subscription->subscription_price + $subscription->subscription_price*18/100) ?></h2>
                                                <p>/<?php echo round($subscription->subscription_price + $subscription->subscription_price*18/100) ?></p>
                                            </div>
                                            <p class="p-f-s">{{$subscription->discription}}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            <div class="text-md-start text-sm-center text-center pt-lg-4 pt-md-2 pt-sm-0 pt-1">
                                <a class="btn-hover1" href="#">Get Started</a>
                            </div>
                        </div>
                </div>
                </form>

            </div>
        </section>
        <!-- ======== End of 1.9. pricing section ========  -->

        <script>
            $('.clickPrice').click(function(){
                var id  = $(this).attr('data-id');
                $('#packageid').val(id);
                $('form#packageForm').submit();
    
                // var image  = $(this).attr('data-image');
                // $('.priceImagechange').attr('src', image);
            })
        </script>
@endsection