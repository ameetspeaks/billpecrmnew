<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Cashfree Checkout Integration</title>

    </head>

    <body>

        <!-- <input type="hidden" id="sessionid" value="{{$cashfree_Payment->payment_session_id}}">

        <div class="row">

            <p>Click below to open the checkout page in current tab</p>

            <button id="renderBtn">Pay Now</button>

        </div> -->



        <!-- jQuery -->

        <script src="{{ asset('build/js/jquery-3.7.1.min.js') }}"></script>



        <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>



        <script>

            $(document).ready(function(){

                const cashfree = Cashfree({

                    // mode: "sandbox",

                    mode: "production",

                });

                var data = @json($cashfree_Payment);

                let checkoutOptions = {

                    paymentSessionId:data.payment_session_id,

                    redirectTarget: "_self",

                };

                cashfree.checkout(checkoutOptions);

            });



            // document.getElementById("renderBtn").addEventListener("click", () => {

            //     var sessionid = $('#sessionid').val();

            //     alert(sessionid)

            //     let checkoutOptions = {

            //         paymentSessionId:sessionid,

            //         redirectTarget: "_self",

            //     };

            //     cashfree.checkout(checkoutOptions);

            // });

        </script>

    </body>

</html>
