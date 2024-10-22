@extends('billpeapp.layout.app')

@section('content')

<div class="first_nav_hero_about">
    <!-- ======== 1.1. header section ======== -->
    @include('billpeapp/layout/header')
    <!-- ======== End of 1.1. header section ========  -->
    <!-- ======== 8.1. question section ========  -->
    <div class="container">
        <div class="ques-top-text" >
            <h2>QUESTIONS</h2>
            <p>Simplyfying Billing</p>
        </div>
        <div class="question-page">
            <h4>HOW TO USE?</h4>
            <p  class="page-p">Billing is so simple Just in 2 Clicks.</p>
            <div class="question-collapes" data-aos="zoom-in">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h5 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                How do I create a new bill?
                            </button>
                        </h5>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p> To create a new bill, simply open the BillPe app and navigate to the "New Bill" section. Enter the required details such as customer information, items purchased, and the amount. Finally, click on the "Save" button to create the bill.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h5 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                How do I send bills to customers?
                            </button>
                        </h5>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p> You can send bills to customers via WhatsApp from the BillPe app. After creating a bill, select the "Send" option and directly sendto customer WhatsApp.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h5 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                                Is it possible to track bill payments?
                            </button>
                        </h5>
                        <div id="collapseThree" class="accordion-collapse collapse"
                            aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p> Yes, you can track bill payments in the BillPe App. The app provides a report dashboard where you can view the status of each bill, including paid and pending bills.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h5 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false"
                                aria-controls="collapseFour">
                                How can I contact with support?
                            </button>
                        </h5>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p>We have one click Support in APP. Click on Support in Profile and Chat with Support Team anytime.</p>
                            </div>
                        </div>
                    </div>                                                                              
                </div>
            </div>
        </div>

        <div class="accordian-2nd">
        <h4 class="mt-lg-5 mt-md-3 mt-sm-1 mt-1">FREE CHARGES AND FEATURES</h4>
        <p  class="page-p">100% Transparency 200% TRUST</p>
        <div class="accordion1"  data-aos="zoom-in">
            <div class="accordion-item1">
                <div class="accordion-header1">
                <h6>  Is there a free trial available for the App/Desktop version?</h6>
                <div class="accordion-toggle1 accordion-toggle-img active"></div>
                </div>
                <div class="accordion-content">
                <p>Yes, BillPe offers a free trial for the APP/desktop version. You can try out the premium features for a limited period before deciding to subscribe. </p>
                </div>
            </div>
            
            <div class="accordion-item1">
                <div class="accordion-header1">
                    <h6> What are the different subscription plans offered by BillPe?</h6>
                <div class="accordion-toggle1 accordion-toggle-img"></div>
                </div>
                <div class="accordion-content">
                <p>BillPe offers two subscription plans. The basic plan starts from ₹499 per year and includes features such as billing and stock management. The desktop version is priced at ₹1999 per year and includes premium features like lending management, marketing tools, and free premium access.</p>
                </div>
            </div>
            
            <div class="accordion-item1">
                <div class="accordion-header1">
                <h6>  Are there any discounts available for long-term subscriptions?</h6>
                <div class="accordion-toggle1 accordion-toggle-img"></div>
                </div>
                <div class="accordion-content">
                <p>Yes, BillPe offers discounts for long-term subscriptions. The longer the subscription period, the greater the discount you can avail.</p>
                </div>
            </div>

            <div class="accordion-item1">
                <div class="accordion-header1">
                <h6>  Can I cancel my subscription at any time?</h6>
                <div class="accordion-toggle1 accordion-toggle-img"></div>
                </div>
                <div class="accordion-content">
                <p>Yes, you can cancel your subscription at any time. However, please note that subscription fees are non-refundable.</p>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- ======== End of 8.1. question section ========-->
</div>

@endsection