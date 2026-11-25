
<?php $__env->startSection('title', 'Katalog Destinasi Wisata Pa Ali'); ?>
<?php $__env->startSection('page_title', 'Katalog & Pencarian Tiket Wisata'); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-mazer p-3 mb-4">
    <form action="<?php echo e(route('katalog')); ?>" method="GET" class="row g-2 align-items-center">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama wisata atau lokasi..." value="<?php echo e(request('search')); ?>">
        </div>
        <div class="col-md-3">
            <select name="kategori_id" class="form-select">
                <option value="">Semua Kategori Wisata</option>
                <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k->id); ?>" <?php echo e(request('kategori_id') == $k->id ? 'selected' : ''); ?>><?php echo e($k->nama_kategori); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="">Urutkan: Terbaru</option>
                <option value="termurah" <?php echo e(request('sort') === 'termurah' ? 'selected' : ''); ?>>Harga Terendah</option>
                <option value="termahal" <?php echo e(request('sort') === 'termahal' ? 'selected' : ''); ?>>Harga Tertinggi</option>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-search me-1"></i> Cari</button>
        </div>
    </form>
</div>

<div class="row g-4">
    <?php $__empty_1 = true; $__currentLoopData = $destinasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4">
            <div class="card card-mazer h-100">
                <img src="<?php echo e($d->gambar_url); ?>" class="destinasi-img" alt="<?php echo e($d->nama_wisata); ?>">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-light text-primary"><?php echo e($d->kategori->nama_kategori); ?></span>
                        <small class="text-muted">Kuota: <?php echo e($d->kuota_harian); ?>/hari</small>
                    </div>
                    <h5 class="fw-bold"><?php echo e($d->nama_wisata); ?></h5>
                    <p class="small text-muted mb-2"><i class="bi bi-geo-alt-fill text-danger"></i> <?php echo e($d->lokasi); ?></p>
                    <p class="small text-secondary"><?php echo e(\Illuminate\Support\Str::limit($d->deskripsi, 110)); ?></p>
                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block">Harga Tiket</small>
                            <span class="fs-5 fw-bold text-primary">Rp <?php echo e(number_format($d->harga_tiket, 0, ',', '.')); ?></span>
                        </div>
                        <a href="<?php echo e(route('pemesanan.create', ['destinasi_id' => $d->id])); ?>" class="btn btn-primary fw-bold">
                            <i class="bi bi-ticket-perforated me-1"></i> Pesan Tiket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="card card-mazer p-5 text-center text-muted">
                Destinasi wisata yang Anda cari tidak ditemukan.
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Keanu_2TID\laragon-6.0-minimal\www\TiketWisataPakAli\resources\views/pemesanan/katalog.blade.php ENDPATH**/ ?>