

<?php $__env->startSection('content'); ?>
<div class="container" style='margin-top: 90px; max-width: 1200px; min-width: 320px; width: 100%; background-image: url("<?php echo e(asset('10780356_19199649.jpg')); ?>"); background-repeat: no-repeat; background-position: center center; background-attachment: fixed; background-size: cover; min-height: 100vh;'>
    <style>
        .pm-glass-table{--bdr:rgba(255,255,255,0.35); --row:rgba(255,255,255,0.10); --row-alt:rgba(255,255,255,0.05); --hover:rgba(255,255,255,0.18); color:#fff;}
        .pm-glass-table thead{background:rgba(0,0,0,0.55)!important; color:#f1f1f1;}
        .pm-glass-table tbody tr{background:var(--row);} 
        .pm-glass-table tbody tr:nth-child(even){background:var(--row-alt);} 
        .pm-glass-table tbody tr:hover{background:var(--hover);} 
        .pm-glass-table td,.pm-glass-table th{border:1px solid var(--bdr)!important;}
        h2.pm-title{color:#fff; font-weight:600; letter-spacing:.5px;}
    </style>
    <h2 class="pm-title mb-3">Project Manager Dashboard</h2>
    <table class="table table-bordered pm-glass-table align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $bugs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bug): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($bug->id); ?></td>
                <td><?php echo e($bug->title); ?></td>
                <td><?php echo e($bug->status); ?></td>
                <td><?php echo e(optional($bug->assignedTo)->name); ?></td>
                <td><?php echo e(optional($bug->creator)->name); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nirma\Documents\New folder\resources\views/pm-dashboard.blade.php ENDPATH**/ ?>