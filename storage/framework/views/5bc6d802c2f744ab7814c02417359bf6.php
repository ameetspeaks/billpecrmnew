<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BillPe Billing.</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .container {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .container img {
            max-width: 100%;
            height: 230px;
            width:350px;
        }
        .upgrade-btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        .upgrade-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="<?php echo e($storePackage->image); ?>" alt="Plan Expired Image">
        <h2><?php echo e($storePackage->name); ?></h2>
        <p>Please Upgrade</p>
        <a href="<?php echo e(route('pricing')); ?>" class="upgrade-btn">Upgrade</a>
    </div>

    <script>
        // Replace 'Plan Name' with the actual plan name dynamically if needed
        document.getElementById('plan-name').innerText = 'Your Plan Name Here';
    </script>
</body>
</html><?php /**PATH /home4/billp5kj/public_html/resources/views/billpeapp/subscriptionExpire.blade.php ENDPATH**/ ?>