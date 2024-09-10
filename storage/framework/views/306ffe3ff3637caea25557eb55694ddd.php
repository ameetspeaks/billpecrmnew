<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> Order <?php $__env->endSlot(); ?>
<?php $__env->slot('subTitle'); ?> Order Detail <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    .container {
        display: flex;
        max-width: 1200px;
        margin: 40px auto;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Column A Styling */
    .column-a {
        width: 70%;
        padding: 20px;
        border-right: 1px solid #ddd;
    }

    .column-b {
        width: 30%;
        padding: 20px;
    }

    /* Order Header */
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .order-number {
        font-size: 22px;
        font-weight: bold;
    }

    .order-header button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    /* Order Details */
    .order-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .order-details p {
        margin: 5px 0;
        color: #555;
    }

    /* Table Styling */
    .items table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .items table th, .items table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    .items table th {
        background-color: #f7f7f7;
    }

    /* Totals Section */
    .totals {
        margin-top: 20px;
    }

    .totals-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
    }

    .totals-row strong {
        font-weight: bold;
    }

    .totals-row:last-child {
        font-size: 18px;
        font-weight: bold;
    }

    /* Column B Styling */
    .section {
        margin-bottom: 30px;
    }

    .section h3 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #333;
    }

    .info p {
        margin: 5px 0;
        color: #555;
    }

    .dropdown {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .section .assign-hero {
        display: flex;
        flex-direction: column;
    }

    /* General Styling */
    h3 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    p {
        color: #666;
        margin-bottom: 10px;
    }
</style>

<div class="text-right col-12">
    
    
</div>

<div class="text-right col-12">
 <span class="text-xs text-red-500 mt-2 errmsg_productExcel"></span>
 <div>
    <ul id="showExportError">
        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="text-danger"><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </ul>
 </div>
</div>

<div class="text-right col-12">
    <span class="text-xs text-green-500 mt-2 successmsg_productExcel"></span>
</div>


<div class="container">
    <!-- Column A -->
    <div class="column-a">
        <!-- Order Header -->
        <div class="order-header">
            <div class="order-number">Order #<?php echo e($order->order_number); ?></div>
            <button>Print Invoice</button>
        </div>


        <!-- Order Information -->
        <div class="order-details">
            <div>
                <p><strong>Date:</strong> <?php echo e($order->created_at); ?></p>
                <p><strong>Store Name:</strong> <?php echo e($order->store->shop_name); ?> </p>
            </div>
            <div>
                <p><strong>Status:</strong> <?php echo e($order->orderStatus->name); ?> </p>
                <p><strong>Payment Method:</strong> <?php echo e($order->payment_mode); ?> </p>
                <p><strong>Payment Status:</strong> Paid</p>
            </div>
        </div>

        <!-- Items Table -->
        <h3>Items Details</h3>
        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Price (₹)</th>
                        <th>Quantity</th>
                        <th>Total Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $products = json_decode($order->product_details);
                        $charges = json_decode($order->any_other_fee);
                    ?>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($product->product_name); ?></td>
                        <td><?php echo e($product->price); ?></td>
                        <td><?php echo e($product->qtn); ?></td>
                        <td><?php echo e($product->total_amount); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="totals">
            <div class="totals-row">
                <span>Subtotal</span>
                <span>₹<?php echo e($order->amount); ?></span>
            </div>
            <div class="totals-row">
                <span>Coupon Discount</span>
                <span>- ₹<?php echo e($order->coupan_amount); ?></span>
            </div>
            <?php $__currentLoopData = $charges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $charge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="totals-row">
                    <span><?php echo e($charge->name); ?></span>
                    <span>₹<?php echo e($charge->amount); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="totals-row">
                <span>Tip</span>
                <span>₹<?php echo e($order->tip); ?></span>
            </div>
            <div class="totals-row">
                <strong>Grand Total</strong>
                <strong>₹<?php echo e($order->total_amount); ?></strong>
            </div>
        </div>
    </div>

    <!-- Column B -->
    <div class="column-b">
        <!-- Order Status Section -->
        <div class="section">
            <h3>Order Status</h3>
            <select class="dropdown form-control orderStatusChange">
                <?php $__currentLoopData = $orderStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderStatu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($orderStatu->id); ?>" <?php echo e($order->order_status == $orderStatu->id ? 'selected' : ''); ?>><?php echo e($orderStatu->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        
        <?php if($order->deliveryboy_id): ?>
            <div class="section">
                <h3>Delivery Boy Information<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#assignDeliveryBoy">Change</button></h3>
                <p><strong>Name:</strong> <?php echo e($order->delivery_boy->name); ?> </p>
                <p><strong>Email:</strong> +91-<?php echo e($order->delivery_boy->email); ?></p>
                <p><strong>Mobile No:</strong> +91-<?php echo e($order->delivery_boy->whatsapp_no); ?></p>
            </div>
        <?php else: ?>
            <div class="section">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#assignDeliveryBoy">Assign to delivery boy</button>
            </div>
        <?php endif; ?>

        <!-- Customer Info Section -->
        <div class="section">
            <h3>Customer Information</h3>
            <p><strong>Name:</strong> <?php echo e($order->customer->name); ?> </p>
            <p><strong>Mobile No:</strong> +91-<?php echo e($order->customer->whatsapp_no); ?></p>
            <p><strong>Total Orders:</strong> <?php echo e($order->customer->order_count); ?></p>
            <?php if($order->address): ?>
            <p><strong>Address:</strong> <?php echo e($order->address->address); ?> , <?php echo e($order->address->city); ?> , <?php echo e($order->address->state); ?> , <?php echo e($order->address->country); ?> </p>
            <?php endif; ?>
        </div>

        <!-- Store Info Section -->
        <div class="section">
            <h3>Store Information</h3>
            <p><strong>Name:</strong> <?php echo e($order->store->shop_name); ?> </p>
            <p><strong>Mobile No:</strong> +91-<?php echo e($order->store->user->whatsapp_no); ?> </p>
            <p><strong>Total Orders:</strong> <?php echo e($order->store->customer_orders_count); ?> </p>
            <p><strong>Address:</strong> <?php echo e($order->store->address); ?>  <?php echo e($order->store->pincode); ?> , <?php echo e($order->store->city); ?>  </p>
        </div>
    </div>
</div>


<!-- Modal Assign To Delivered -->
<div class="modal fade" id="assignDeliveryBoy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Assign Delivery Boy</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="row forms-sample w-full" action="<?php echo e(route('admin.order.assignOrderToDeliveryBoy')); ?>" name="moduleData" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="order_id" id="order_id" value="<?php echo e($order->id); ?>">

                <div class="form-group col-md-6 col-12 err_module">
                    <label style="font-weight:bold">Assign Delivery Boy</label>
                    <select class="form-control h-11 cursor-pointer module select" id="agent_id" name="agent_id" required>
                        <option value="">Select Delivery Boy</option>
                        <?php $__currentLoopData = $deliveryAgents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deliveryAgent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($deliveryAgent->id); ?>" <?php echo e($order->deliveryboy_id == $deliveryAgent->id ? 'selected' : ''); ?>><?php echo e($deliveryAgent->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="text-xs text-red-500 mt-2 errmsg_module"></span>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<?php $__env->endSlot(); ?>
<?php $__env->slot('script'); ?>
<script>

    //change order status
    $(document).on('change', '.orderStatusChange', function(){
        var id = $('#order_id').val();
        var order_id = $('.orderStatusChange').val();

        Swal.fire({
            title: "Are you sure?",
            text: "You want to change order status!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, status updated!"
            }).then(function(result) {
            if(result.value){

                $.ajax({
                    url: "<?php echo e(route('admin.order.orderStatusChange')); ?>",
                    method: 'post',
                    data: { "_token" : "<?php echo e(csrf_token()); ?>", 'id': id , 'order_id': order_id},
                    success: function(data)
                    {
                        if(data.status == false){
                            Swal.fire(data.title,data.message,data.type);
                        }
                        Swal.fire(
                            "Status!",
                            "Status updated successfully.",
                            "success"
                        ).then(function() {
                            location.reload();
                        });
                    }
                });

            }else{
                location.reload();
            }
        });
    })

</script>
<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/order/viewOrder.blade.php ENDPATH**/ ?>