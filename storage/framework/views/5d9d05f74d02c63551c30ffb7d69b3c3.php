

<?php $__env->startSection('content'); ?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="w-100" style="max-width: 700px;">
        <div class="card shadow-lg border-0 rounded-4 bg-dark text-white p-4">
            <h2 class="mb-4 text-center">View & Edit Bug</h2>
            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('bugs.update', $bug)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control bg-black text-white border-secondary" id="title" name="title" value="<?php echo e($bug->title); ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control bg-black text-white border-secondary" id="description" name="description" rows="4"><?php echo e($bug->description); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <input type="text" class="form-control bg-black text-white border-secondary" value="<?php echo e($bug->status); ?>" readonly>
                </div>
                <?php if($bug->attachment): ?>
                    <?php
                        $ext = strtolower(pathinfo($bug->attachment, PATHINFO_EXTENSION));
                        $imgExts = ['jpg','jpeg','png','gif','bmp','webp'];
                    ?>
                    <div class="mb-3">
                        <label class="form-label">Uploaded File Preview</label><br>
                        <?php if(in_array($ext, $imgExts)): ?>
                            <img src="<?php echo e(asset('storage/' . $bug->attachment)); ?>" alt="Attachment Image" style="max-width: 220px; max-height: 160px; border-radius: 8px; box-shadow: 0 2px 8px #0002; cursor:pointer;" data-bs-toggle="modal" data-bs-target="#imgModal">
                            <!-- Modal for image preview -->
                            <div class="modal fade" id="imgModal" tabindex="-1" aria-labelledby="imgModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content bg-dark">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title text-white" id="imgModalLabel">Full Image Preview</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body d-flex justify-content-center align-items-center" style="min-height:60vh;">
                                            <img src="<?php echo e(asset('storage/' . $bug->attachment)); ?>" alt="Full Image" style="max-width:100%; max-height:70vh; border-radius:12px; box-shadow:0 2px 16px #0008;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif($ext === 'pdf'): ?>
                            <embed src="<?php echo e(asset('storage/' . $bug->attachment)); ?>" type="application/pdf" width="100%" height="400px" style="border-radius:8px; background:#222;" />
                            <a href="<?php echo e(asset('storage/' . $bug->attachment)); ?>" target="_blank" class="btn btn-info btn-sm mt-2">Open PDF in New Tab</a>
                        <?php else: ?>
                            <a href="<?php echo e(asset('storage/' . $bug->attachment)); ?>" target="_blank" class="btn btn-info btn-sm">View File</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-outline-light" style="border-radius:18px;">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4" style="border-radius:18px;">Update Bug</button>
                </div>
            </form>
            <?php if(Auth::user()->role === 'QA' && $bug->created_by === Auth::id()): ?>
                <form method="POST" action="<?php echo e(route('bugs.destroy', $bug)); ?>" onsubmit="return confirm('Are you sure you want to delete this bug?');" class="mt-3">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger" style="border-radius:18px;">Delete Bug</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nirma\Documents\New folder\resources\views/bugs/show.blade.php ENDPATH**/ ?>