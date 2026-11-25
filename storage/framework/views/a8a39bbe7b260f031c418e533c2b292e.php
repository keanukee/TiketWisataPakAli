
<?php $__env->startSection('title', 'Daftar Pemesanan Tiket - Wisata Pa Ali'); ?>
<?php $__env->startSection('page_title', auth()->user()->isAdmin() ? 'Kelola Semua Pemesanan Tiket' : 'Riwayat Pemesanan & E-Ticket Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-mazer p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <form action="<?php echo e(route('pemesanan.index')); ?>" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari Kode Booking..." value="<?php echo e(request('search')); ?>">
            <select name="status_pembayaran" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="lunas" <?php echo e(request('status_pembayaran') === 'lunas' ? 'selected' : ''); ?>>Lunas</option>
                <option value="pending" <?php echo e(request('status_pembayaran') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="dibatalkan" <?php echo e(request('status_pembayaran') === 'dibatalkan' ? 'selected' : ''); ?>>Dibatalkan</option>
            </select>
            <button class="btn btn-sm btn-outline-primary">Filter</button>
        </form>
        <a href="<?php echo e(route('pemesanan.create')); ?>" class="btn btn-primary btn-sm fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Pesan Tiket Baru
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode Booking</th>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <th>Pemesan</th>
                    <?php endif; ?>
                    <th>Destinasi Wisata</th>
                    <th>Tgl Kunjungan</th>
                    <th>Tiket</th>
                    <th>Total Bayar</th>
                    <th>Pembayaran</th>
                    <th>Check-In</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pemesanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-bold text-primary"><?php echo e($p->kode_booking); ?></td>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <td><?php echo e($p->user->name); ?><br><small class="text-muted"><?php echo e($p->user->no_hp); ?></small></td>
                        <?php endif; ?>
                        <td><?php echo e($p->destinasi->nama_wisata); ?></td>
                        <td><?php echo e($p->tanggal_kunjungan->format('d M Y')); ?></td>
                        <td><?php echo e($p->jumlah_tiket); ?></td>
                        <td class="fw-bold">Rp <?php echo e(number_format($p->total_harga, 0, ',', '.')); ?><br><small class="text-muted"><?php echo e($p->metode_pembayaran); ?></small></td>
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
                            <span class="badge <?php echo e($p->status_checkin === 'sudah_checkin' ? 'bg-info text-dark' : 'bg-light text-muted'); ?>">
                                <?php echo e($p->status_checkin === 'sudah_checkin' ? 'Sudah Masuk' : 'Belum Check-in'); ?>

                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="<?php echo e(route('pemesanan.eticket', $p->id)); ?>" class="btn btn-sm btn-dark" title="Lihat E-Ticket QR">
                                    <i class="bi bi-qr-code"></i>
                                </a>
                                <?php if($p->status_pembayaran === 'pending'): ?>
                                    <form action="<?php echo e(route('pemesanan.bayar', $p->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-sm btn-success" title="Konfirmasi Bayar Lunas"><i class="bi bi-check-lg"></i> Bayar</button>
                                    </form>
                                <?php endif; ?>
                                <a href="<?php echo e(route('pemesanan.edit', $p->id)); ?>" class="btn btn-sm btn-warning" title="Edit Pesanan">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="<?php echo e(route('pemesanan.destroy', $p->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus/membatalkan pesanan ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-danger" title="Hapus Pesanan"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="9" class="text-center text-muted">Belum ada data pemesanan tiket.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($pemesanan->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Keanu_2TID\laragon-6.0-minimal\www\TiketWisataPakAli\resources\views/pemesanan/index.blade.php ENDPATH**/ ?>