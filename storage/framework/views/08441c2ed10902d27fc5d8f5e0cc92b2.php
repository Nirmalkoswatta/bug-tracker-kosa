<?php $__env->startSection('content'); ?>
<style>
    .signup-container {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .signup-card {
        background: #000000;
        border: 2px solid #333333;
        border-radius: 16px;
        padding: 3rem 2.5rem;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .signup-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .signup-title {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .signup-subtitle {
        color: #888888;
        font-size: 1.1rem;
        margin: 0;
    }

    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .form-label {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.25rem;
        background: #111111;
        border: 2px solid #333333;
        border-radius: 12px;
        color: #ffffff;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #555555;
        background: #1a1a1a;
        box-shadow: 0 0 0 4px rgba(85, 85, 85, 0.1);
    }

    .form-select {
        width: 100%;
        padding: 1rem 1.25rem;
        background: #111111;
        border: 2px solid #333333;
        border-radius: 12px;
        color: #ffffff;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        outline: none;
        border-color: #555555;
        background: #1a1a1a;
        box-shadow: 0 0 0 4px rgba(85, 85, 85, 0.1);
    }

    .form-select option {
        background: #111111;
        color: #ffffff;
        padding: 0.5rem;
    }

    .role-description {
        font-size: 0.85rem;
        color: #666666;
        margin-top: 0.5rem;
        padding: 0.75rem;
        background: #0a0a0a;
        border-radius: 8px;
        border-left: 3px solid #333333;
    }

    .signup-btn {
        width: 100%;
        padding: 1.25rem;
        background: #ffffff;
        color: #000000;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .signup-btn:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
    }

    .signup-btn:active {
        transform: translateY(0);
    }

    .signup-footer {
        text-align: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #333333;
    }

    .signup-footer-text {
        color: #888888;
        font-size: 0.95rem;
    }

    .signup-footer-link {
        color: #ffffff;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .signup-footer-link:hover {
        color: #cccccc;
    }

    .error-message {
        color: #ff6b6b;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #666666;
        cursor: pointer;
        font-size: 1.1rem;
        transition: color 0.3s ease;
    }

    .password-toggle:hover {
        color: #ffffff;
    }

    @media (max-width: 576px) {
        .signup-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }
        
        .signup-title {
            font-size: 2rem;
        }
    }
</style>

<div class="signup-container">
    <div class="signup-card">
        <div class="signup-header">
            <h1 class="signup-title">🚀 Create Account</h1>
            <p class="signup-subtitle">Register your new account</p>
        </div>

        <form method="POST" action="<?php echo e(route('register')); ?>" id="signupForm">
            <?php echo csrf_field(); ?>
            
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus 
                       class="form-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       placeholder="Enter your full name">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error-message"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required 
                       class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       placeholder="Enter your email address">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error-message"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Select Your Role</label>
                <select id="role" name="role" class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">Choose your role...</option>
                    <option value="Super Admin" <?php echo e(old('role') == 'Super Admin' ? 'selected' : ''); ?>>🔥 Super Admin</option>
                    <option value="Admin" <?php echo e(old('role') == 'Admin' ? 'selected' : ''); ?>>⚡ Admin</option>
                    <option value="PM" <?php echo e(old('role') == 'PM' ? 'selected' : ''); ?>>📊 Project Manager</option>
                    <option value="Dev" <?php echo e(old('role') == 'Dev' ? 'selected' : ''); ?>>💻 Developer</option>
                    <option value="QA" <?php echo e(old('role') == 'QA' ? 'selected' : ''); ?>>🔍 QA Engineer</option>
                </select>
                <div id="roleDescription" class="role-description" style="display: none;"></div>
                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error-message"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div style="position: relative;">
                    <input id="password" type="password" name="password" required 
                           class="form-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           placeholder="Create a strong password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fa fa-eye" id="password-eye"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="error-message"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <div style="position: relative;">
                    <input id="password-confirm" type="password" name="password_confirmation" required 
                           class="form-input" 
                           placeholder="Confirm your password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password-confirm')">
                        <i class="fa fa-eye" id="password-confirm-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="signup-btn">
                Register Account
            </button>
        </form>

        <div class="signup-footer">
            <p class="signup-footer-text">
                Already have an account? 
                <a href="<?php echo e(route('login')); ?>" class="signup-footer-link">Sign in here</a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(inputId + '-eye');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fa fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fa fa-eye';
        }
    }

    document.getElementById('role').addEventListener('change', function() {
        const descriptions = {
            'Super Admin': 'Full system access - Can manage all users including admins, complete control over the platform',
            'Admin': 'Administrative access - Can manage developers, QA engineers, and project managers',
            'PM': 'Project oversight - Can view all bugs, manage project timelines and team coordination',
            'Dev': 'Development access - Can view assigned bugs, update status, and collaborate with QA',
            'QA': 'Quality assurance - Can create, track, and manage bug reports'
        };
        
        const roleDesc = document.getElementById('roleDescription');
        if (this.value && descriptions[this.value]) {
            roleDesc.textContent = descriptions[this.value];
            roleDesc.style.display = 'block';
        } else {
            roleDesc.style.display = 'none';
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\nirma\Documents\New folder\resources\views/auth/register.blade.php ENDPATH**/ ?>