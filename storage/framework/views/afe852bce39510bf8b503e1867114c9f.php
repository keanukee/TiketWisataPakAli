
<?php $__env->startSection('title', 'Dashboard Pengunjung - Wisata Pa Ali'); ?>
<?php $__env->startSection('page_title', 'Beranda Pengunjung'); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-mazer p-4 mb-4 bg-primary text-white">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="fw-bold mb-1">Halo, <?php echo e(auth()->user()->name); ?>!</h4>
            <p class="mb-3 opacity-75">Rencanakan liburan seru Anda bersama keluarga di Wisata Pa Ali. Pesan tiket online tanpa antre di loket!</p>
            <a href="<?php echo e(route('katalog')); ?>" class="btn btn-light text-primary fw-bold me-2">
                <i class="bi bi-compass me-1"></i> Jelajahi Katalog Wisata
            </a>
            <a href="<?php echo e(route('pemesanan.create')); ?>" class="btn btn-outline-light fw-bold">
                <i class="bi bi-cart-plus me-1"></i> Pesan Tiket Sekarang
            </a>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="bg-white text-dark rounded p-3 d-inline-block">
                <small class="text-muted d-block">Total Tiket Aktif Anda</small>
                <span class="fs-4 fw-bold text-primary"><?php echo e($totalTiketSaya); ?> Tiket</span>
            </div>
        </div>
    </div>
</div>

<h6 class="fw-bold mb-3">Destinasi Wisata Populer Pa Ali</h6>
<div class="row g-3 mb-4">
    <?php $__currentLoopData = $destinasiUnggulan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3 col-sm-6">
            <div class="card card-mazer h-100">
                <img src="<?php echo e($d->gambar_url); ?>" class="destinasi-img" alt="<?php echo e($d->nama_wisata); ?>">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-light text-primary mb-2 align-self-start"><?php echo e($d->kategori->nama_kategori); ?></span>
                    <h6 class="fw-bold"><?php echo e($d->nama_wisata); ?></h6>
                    <p class="small text-muted mb-2"><i class="bi bi-geo-alt-fill text-danger"></i> <?php echo e($d->lokasi); ?></p>
                    <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-primary">Rp <?php echo e(number_format($d->harga_tiket, 0, ',', '.')); ?></span>
                        <a href="<?php echo e(route('pemesanan.create', ['destinasi_id' => $d->id])); ?>" class="btn btn-sm btn-primary">Pesan</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="card card-mazer p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Riwayat Pemesanan Terakhir Saya</h6>
        <a href="<?php echo e(route('pemesanan.index')); ?>" class="btn btn-sm btn-outline-primary">Semua Riwayat</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode Booking</th>
                    <th>Destinasi</th>
                    <th>Tgl Kunjungan</th>
                    <th>Tiket</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>E-Ticket</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pesananSaya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-bold"><?php echo e($p->kode_booking); ?></td>
                        <td><?php echo e($p->destinasi->nama_wisata); ?></td>
                        <td><?php echo e($p->tanggal_kunjungan->format('d M Y')); ?></td>
                        <td><?php echo e($p->jumlah_tiket); ?></td>
                        <td>Rp <?php echo e(number_format($p->total_harga, 0, ',', '.')); ?></td>
                        <td>
                            <span class="badge <?php echo e($p->status_pembayaran === 'lunas' ? 'bg-success' : ($p->status_pembayaran === 'pending' ? 'bg-warning text-dark' : 'bg-danger')); ?>">
                                <?php echo e(ucfirst($p->status_pembayaran)); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('pemesanan.eticket', $p->id)); ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-qr-code"></i> Lihat Tiket
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" class="text-center text-muted">Anda belum memiliki riwayat pemesanan tiket.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Keanu_2TID\laragon-6.0-minimal\www\TiketWisataPakAli\resources\views/dashboard/pengunjung.blade.php ENDPATH**/ ?>