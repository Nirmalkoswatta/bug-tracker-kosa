

<?php $__env->startSection('content'); ?>
<style>
    .modern-bug-edit-bg {
        min-height: 100vh;
        width: 100vw;
        display: flex;
        align-items: center;
        justify-content: center;
        /* The background remains starry/animated as set in the layout */
    }

    .modern-bug-edit-card {
        background: rgba(255, 255, 255, 0.13);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border-radius: 24px;
        border: 1.5px solid rgba(255, 255, 255, 0.18);
        max-width: 500px;
        width: 100%;
        padding: 2.5rem 2rem 2rem 2rem;
        margin: 2.5rem 0;
        position: relative;
        color: #fff;
    }

    .modern-bug-edit-title {
        font-size: 2rem;
        font-weight: bold;
        text-align: center;
        margin-bottom: 1.5rem;
        letter-spacing: 1px;
        color: #fff;
        text-shadow: 0 2px 12px #0006;
    }

    .modern-bug-edit-label {
        font-weight: 500;
        margin-bottom: 0.4rem;
        color: #e0e0e0;
        letter-spacing: 0.5px;
    }

    .modern-bug-edit-input,
    .modern-bug-edit-select,
    .modern-bug-edit-textarea {
        background: #181818;
        border: 1.5px solid rgba(255, 255, 255, 0.22);
        border-radius: 12px;
        color: #fff;
        padding: 0.7rem 1rem;
        margin-bottom: 1.2rem;
        width: 100%;
        font-size: 1.08rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 1px 6px #0002;
    }

    .modern-bug-edit-select option {
        background: #181818;
        color: #fff;
    }

    .modern-bug-edit-input:focus,
    .modern-bug-edit-select:focus,
    .modern-bug-edit-textarea:focus {
        border-color: #339cff;
        outline: none;
        box-shadow: 0 0 0 2px #339cff44;
        background: rgba(255, 255, 255, 0.22);
    }

    .modern-bug-edit-btns {
        display: flex;
        justify-content: flex-end;
        gap: 0.7rem;
        margin-top: 1.5rem;
    }

    .modern-bug-edit-btn-cancel {
        border-radius: 16px;
        border: 1.5px solid #339cff;
        background: transparent;
        color: #339cff;
        font-weight: 500;
        padding: 0.55rem 1.5rem;
        transition: background 0.2s, color 0.2s;
    }

    .modern-bug-edit-btn-cancel:hover {
        background: #339cff22;
        color: #fff;
    }

    .modern-bug-edit-btn-update {
        border-radius: 16px;
        background: #339cff;
        color: #fff;
        font-weight: 600;
        border: none;
        padding: 0.55rem 1.5rem;
        box-shadow: 0 2px 8px #339cff33;
        transition: background 0.2s;
    }

    .modern-bug-edit-btn-update:hover {
        background: #2176c7;
    }

    @media (max-width: 600px) {
        .modern-bug-edit-card {
            padding: 1.2rem 0.5rem 1.2rem 0.5rem;
            border-radius: 16px;
        }

        .modern-bug-edit-title {
            font-size: 1.3rem;
        }
    }
</style>
<div class="modern-bug-edit-bg">
    <div class="modern-bug-edit-card">
        <div class="modern-bug-edit-title">Bug Tracker</div>
        <form method="POST" action="<?php echo e(route('bugs.update', $bug)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <label for="title" class="modern-bug-edit-label">Title</label>
            <input type="text" class="modern-bug-edit-input" id="title" name="title" value="<?php echo e($bug->title); ?>" <?php if(Auth::user()->role!=='QA' && Auth::user()->role!=='Admin'): ?> readonly <?php endif; ?>>
            <label for="description" class="modern-bug-edit-label">Description</label>
            <textarea class="modern-bug-edit-textarea" id="description" name="description" rows="4" <?php if(Auth::user()->role!=='QA' && Auth::user()->role!=='Admin'): ?> readonly <?php endif; ?>><?php echo e($bug->description); ?></textarea>
            <?php if(Auth::user()->role === 'Admin'): ?>
            <label for="assigned_to" class="modern-bug-edit-label">Assigned Developer</label>
            <select class="modern-bug-edit-select" id="assigned_to" name="assigned_to">
                <?php $__currentLoopData = $devs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dev->id); ?>" <?php if($bug->assigned_to == $dev->id): ?> selected <?php endif; ?>><?php echo e($dev->name); ?> (<?php echo e($dev->email); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php endif; ?>
            <label for="status" class="modern-bug-edit-label">Status</label>
            <select class="modern-bug-edit-select" id="status" name="status">
                <option value="inprogress" <?php echo e($bug->status == 'inprogress' ? 'selected' : ''); ?>>In Progress</option>
                <option value="review" <?php echo e($bug->status == 'review' ? 'selected' : ''); ?>>Review</option>
                <option value="done" <?php echo e($bug->status == 'done' ? 'selected' : ''); ?>>Done</option>
            </select>
            <div class="modern-bug-edit-btns">
                <a href="<?php echo e(url()->previous()); ?>" class="modern-bug-edit-btn-cancel">Cancel</a>
                <button type="submit" class="modern-bug-edit-btn-update">Update</button>
            </div>
        </form>
    </div>
</div>
// ...existing code...
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nirma\Documents\New folder\resources\views/bugs/edit.blade.php ENDPATH**/ ?>