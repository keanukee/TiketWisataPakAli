
<?php $__env->startSection('title', 'Rekap Laporan Penjualan - Wisata Pa Ali'); ?>
<?php $__env->startSection('page_title', 'Rekap Laporan Penjualan Tiket'); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-mazer p-4 mb-4 no-print">
    <form action="<?php echo e(route('laporan.index')); ?>" method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-semibold">Dari Tanggal Kunjungan</label>
            <input type="date" name="dari" class="form-control" value="<?php echo e($dari); ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Sampai Tanggal</label>
            <input type="date" name="sampai" class="form-control" value="<?php echo e($sampai); ?>">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-filter me-1"></i> Tampilkan</button>
            <button type="button" onclick="window.print()" class="btn btn-outline-dark fw-bold"><i class="bi bi-printer me-1"></i> Cetak Laporan</button>
        </div>
    </form>
</div>

<div class="card card-mazer p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0">Laporan Penjualan Tiket Wisata Pa Ali</h5>
            <small class="text-muted">Periode: <?php echo e(\Carbon\Carbon::parse($dari)->format('d M Y')); ?> s/d <?php echo e(\Carbon\Carbon::parse($sampai)->format('d M Y')); ?></small>
        </div>
        <div class="text-end">
            <div class="small text-muted">Total Pemasukan Lunas</div>
            <h4 class="fw-bold text-success mb-0">Rp <?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?> (<?php echo e($totalTiket); ?> Tiket)</h4>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode Booking</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Pengunjung</th>
                    <th>Destinasi Wisata</th>
                    <th>Metode</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $transaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($i + 1); ?></td>
                        <td class="fw-bold"><?php echo e($t->kode_booking); ?></td>
                        <td><?php echo e($t->tanggal_kunjungan->format('d/m/Y')); ?></td>
                        <td><?php echo e($t->user->name); ?></td>
                        <td><?php echo e($t->destinasi->nama_wisata); ?></td>
                        <td><?php echo e($t->metode_pembayaran); ?></td>
                        <td><?php echo e($t->jumlah_tiket); ?></td>
                        <td class="fw-bold">Rp <?php echo e(number_format($t->total_harga, 0, ',', '.')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="8" class="text-center text-muted">Tidak ada transaksi lunas pada rentang tanggal ini.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Keanu_2TID\laragon-6.0-minimal\www\TiketWisataPakAli\resources\views/pemesanan/laporan.blade.php ENDPATH**/ ?>