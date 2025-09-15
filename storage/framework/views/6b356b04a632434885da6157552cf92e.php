

<?php $__env->startSection('content'); ?>
<style>
    .dev-dashboard-bg {
        margin-top: 90px;
        min-height: 100vh;
        width: 100vw;
        background: url('<?php echo e(asset(' 10780356_19199649.jpg')); ?>') no-repeat center center fixed;
        background-size: cover;
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-bottom: 3rem;
    }

    .dev-dashboard-title {
        font-size: 2rem;
        font-weight: bold;
        margin: 2rem 0 1.5rem 0;
        text-align: center;
        letter-spacing: 1px;
        text-shadow: 0 2px 12px #0008;
    }

    .dev-bug-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        width: 100%;
        max-width: 1200px;
    }

    .dev-bug-card {
        background: rgba(255, 255, 255, 0.13);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-radius: 20px;
        border: 1.5px solid rgba(255, 255, 255, 0.18);
        min-width: 270px;
        max-width: 340px;
        width: 100%;
        padding: 1.7rem 1.3rem 1.3rem 1.3rem;
        color: #fff;
        display: flex;
        flex-direction: column;
        gap: 0.7rem;
        position: relative;
        transition: transform 0.15s, box-shadow 0.15s;
    }

    .dev-bug-card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 12px 36px -6px #000a;
    }

    .dev-bug-id {
        font-size: 1.1rem;
        font-weight: 600;
        color: #b3e5fc;
    }

    .dev-bug-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.2rem;
        color: #fff;
        text-shadow: 0 1px 6px #0006;
    }

    .dev-bug-status {
        display: inline-block;
        font-size: 0.95rem;
        font-weight: 600;
        padding: 0.3em 1em;
        border-radius: 1em;
        background: #222;
        color: #fff;
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
    }

    .dev-bug-status.inprogress {
        background: #f1c40f;
        color: #222;
    }

    .dev-bug-status.review {
        background: #3498db;
        color: #fff;
    }

    .dev-bug-status.done {
        background: #27ae60;
        color: #fff;
    }

    .dev-bug-actions {
        margin-top: 1rem;
        display: flex;
        justify-content: flex-end;
        gap: 0.7rem;
    }

    .dev-bug-update-btn {
        border-radius: 16px;
        background: #ffb300;
        color: #222;
        font-weight: 600;
        border: none;
        padding: 0.5rem 1.3rem;
        box-shadow: 0 2px 8px #ffb30033;
        transition: background 0.2s;
    }

    .dev-bug-update-btn:hover {
        background: #ff9800;
        color: #fff;
    }

    @media (max-width: 700px) {
        .dev-bug-cards {
            gap: 1.2rem;
        }

        .dev-bug-card {
            min-width: 90vw;
            max-width: 98vw;
        }
    }
</style>
<div class="dev-dashboard-bg">
    <div class="dev-dashboard-title">Developer Dashboard</div>
    <div class="dev-bug-cards">
        <?php $__currentLoopData = $bugs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bug): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="dev-bug-card">
            <div class="dev-bug-id">#<?php echo e($bug->id); ?></div>
            <div class="dev-bug-title"><?php echo e($bug->title); ?></div>
            <div class="dev-bug-status <?php echo e(strtolower($bug->status)); ?>"><?php echo e(ucfirst($bug->status)); ?></div>
            <div class="dev-bug-actions">
                <?php if($bug->attachment): ?>
                <a href="<?php echo e(route('bugs.download', $bug)); ?>" class="dev-bug-update-btn" style="background:#2196f3; color:#fff;">Download</a>
                <?php endif; ?>
                <a href="<?php echo e(route('bugs.edit', $bug)); ?>" class="dev-bug-update-btn">Update Status</a>
            </div>
            <!-- Modal for viewing bug details -->
            <div class="modal fade" id="viewModal-<?php echo e($bug->id); ?>" tabindex="-1" aria-labelledby="viewModalLabel-<?php echo e($bug->id); ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="viewModalLabel-<?php echo e($bug->id); ?>">Bug Details</h5>
                            <button type="button" class="btn btn-danger" style="border-radius:50%; width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; font-size:1.3rem; position:absolute; top:1rem; right:1rem; z-index:10;" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-2"><strong>Title:</strong> <?php echo e($bug->title); ?></div>
                            <div><strong>Description:</strong><br><?php echo e($bug->description); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nirma\Documents\New folder\resources\views/dev-dashboard.blade.php ENDPATH**/ ?>