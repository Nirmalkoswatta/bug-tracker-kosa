

<?php $__env->startSection('content'); ?>
<style>
    .bug-cards-bg {
        min-height: 100vh;
        padding: 2rem 0;
    }

    .bug-card-glass {
        background: rgba(255, 255, 255, 0.10);
        backdrop-filter: blur(10px) saturate(140%);
        -webkit-backdrop-filter: blur(10px) saturate(140%);
        border-radius: 18px;
        border: 1px solid rgba(255, 255, 255, 0.22);
        box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.25);
        transition: transform .15s, box-shadow .15s;
    }

    .bug-card-glass:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 8px 32px -4px rgba(0, 0, 0, 0.35);
    }

    .bug-status {
        font-size: 0.85rem;
        padding: 0.3em 0.9em;
        border-radius: 1em;
        font-weight: 600;
        letter-spacing: .5px;
    }

    .bug-status-open {
        background: #e74c3c;
        color: #fff;
    }

    .bug-status-inprogress {
        background: #f1c40f;
        color: #222;
    }

    .bug-status-done {
        background: #27ae60;
        color: #fff;
    }

    .bug-meta-label {
        color: #bbb;
        font-size: 0.92em;
    }

    .bug-action-btn {
        min-width: 70px;
    }
</style>
<div class="bug-cards-bg" style="background: url('<?php echo e(asset('10780356_19199649.jpg')); ?>') no-repeat center center fixed; background-size: cover;">
    <div class="container">
        <h2 class="text-white mb-4">All Bugs</h2>
        <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(in_array(Auth::user()->role,['QA','Admin'])): ?>
        <a href="<?php echo e(route('bugs.create')); ?>" class="btn btn-primary mb-3">Create Bug</a>
        <?php endif; ?>
        <?php if($bugs->count()): ?>
        <div class="row g-4">
            <?php $__currentLoopData = $bugs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bug): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $status = strtolower($bug->status ?? '');
            $statusClass = match($status) {
            'open' => 'bug-status bug-status-open',
            'in progress', 'in_progress' => 'bug-status bug-status-inprogress',
            'done' => 'bug-status bug-status-done',
            default => 'bug-status bg-secondary text-white'
            };
            ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="bug-card-glass p-4 h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold fs-5" style="color:#fff;"><?php echo e($bug->title); ?></span>
                        <span class="<?php echo e($statusClass); ?>"><?php echo e(ucfirst($status)); ?></span>
                    </div>
                    <div class="mb-2">
                        <span class="bug-meta-label">ID:</span> <span style="color:#fff;"><?php echo e($bug->id); ?></span>
                    </div>
                    <div class="mb-2">
                        <span class="bug-meta-label">QA (Creator):</span>
                        <span style="color:#fff;">
                            <?php
                            $creator = $bug->qa_creator ?? $bug->creator ?? null;
                            $creatorName = is_object($creator) ? ($creator->name ?? '-') : (is_array($creator) ? ($creator['name'] ?? '-') : (is_string($creator) ? $creator : '-'));
                            $createdAt = $bug->created_at
                            ? \Carbon\Carbon::parse($bug->created_at)
                            ->setTimezone('Asia/Colombo')
                            ->format('Y-m-d h:i A')
                            : '-';
                            ?>
                            <?php echo e($creatorName); ?> <span class="bug-meta-label">|</span> <?php echo e($createdAt); ?>

                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="bug-meta-label">Assigned Dev:</span> <span style="color:#fff;"><?php echo e($bug->assigned_dev ?? (optional($bug->assignedTo)->name ?? '-')); ?></span>
                    </div>
                    <div class="mb-2">
                        <span class="bug-meta-label">Description:</span>
                        <div class="small" style="color:#fff;"><?php echo e(Str::limit($bug->description, 80)); ?></div>
                    </div>
                    <div class="mt-auto d-flex gap-2">
                        <?php if($bug->attachment): ?>
                        <a href="<?php echo e(route('bugs.download', $bug)); ?>" class="btn btn-info btn-sm bug-action-btn text-white">Download</a>
                        <?php else: ?>
                        <button type="button" class="btn btn-info btn-sm bug-action-btn text-white" disabled>View</button>
                        <?php endif; ?>
                        <?php if(Route::has('bugs.edit')): ?>
                        <a href="<?php echo e(route('bugs.edit', $bug->id)); ?>" class="btn btn-primary btn-sm bug-action-btn">Edit</a>
                        <?php endif; ?>
                        <?php if(Route::has('bugs.destroy')): ?>
                        <form action="<?php echo e(route('bugs.destroy', $bug->id)); ?>" method="POST" onsubmit="return confirm('Delete bug #<?php echo e($bug->id); ?>?');" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm bug-action-btn">Delete</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="alert alert-light mt-5">No bugs found.</div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nirma\Documents\New folder\resources\views/bugs/index.blade.php ENDPATH**/ ?>