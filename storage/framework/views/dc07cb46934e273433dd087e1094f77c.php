
<?php $__env->startSection('content'); ?> 

<style>
    #order_stats img{
        display: inline-flex !important;
    }
</style>
    <link rel="stylesheet" href="<?php echo e(asset('public\extra\css\desgin.css')); ?>">
    <div class="container">
       
        <div class="row " id="order_stats" style="row-gap: 30px;">
            <div class="col-sm-6 col-lg-3">
                <div class="__dashboard-card-2">
                    <img src="<?php echo e(asset('public/admin/images/store.png')); ?>"
                    alt="dashboard/pharmacy">
                    <h6 class="name">Total number of stores :</h6>
                    <a href="<?php echo e(route('admin.storeDetails')); ?>"> <h3 class="count"> <?php echo e($store); ?></h3></a>
                    <div class="subtxt"><b><?php echo e($storeCountToday); ?></b> Today Newly added Store</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="__dashboard-card-2">
                    <img src="<?php echo e(asset('public/admin/images/transaction-history.png')); ?>"
                        alt="dashboard/pharmacy">
                    <h6 class="name">Total Bill History :</h6>
                    <h3 class="count"><?php echo e($bill); ?></h3>
                    <div class="subtxt"><b><?php echo e($billCountToday); ?></b> Today Bill Generate History</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="__dashboard-card-2">
                    <img src="<?php echo e(asset('public/admin/images/money-bag.png')); ?>"
                      alt="dashboard/pharmacy">
                    <h6 class="name">Total Amount :</h6>
                    <a href="<?php echo e(route('admin.totalbilldetail')); ?>"><h3 class="count">₹<?php echo e($totalAmount); ?></h3></a>
                    <div class="subtxt"><b>₹<?php echo e($totalAmountToday); ?></b> Today Total Amount</div>
                </div>
            </div>   
            <div class="col-sm-6 col-lg-3">
                <div class="__dashboard-card-2">
                    <img src="<?php echo e(asset('public/admin/images/people.png')); ?>"
                    alt="dashboard/pharmacy">
                    <h6 class="name">Customers</h6>
                    <h3 class="count"><?php echo e($totalCustomer); ?></h3>
                    <div class="subtxt"><b><?php echo e($totalUniqueCustomers); ?></b> Today added Customer</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="__dashboard-card-2">
                    <img src="<?php echo e(asset('public/admin/images/document.png')); ?>"
                    alt="dashboard/pharmacy">
                    <h6 class="name">Paid Users</h6>
                    <a href="<?php echo e(route('admin.totalPaidUser')); ?>"><h3 class="count"><?php echo e($paidPackageCounts); ?></h3></a>
                    <div class="subtxt"><b><?php echo e($todayPaidPackageCount); ?></b> Today Paid Users</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="__dashboard-card-2">
                    <img src="<?php echo e(asset('public/admin/images/jury.png')); ?>"
                    alt="dashboard/pharmacy">
                    <h6 class="name">Trial Users</h6>
                    <a href="<?php echo e(route('admin.viewTrialUser')); ?>"><h3 class="count"><?php echo e($trialPackage); ?></h3></a>
                    <div class="subtxt"><b><?php echo e($todayTrailPackage); ?></b> Today Trial Users</div>
                </div>
            </div>

            <div class="col-md-6 col-xl-6 col-lg-6  col-12">
                <div class="card h-100" id="top-selling-foods-view">
                    <div class="card-header">
                        Top Selling Items
                    </div>
                    <div class="card-body">
                        <div class="top--selling">
                            <?php $__currentLoopData = $topSoldItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemName => $soldCount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="grid--card" href="#">
                                    <img class="initial--28"
                                        src="<?php echo e($itemImages[$itemName] ?? 'https://admin.shrimatiji.store/public/assets/admin/img/placeholder-2.png'); ?>"
                                        onerror="this.src='<?php echo e(asset('public/admin/images/default_image.png')); ?>'"
                                        alt="<?php echo e($itemName); ?> image">
                                        <div class="cont pt-2">
                                            <span class="fz--13"><?php echo e(ucfirst(strtolower($itemName))); ?></span>
                                        </div>
                                        
                                    <div class="ml-auto">
                                        <span class="badge badge-soft">
                                            Sold : <?php echo e($soldCount); ?>

                                        </span>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-6 col-lg-6 col-12">
                <div class="card h-100" id="top-selling-stores-view">
                    <div class="card-header">
                        Top Stores selling
                    </div>
                    <div class="card-body">
                        <?php if(count($topSellingStores) > 0): ?>
                            <div class="top--selling">
                                <?php $__currentLoopData = $topSellingStores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="grid--card" href="#">
                                        <div class="cont pt-2">
                                            <span class="fz--13"><?php echo e($store->shop_name); ?></span>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="badge badge-soft">
                                                Bill History Count: <?php echo e($store->billHistory->count()); ?>

                                            </span>
                                        </div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p>No sales data available for the top-selling stores.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div> 
           
            <div class="col-md-6 col-xl-6 col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        Sales Overview
                    </div>
                    <div class="card-body">
                        <!-- Sales chart -->
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-6 col-lg-6 col-12">
                <div class="card">
                    <div class="card-header">
                        Orders Overview
                    </div>
                    <div class="card-body">
                        <!-- Orders chart -->
                        <canvas id="billCountChart"></canvas>
                    </div>
                </div>
            </div>   
        </div>
    </div>

    <!-- Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>

   
    <script>
        var salesCanvas = document.getElementById("salesChart");
        var salesChart = new Chart(salesCanvas, {
            type: "bar",
            data: {
                labels: <?php echo json_encode($dataBillChart->pluck('month'), 15, 512) ?>,
                datasets: [
                    {
                        label: "Total Amount",
                        data: <?php echo json_encode($dataBillChart->pluck('total'), 15, 512) ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Background color
                        borderColor: 'rgba(75, 192, 192, 1)',      // Border color
                        borderWidth: 1,                            // Border width
                    },
                ],
            },
            options: {
                responsive: true,
            },
        });
    </script>
    <script>
        var billCountCanvas = document.getElementById("billCountChart");
        var billCountChart = new Chart(billCountCanvas, {
            type: "bar",
            data: {
                labels: <?php echo json_encode($chartData->pluck('label'), 15, 512) ?>,
                datasets: [
                    {
                        label: "Bill Count",
                        data: <?php echo json_encode($chartData->pluck('total'), 15, 512) ?>,
                        backgroundColor: 'rgba(255, 182, 193, 0.5)', // Light pink color
                        borderColor: 'rgba(255, 182, 193, 1)',      // Light pink color
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
            },
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home4/billp5kj/public_html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>