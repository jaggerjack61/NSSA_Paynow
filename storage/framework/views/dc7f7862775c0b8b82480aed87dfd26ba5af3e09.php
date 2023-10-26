<html>
    <head>
        <title>
            <?php echo $__env->yieldContent('title'); ?>
        </title>

        <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">

        <link rel="stylesheet" href="assets/css/meyawo.css">
    </head>
    <body>
    <nav class="navbar navbar-expand-sm navbar-light bg-light rounded shadow mb-3">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('dashboard')); ?>">Bureau of Records</a>
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('registrations')); ?>">Registrations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('show-cards')); ?>">Portal Registrations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('reports')); ?>">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('show-messages')); ?>">Contact Us Messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('settings')); ?>">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('logout')); ?>">Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <?php if(session()->has('error')): ?>

        <div class="alert alert-danger alert-dismissible" role="alert">
            <?php echo e(session()->get('error')); ?>


        </div>


    <?php elseif(session()->has('success')): ?>


        <div class="alert alert-success alert-dismissible" role="alert">
            <?php echo e(session()->get('success')); ?>


        </div>

    <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>

        <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
        <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>


        <script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>


        <script src="assets/js/meyawo.js"></script>
    </body>
</html>
<?php /**PATH C:\Users\LENOVO\Documents\github\NSSA_Paynow\resources\views/layouts/base.blade.php ENDPATH**/ ?>