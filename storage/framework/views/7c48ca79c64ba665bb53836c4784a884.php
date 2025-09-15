<!-- Bugs Management Section -->
<div class="table-container">
    <div class="section-header">
        <h3 class="section-title">🐛 Bug Management</h3>
        <div class="d-flex gap-2">
            <button class="btn btn-modern btn-sm" data-bs-toggle="modal" data-bs-target="#assignBugModal">
                <i class="fas fa-user-plus"></i> Assign Bug
            </button>
            <a href="<?php echo e(route('admin.bugs.export.csv')); ?>" class="btn btn-success-modern btn-sm">
                <i class="fas fa-download"></i> Export CSV
            </a>
        </div>
    </div>

    <?php if($bugsCollection->count()): ?>
    <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle mb-0 transparent-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>QA Creator</th>
                    <th>Assigned Dev</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $bugsCollection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bug): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $id = is_array($bug) ? ($bug['id'] ?? '') : ($bug->id ?? '');
                $title = is_array($bug) ? ($bug['title'] ?? '') : ($bug->title ?? '');
                $status = strtolower(is_array($bug) ? ($bug['status'] ?? '') : ($bug->status ?? ''));
                $creator = is_array($bug) ? ($bug['creator'] ?? '') : ($bug->creator ?? '');
                $assigned = is_array($bug) ? ($bug['assigned'] ?? '') : ($bug->assigned ?? '');
                $assignedId = is_array($bug) ? ($bug['assigned_id'] ?? null) : ($bug->assigned_id ?? null);
                $badgeClass = match($status){
                'open' => 'bg-danger',
                'in progress','in_progress' => 'bg-warning text-dark',
                'done' => 'bg-success',
                default => 'bg-secondary'
                };
                ?>
                <tr>
                    <td><strong>#<?php echo e($id); ?></strong></td>
                    <td><?php echo e(Str::limit($title, 50)); ?></td>
                    <td><span class="badge <?php echo e($badgeClass); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $status))); ?></span></td>
                    <td><?php echo e($creator ?: '—'); ?></td>
                    <td><?php echo e($assigned ?: '—'); ?></td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#bugViewModal"
                                data-bug='<?php echo e(json_encode(['id' => $id, 'title' => $title, 'status' => $status, 'creator' => $creator, 'assigned' => $assigned])); ?>'>
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-modern btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#assignBugModal"
                                data-bug-id="<?php echo e($id); ?>"
                                data-current-assigned="<?php echo e($assignedId); ?>">
                                <i class="fas fa-user-edit"></i>
                            </button>
                            <?php if(Route::has('bugs.destroy')): ?>
                            <form action="<?php echo e(route('bugs.destroy', $id)); ?>" method="POST"
                                onsubmit="return confirm('Delete bug #<?php echo e($id); ?>?');"
                                class="d-inline-block">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger-modern btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="alert alert-light py-3 mb-0 border text-center">
        <i class="fas fa-bug fa-2x mb-2 text-muted"></i>
        <p class="mb-0">No bugs available.</p>
    </div>
    <?php endif; ?>
</div>

<!-- User Management Section -->
<div class="table-container">
    <div class="section-header">
        <h3 class="section-title">👥 User Management</h3>
        <button class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="fas fa-plus"></i> Add New User
        </button>
    </div>

    <!-- Super Admin Management Section - Only for Super Admins -->
    <?php if(Auth::user()->isSuperAdmin()): ?>
    <?php if($superAdmins->count() > 0): ?>
    <h5 class="text-white mb-3">🛡️ Super Admins <span class="badge bg-danger"><?php echo e($superAdmins->count()); ?></span></h5>
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-sm align-middle mb-0 transparent-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $superAdmins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $superAdmin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><strong><?php echo e($superAdmin->name); ?></strong></td>
                    <td><?php echo e($superAdmin->email); ?></td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-modern btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal"
                                data-user-id="<?php echo e($superAdmin->id); ?>"
                                data-user-name="<?php echo e($superAdmin->name); ?>"
                                data-user-email="<?php echo e($superAdmin->email); ?>"
                                data-user-role="<?php echo e($superAdmin->role); ?>"
                                data-user-qas="<?php echo e($superAdmin->can_access_qas ? '1' : '0'); ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST" action="<?php echo e(route('admin.users.destroy', $superAdmin->id)); ?>"
                                class="d-inline"
                                onsubmit="return confirm('Delete Super Admin <?php echo e($superAdmin->name); ?>?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger-modern btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Admin Management Section - Only for Super Admins -->
    <?php if($admins->count() > 0): ?>
    <h5 class="text-white mb-3">👑 Admins <span class="badge bg-warning text-dark"><?php echo e($admins->count()); ?></span></h5>
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-sm align-middle mb-0 transparent-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><strong><?php echo e($admin->name); ?></strong></td>
                    <td><?php echo e($admin->email); ?></td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-modern btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal"
                                data-user-id="<?php echo e($admin->id); ?>"
                                data-user-name="<?php echo e($admin->name); ?>"
                                data-user-email="<?php echo e($admin->email); ?>"
                                data-user-role="<?php echo e($admin->role); ?>"
                                data-user-qas="<?php echo e($admin->can_access_qas ? '1' : '0'); ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST" action="<?php echo e(route('admin.users.destroy', $admin->id)); ?>"
                                class="d-inline"
                                onsubmit="return confirm('Delete Admin <?php echo e($admin->name); ?>?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger-modern btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <!-- Developers -->
    <h5 class="text-white mb-3">Developers <span class="badge bg-info"><?php echo e($developers->count()); ?></span></h5>
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-sm align-middle mb-0 transparent-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>QA Access</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $developers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong><?php echo e($dev->name); ?></strong></td>
                    <td><?php echo e($dev->email); ?></td>
                    <td>
                        <?php if($dev->can_access_qas): ?>
                        <span class="badge bg-success"><i class="fas fa-check"></i> Enabled</span>
                        <?php else: ?>
                        <span class="badge bg-secondary"><i class="fas fa-times"></i> Disabled</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-modern btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal"
                                data-user-id="<?php echo e($dev->id); ?>"
                                data-user-name="<?php echo e($dev->name); ?>"
                                data-user-email="<?php echo e($dev->email); ?>"
                                data-user-role="<?php echo e($dev->role); ?>"
                                data-user-qas="<?php echo e($dev->can_access_qas ? '1' : '0'); ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <?php if(Route::has('admin.toggleQAs')): ?>
                            <form method="POST" action="<?php echo e(route('admin.toggleQAs', $dev->id)); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm <?php echo e($dev->can_access_qas ? 'btn-warning' : 'btn-success-modern'); ?>">
                                    <i class="fas fa-<?php echo e($dev->can_access_qas ? 'user-times' : 'user-check'); ?>"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('admin.users.destroy', $dev->id)); ?>"
                                class="d-inline"
                                onsubmit="return confirm('Delete developer <?php echo e($dev->name); ?>?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger-modern btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">No developers found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- QAs -->
    <h5 class="text-white mb-3">QA Engineers <span class="badge bg-warning text-dark"><?php echo e($qas->count()); ?></span></h5>
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-sm align-middle mb-0 transparent-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $qas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong><?php echo e($qa->name); ?></strong></td>
                    <td><?php echo e($qa->email); ?></td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-modern btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal"
                                data-user-id="<?php echo e($qa->id); ?>"
                                data-user-name="<?php echo e($qa->name); ?>"
                                data-user-email="<?php echo e($qa->email); ?>"
                                data-user-role="<?php echo e($qa->role); ?>"
                                data-user-qas="<?php echo e($qa->can_access_qas ? '1' : '0'); ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST" action="<?php echo e(route('admin.users.destroy', $qa->id)); ?>"
                                class="d-inline"
                                onsubmit="return confirm('Delete QA <?php echo e($qa->name); ?>?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger-modern btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3" class="text-center text-muted">No QA engineers found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Project Managers -->
    <h5 class="text-white mb-3">Project Managers <span class="badge bg-primary"><?php echo e($pms->count()); ?></span></h5>
    <div class="table-responsive mb-2">
        <table class="table table-bordered table-sm align-middle mb-0 transparent-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong><?php echo e($pm->name); ?></strong></td>
                    <td><?php echo e($pm->email); ?></td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-modern btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal"
                                data-user-id="<?php echo e($pm->id); ?>"
                                data-user-name="<?php echo e($pm->name); ?>"
                                data-user-email="<?php echo e($pm->email); ?>"
                                data-user-role="<?php echo e($pm->role); ?>"
                                data-user-qas="<?php echo e($pm->can_access_qas ? '1' : '0'); ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form method="POST" action="<?php echo e(route('admin.users.destroy', $pm->id)); ?>"
                                class="d-inline"
                                onsubmit="return confirm('Delete PM <?php echo e($pm->name); ?>?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger-modern btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="3" class="text-center text-muted">No project managers found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div><?php /**PATH C:\Users\nirma\Documents\New folder\resources\views/admin/dashboard_content.blade.php ENDPATH**/ ?>