
<?php $__env->startSection('title', 'Manajemen User - Wisata Pa Ali'); ?>
<?php $__env->startSection('page_title', 'Manajemen Pengguna (Admin & Pengunjung)'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card card-mazer p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-person-plus-fill text-primary me-1"></i> Tambah User Baru</h6>
            <form action="<?php echo e(route('users.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">No HP</label>
                    <input type="text" name="no_hp" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Role Hak Akses</label>
                    <select name="role" class="form-select" required>
                        <option value="pengunjung">Pengunjung (Customer)</option>
                        <option value="admin">Admin / Pengelola</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan User</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-mazer p-4">
            <h6 class="fw-bold mb-3">Daftar Akun Pengguna Sistem</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email & HP</th>
                            <th>Role</th>
                            <th>Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="fw-bold"><?php echo e($u->name); ?></td>
                                <td><?php echo e($u->email); ?><br><small class="text-muted"><?php echo e($u->no_hp); ?></small></td>
                                <td>
                                    <span class="badge <?php echo e($u->role === 'admin' ? 'bg-primary' : 'bg-success'); ?>">
                                        <?php echo e(strtoupper($u->role)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($u->pemesanan_count); ?> Pesanan</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUser<?php echo e($u->id); ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <?php if($u->id !== auth()->id()): ?>
                                        <form action="<?php echo e(route('users.destroy', $u->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <div class="modal fade" id="editUser<?php echo e($u->id); ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="<?php echo e(route('users.update', $u->id)); ?>" method="POST" class="modal-content">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                        <div class="modal-header">
                                            <h6 class="modal-title fw-bold">Edit Pengguna</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="name" class="form-control" value="<?php echo e($u->name); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" value="<?php echo e($u->email); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">No HP</label>
                                                <input type="text" name="no_hp" class="form-control" value="<?php echo e($u->no_hp); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                <select name="role" class="form-select">
                                                    <option value="pengunjung" <?php echo e($u->role === 'pengunjung' ? 'selected' : ''); ?>>Pengunjung</option>
                                                    <option value="admin" <?php echo e($u->role === 'admin' ? 'selected' : ''); ?>>Admin</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password Baru (Kosongkan jika tidak diubah)</label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Keanu_2TID\laragon-6.0-minimal\www\TiketWisataPakAli\resources\views/users/index.blade.php ENDPATH**/ ?>