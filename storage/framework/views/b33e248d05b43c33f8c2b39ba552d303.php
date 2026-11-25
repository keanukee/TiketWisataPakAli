
<?php $__env->startSection('title', 'Login - Sistem Tiket Wisata Pa Ali'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card auth-card p-4 bg-white">
        <div class="text-center mb-4">
            <div class="display-5 text-primary mb-2"><i class="bi bi-ticket-perforated-fill"></i></div>
            <h4 class="fw-bold text-dark mb-1">Wisata Pa Ali Online</h4>
            <p class="text-muted small">Silakan login untuk memesan tiket atau mengelola sistem</p>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success small"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger small"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <form action="<?php echo e(route('login')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>"
                    placeholder="Masukkan email" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small" for="remember">Ingat sesi login saya</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
            </button>
        </form>

        <div class="text-center mt-3 small">
            Belum punya akun pengunjung? <a href="<?php echo e(route('register')); ?>" class="fw-bold text-decoration-none">Daftar Akun
                Baru</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Keanu_2TID\laragon-6.0-minimal\www\TiketWisataPakAli\resources\views/auth/login.blade.php ENDPATH**/ ?>