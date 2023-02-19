<?php $__env->startSection('title'); ?>
    Cards
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session()->has('error')): ?>

        <div class="alert alert-danger alert-dismissible" role="alert">
            <?php echo e(session()->get('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
        </div>


    <?php elseif(session()->has('success')): ?>


        <div class="alert alert-success alert-dismissible" role="alert">
            <?php echo e(session()->get('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
        </div>

    <?php endif; ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Phone</th>
            <th>SSN</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($card->status != "pending"): ?>
            <tr>
                <td><?php echo e($card->phone); ?></td>
                <td><?php echo e($card->SSN); ?></td>
                <td><?php echo e($card->created_at->diffForHumans()); ?></td>
                <td><?php echo e($card->status=="complete"?"Pending":"Completed"); ?></td>
                <td><a href="<?php echo e(route('finish',[$card->id])); ?>" class="btn btn-primary">Mark as Completed</a>
                    <a href="/clients/<?php echo e($card->phone); ?>/id.jpg" class="btn btn btn-secondary">View</a>
                    </td>


            </tr>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo e($cards->links()); ?>

    <div class="modal fade" id="viewClientModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Identification</h4>
                    <div class="row">
                        <img id="identification" />

                    </div>

                </div>

            </div>
        </div>
    </div>


    <script>
        function loadImages(number){
            var img = new Image();
            img.src = '/client'+number+'/id.jpg';
            var popup = window.open();
            popup.document.write(img);
            document.getElementById('identification').src='clients/'+number+'/id.jpg';

        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\LENOVO\Documents\github\NSSA_Paynow\resources\views/pages/cards.blade.php ENDPATH**/ ?>