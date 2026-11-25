
<?php $__env->startSection('title', 'Kelola Destinasi Wisata - Wisata Pa Ali'); ?>
<?php $__env->startSection('page_title', 'Kelola Destinasi Wisata & Kuota Tiket'); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-mazer p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <form action="<?php echo e(route('destinasi.index')); ?>" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari wisata / kode..." value="<?php echo e(request('search')); ?>">
            <select name="kategori_id" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id); ?>" <?php echo e(request('kategori_id') == $k->id ? 'selected' : ''); ?>><?php echo e($k->nama_kategori); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button class="btn btn-sm btn-outline-primary">Filter</button>
        </form>
        <a href="<?php echo e(route('destinasi.create')); ?>" class="btn btn-primary btn-sm fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Tambah Destinasi Wisata
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Destinasi Wisata</th>
                    <th>Kategori</th>
                    <th>Harga Tiket</th>
                    <th>Kuota Harian</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $destinasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-bold"><?php echo e($d->kode_wisata); ?></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="<?php echo e($d->gambar_url); ?>" width="55" height="40" class="rounded object-fit-cover" alt="">
                                <div>
                                    <div class="fw-bold"><?php echo e($d->nama_wisata); ?></div>
                                    <small class="text-muted"><?php echo e($d->lokasi); ?></small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-primary"><?php echo e($d->kategori->nama_kategori); ?></span></td>
                        <td class="fw-bold text-success">Rp <?php echo e(number_format($d->harga_tiket, 0, ',', '.')); ?></td>
                        <td><?php echo e($d->kuota_harian); ?> Orang/Hari</td>
                        <td>
                            <span class="badge <?php echo e($d->status === 'aktif' ? 'bg-success' : 'bg-secondary'); ?>">
                                <?php echo e(ucfirst($d->status)); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('destinasi.edit', $d->id)); ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                            <form action="<?php echo e(route('destinasi.destroy', $d->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus destinasi ini?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="text-center text-muted">Data destinasi wisata belum tersedia.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($destinasi->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Keanu_2TID\laragon-6.0-minimal\www\TiketWisataPakAli\resources\views/destinasi/index.blade.php ENDPATH**/ ?>