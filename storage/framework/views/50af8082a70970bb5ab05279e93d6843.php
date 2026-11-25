
<?php $__env->startSection('title', 'Dashboard Admin - Wisata Pa Ali'); ?>
<?php $__env->startSection('page_title', 'Dashboard Pengelola (Admin)'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card card-mazer p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-primary"><i class="bi bi-cash-coin"></i></div>
                <div>
                    <small class="text-muted fw-semibold">Total Pendapatan</small>
                    <h5 class="fw-bold mb-0">Rp <?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-mazer p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-success"><i class="bi bi-ticket-detailed-fill"></i></div>
                <div>
                    <small class="text-muted fw-semibold">Tiket Terjual (Lunas)</small>
                    <h5 class="fw-bold mb-0"><?php echo e($totalTiketTerjual); ?> Tiket</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-mazer p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-info"><i class="bi bi-map-fill"></i></div>
                <div>
                    <small class="text-muted fw-semibold">Destinasi Wisata</small>
                    <h5 class="fw-bold mb-0"><?php echo e($totalDestinasi); ?> Wahana</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-mazer p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-warning"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <small class="text-muted fw-semibold">Menunggu Pembayaran</small>
                    <h5 class="fw-bold mb-0"><?php echo e($pesananPending); ?> Pesanan</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-mazer p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Transaksi Pemesanan Tiket Terbaru</h6>
        <a href="<?php echo e(route('pemesanan.index')); ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode Booking</th>
                    <th>Pengunjung</th>
                    <th>Destinasi</th>
                    <th>Tgl Kunjungan</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pesananTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-bold text-primary"><?php echo e($p->kode_booking); ?></td>
                        <td><?php echo e($p->user->name); ?></td>
                        <td><?php echo e($p->destinasi->nama_wisata); ?></td>
                        <td><?php echo e($p->tanggal_kunjungan->format('d M Y')); ?></td>
                        <td><?php echo e($p->jumlah_tiket); ?> Tiket</td>
                        <td>Rp <?php echo e(number_format($p->total_harga, 0, ',', '.')); ?></td>
                        <td>
                            <?php if($p->status_pembayaran === 'lunas'): ?>
                                <span class="badge bg-success">Lunas</span>
                            <?php elseif($p->status_pembayaran === 'pending'): ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Dibatalkan</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('pemesanan.eticket', $p->id)); ?>" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-qr-code"></i> E-Ticket
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="8" class="text-center text-muted">Belum ada transaksi pemesanan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Keanu_2TID\laragon-6.0-minimal\www\TiketWisataPakAli\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>