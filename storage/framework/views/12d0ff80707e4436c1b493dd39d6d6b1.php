
<?php $__env->startSection('content'); ?>
<?php
$bugsCollection = isset($bugs) ? $bugs : (isset($bugsSample) ? $bugsSample : collect());
?>

<div class="container-fluid px-3 px-md-4 mt-3">
    <style>
        .admin-shell-wrapper {
            min-height: calc(100vh - 120px);
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        .admin-glass-panel {
            width: 100%;
            max-width: 1600px;
            background: #000000;
            border: 1px solid #333333;
            border-radius: 8px;
            padding: 2.2rem 2.1rem 2rem;
            position: relative;
        }

        .admin-glass-panel h2 {
            font-weight: 600;
            letter-spacing: .5px;
            color: #fff !important;
            margin-bottom: 0.5rem;
        }

        .admin-section-divider {
            height: 1px;
            background: #333333;
            margin: .85rem 0 1.4rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #111111;
            border: 1px solid #333333;
            border-radius: 4px;
            padding: 1.5rem;
            text-align: center;
            color: #fff;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            display: block;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-top: 0.5rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .section-title {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .btn-modern {
            background: #333333;
            border: 1px solid #555555;
            border-radius: 4px;
            color: white;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .btn-modern:hover {
            background: #444444;
            color: white;
        }

        .btn-danger-modern {
            background: #222222;
            border: 1px solid #555555;
            border-radius: 4px;
            color: white;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .btn-danger-modern:hover {
            background: #333333;
            color: white;
        }

        .btn-success-modern {
            background: #333333;
            border: 1px solid #555555;
            border-radius: 4px;
            color: white;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        .btn-success-modern:hover {
            background: #444444;
            color: white;
        }

        .modal-content {
            background: #000000;
            border: 1px solid #333333;
            border-radius: 4px;
        }

        .form-control,
        .form-select {
            background: #111111;
            border: 1px solid #333333;
            border-radius: 4px;
            color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            background: #111111;
            border-color: #555555;
            color: #fff;
            box-shadow: none;
        }

        .table-container {
            background: #111111;
            border-radius: 4px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #333333;
        }

        .transparent-table {
            --tbl-border: #333333;
            --tbl-row: #111111;
            --tbl-row-alt: #1a1a1a;
            --tbl-hover: #222222;
            color: #fff;
        }

        .transparent-table thead {
            background: #000000 !important;
            color: #f1f1f1;
        }

        .transparent-table tbody tr {
            background: var(--tbl-row);
        }

        .transparent-table tbody tr:nth-child(even) {
            background: var(--tbl-row-alt);
        }

        .transparent-table tbody tr:hover {
            background: var(--tbl-hover);
        }

        .transparent-table td,
        .transparent-table th {
            border: 1px solid var(--tbl-border) !important;
            padding: 0.75rem 0.5rem;
        }

        .badge {
            border-radius: 4px;
            padding: 0.4rem 0.8rem;
            font-weight: 500;
        }

        @media (max-width: 991.98px) {
            .admin-glass-panel {
                padding: 1.75rem 1.4rem 1.4rem;
                border-radius: 4px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .admin-glass-panel {
                padding: 1.4rem 1.05rem 1.1rem;
                border-radius: 4px;
            }

            .section-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
        }
    </style>

    <div class="admin-shell-wrapper">
        <div class="admin-glass-panel">
            <h2 class="mb-2">
                <?php if(Auth::user()->isSuperAdmin()): ?>
                🛡️ Super Admin Control Center
                <?php else: ?>
                🛡️ Admin Control Center
                <?php endif; ?>
            </h2>
            <p class="mb-2" style="font-size:.95rem; color:#fff; opacity: 0.9;">
                <?php if(Auth::user()->isSuperAdmin()): ?>
                Manage all users, administrators, bugs, and system permissions with full super admin control.
                <?php else: ?>
                Manage users, bugs, and system permissions with full administrative control.
                <?php endif; ?>
            </p>
            <div class="admin-section-divider"></div>

            <!-- Statistics Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-number"><?php echo e($totalBugs ?? 0); ?></span>
                    <div class="stat-label">Total Bugs</div>
                </div>
                <div class="stat-card">
                    <span class="stat-number" style="color: #ff6b6b;"><?php echo e($openBugs ?? 0); ?></span>
                    <div class="stat-label">Open Bugs</div>
                </div>
                <div class="stat-card">
                    <span class="stat-number" style="color: #ffd43b;"><?php echo e($inProgressBugs ?? 0); ?></span>
                    <div class="stat-label">In Progress</div>
                </div>
                <div class="stat-card">
                    <span class="stat-number" style="color: #51cf66;"><?php echo e($doneBugs ?? 0); ?></span>
                    <div class="stat-label">Completed</div>
                </div>
            </div>

            <?php echo $__env->make('admin.dashboard_content', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div><!-- /.admin-glass-panel -->
    </div><!-- /.admin-shell-wrapper -->
</div>

<?php echo $__env->make('admin.modals', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nirma\Documents\New folder\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>