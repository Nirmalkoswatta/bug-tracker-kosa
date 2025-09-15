<!-- Bug View Modal -->
<div class="modal fade" id="bugViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #000000; border: 1px solid #333333; border-radius: 4px; color: #fff;">
            <div class="modal-header" style="border-bottom: 1px solid #333333;">
                <h5 class="modal-title" style="color: #fff;">🐛 Bug Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
            </div>
            <div class="modal-body" id="bug-view-body" style="color: #fff;">
                <div class="text-muted">Select a bug to view details.</div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #333333;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background: #333333; border: 1px solid #555555; color: #fff;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #000000; border: 1px solid #333333; border-radius: 4px; color: #fff;">
            <div class="modal-header" style="border-bottom: 1px solid #333333;">
                <h5 class="modal-title" style="color: #fff;">👤 Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
            </div>
            <form action="<?php echo e(route('admin.users.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create_name" class="form-label" style="color: #fff;">Full Name</label>
                        <input type="text" class="form-control" id="create_name" name="name" required style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                    </div>
                    <div class="mb-3">
                        <label for="create_email" class="form-label" style="color: #fff;">Email Address</label>
                        <input type="email" class="form-control" id="create_email" name="email" required style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                    </div>
                    <div class="mb-3">
                        <label for="create_password" class="form-label" style="color: #fff;">Password</label>
                        <input type="password" class="form-control" id="create_password" name="password" required style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                    </div>
                    <div class="mb-3">
                        <label for="create_password_confirmation" class="form-label" style="color: #fff;">Confirm Password</label>
                        <input type="password" class="form-control" id="create_password_confirmation" name="password_confirmation" required style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                    </div>
                    <div class="mb-3">
                        <label for="create_role" class="form-label" style="color: #fff;">Role</label>
                        <select class="form-select" id="create_role" name="role" required style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                            <option value="">Select Role</option>
                            <?php if(Auth::user()->isSuperAdmin()): ?>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                            <?php endif; ?>
                            <option value="Dev">Developer</option>
                            <option value="QA">QA Engineer</option>
                            <option value="PM">Project Manager</option>
                        </select>
                    </div>
                    <div class="mb-3" id="create_qas_access_group" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="create_can_access_qas" name="can_access_qas" value="1" style="background: #111111; border: 1px solid #333333;">
                            <label class="form-check-label" for="create_can_access_qas" style="color: #fff;">
                                Can Access QA Features
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #333333;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #555555; border: 1px solid #777777; color: #fff;">Cancel</button>
                    <button type="submit" class="btn" style="background: #333333; border: 1px solid #555555; color: #fff;">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #000000; border: 1px solid #333333; border-radius: 4px; color: #fff;">
            <div class="modal-header" style="border-bottom: 1px solid #333333;">
                <h5 class="modal-title" style="color: #fff;">✏️ Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
            </div>
            <form id="editUserForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label" style="color: #fff;">Full Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label" style="color: #fff;">Email Address</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label" style="color: #fff;">New Password (leave blank to keep current)</label>
                        <input type="password" class="form-control" id="edit_password" name="password" style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                    </div>
                    <div class="mb-3">
                        <label for="edit_password_confirmation" class="form-label" style="color: #fff;">Confirm New Password</label>
                        <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation" style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                    </div>
                    <div class="mb-3">
                        <label for="edit_role" class="form-label" style="color: #fff;">Role</label>
                        <select class="form-select" id="edit_role" name="role" required style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                            <?php if(Auth::user()->isSuperAdmin()): ?>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                            <?php endif; ?>
                            <option value="Dev">Developer</option>
                            <option value="QA">QA Engineer</option>
                            <option value="PM">Project Manager</option>
                        </select>
                    </div>
                    <div class="mb-3" id="edit_qas_access_group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_can_access_qas" name="can_access_qas" value="1" style="background: #111111; border: 1px solid #333333;">
                            <label class="form-check-label" for="edit_can_access_qas" style="color: #fff;">
                                Can Access QA Features
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #333333;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #555555; border: 1px solid #777777; color: #fff;">Cancel</button>
                    <button type="submit" class="btn" style="background: #333333; border: 1px solid #555555; color: #fff;">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assign Bug Modal -->
<div class="modal fade" id="assignBugModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #000000; border: 1px solid #333333; border-radius: 4px; color: #fff;">
            <div class="modal-header" style="border-bottom: 1px solid #333333;">
                <h5 class="modal-title" style="color: #fff;">🎯 Assign Bug</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
            </div>
            <form id="assignBugForm" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="assign_bug_id" class="form-label" style="color: #fff;">Bug ID</label>
                        <input type="text" class="form-control" id="assign_bug_id" readonly style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                    </div>
                    <div class="mb-3">
                        <label for="assign_to" class="form-label" style="color: #fff;">Assign To</label>
                        <select class="form-select" id="assign_to" name="assigned_to" style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                            <option value="">Unassigned</option>
                            <?php $__currentLoopData = $allUsers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> (<?php echo e($user->role); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="assign_status" class="form-label" style="color: #fff;">Status</label>
                        <select class="form-select" id="assign_status" name="status" style="background: #111111; border: 1px solid #333333; color: #fff; border-radius: 4px;">
                            <option value="open">Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #333333;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: #555555; border: 1px solid #777777; color: #fff;">Cancel</button>
                    <button type="submit" class="btn" style="background: #333333; border: 1px solid #555555; color: #fff;">Assign Bug</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bug View Modal Handler
        const bugViewModal = document.getElementById('bugViewModal');
        if (bugViewModal) {
            bugViewModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const bugData = button.getAttribute('data-bug');

                try {
                    const bug = JSON.parse(bugData);
                    const html = `
                    <table class="table table-bordered">
                        <tbody>
                            <tr><th style="width: 120px;">ID</th><td>#${bug.id || ''}</td></tr>
                            <tr><th>Title</th><td>${(bug.title || '').replace(/</g, '&lt;')}</td></tr>
                            <tr><th>Status</th><td><span class="badge bg-info">${(bug.status || '').replace(/</g, '&lt;')}</span></td></tr>
                            <tr><th>Creator</th><td>${(bug.creator || 'N/A').replace(/</g, '&lt;')}</td></tr>
                            <tr><th>Assigned</th><td>${(bug.assigned || 'Unassigned').replace(/</g, '&lt;')}</td></tr>
                        </tbody>
                    </table>
                `;
                    document.getElementById('bug-view-body').innerHTML = html;
                } catch (e) {
                    document.getElementById('bug-view-body').innerHTML = '<div class="text-muted">Error loading bug details.</div>';
                }
            });
        }

        // Create User Modal - Role Change Handler
        const createRoleSelect = document.getElementById('create_role');
        const createQasGroup = document.getElementById('create_qas_access_group');

        if (createRoleSelect) {
            createRoleSelect.addEventListener('change', function() {
                if (this.value === 'Dev') {
                    createQasGroup.style.display = 'block';
                } else {
                    createQasGroup.style.display = 'none';
                    document.getElementById('create_can_access_qas').checked = false;
                }
            });
        }

        // Edit User Modal Handler
        const editUserModal = document.getElementById('editUserModal');
        if (editUserModal) {
            editUserModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                const userEmail = button.getAttribute('data-user-email');
                const userRole = button.getAttribute('data-user-role');
                const userQas = button.getAttribute('data-user-qas');

                // Update form action
                document.getElementById('editUserForm').action = `/admin/users/${userId}`;

                // Populate form fields
                document.getElementById('edit_name').value = userName || '';
                document.getElementById('edit_email').value = userEmail || '';
                document.getElementById('edit_role').value = userRole || '';
                document.getElementById('edit_can_access_qas').checked = userQas === '1';

                // Show/hide QAS access based on role
                const editQasGroup = document.getElementById('edit_qas_access_group');
                if (userRole === 'Dev') {
                    editQasGroup.style.display = 'block';
                } else {
                    editQasGroup.style.display = 'none';
                }
            });
        }

        // Edit Role Change Handler
        const editRoleSelect = document.getElementById('edit_role');
        const editQasGroup = document.getElementById('edit_qas_access_group');

        if (editRoleSelect) {
            editRoleSelect.addEventListener('change', function() {
                if (this.value === 'Dev') {
                    editQasGroup.style.display = 'block';
                } else {
                    editQasGroup.style.display = 'none';
                    document.getElementById('edit_can_access_qas').checked = false;
                }
            });
        }

        // Assign Bug Modal Handler
        const assignBugModal = document.getElementById('assignBugModal');
        if (assignBugModal) {
            assignBugModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const bugId = button.getAttribute('data-bug-id');
                const currentAssigned = button.getAttribute('data-current-assigned');

                if (bugId) {
                    // Update form action and bug ID field
                    document.getElementById('assignBugForm').action = `/admin/bugs/${bugId}/assign`;
                    document.getElementById('assign_bug_id').value = `#${bugId}`;

                    // Set current assigned user
                    if (currentAssigned) {
                        document.getElementById('assign_to').value = currentAssigned;
                    }
                }
            });
        }
    });
</script><?php /**PATH C:\Users\nirma\Documents\New folder\resources\views/admin/modals.blade.php ENDPATH**/ ?>