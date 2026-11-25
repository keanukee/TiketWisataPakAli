
<?php $__env->startSection('title', 'Validasi E-Ticket QR - Wisata Pa Ali'); ?>
<?php $__env->startSection('page_title', 'Modul Validasi Tiket Masuk (Petugas Loket)'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <div class="col-md-5">
        <div class="card card-mazer p-4">
            <h6 class="fw-bold mb-2"><i class="bi bi-qr-code-scan text-primary me-1"></i> Cek Kode Booking / Scan QR</h6>
            <p class="small text-muted">Masukkan atau scan kode booking pada E-Ticket pengunjung untuk memverifikasi keaslian dan status check-in.</p>
            <form action="<?php echo e(route('validasi.form')); ?>" method="GET">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kode Booking E-Ticket</label>
                    <input type="text" name="kode_booking" class="form-control form-control-lg" placeholder="Contoh: TKT-PAALI-2026001" value="<?php echo e(request('kode_booking')); ?>" required autofocus>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    <i class="bi bi-search me-1"></i> Periksa Tiket
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-7">
        <?php if(request()->filled('kode_booking')): ?>
            <?php if($hasilTiket): ?>
                <div class="card card-mazer p-4 border-start border-5 <?php echo e($hasilTiket->status_pembayaran === 'lunas' ? 'border-success' : 'border-danger'); ?>">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><?php echo e($hasilTiket->kode_booking); ?></h5>
                        <span class="badge <?php echo e($hasilTiket->status_pembayaran === 'lunas' ? 'bg-success' : 'bg-danger'); ?>">
                            <?php echo e(strtoupper($hasilTiket->status_pembayaran)); ?>

                        </span>
                    </div>
                    <p class="mb-1"><strong>Pengunjung:</strong> <?php echo e($hasilTiket->user->name); ?> (<?php echo e($hasilTiket->user->no_hp); ?>)</p>
                    <p class="mb-1"><strong>Destinasi:</strong> <?php echo e($hasilTiket->destinasi->nama_wisata); ?></p>
                    <p class="mb-1"><strong>Tanggal Kunjungan:</strong> <?php echo e($hasilTiket->tanggal_kunjungan->format('d F Y')); ?></p>
                    <p class="mb-3"><strong>Jumlah Pengunjung:</strong> <?php echo e($hasilTiket->jumlah_tiket); ?> Orang</p>

                    <?php if($hasilTiket->status_checkin === 'sudah_checkin'): ?>
                        <div class="alert alert-warning fw-bold mb-0">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> TIKET INI SUDAH CHECK-IN SEBELUMNYA!
                        </div>
                    <?php elseif($hasilTiket->status_pembayaran === 'lunas'): ?>
                        <form action="<?php echo e(route('validasi.checkin', $hasilTiket->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">
                                <i class="bi bi-check-circle-fill me-1"></i> VALIDASI & IZINKAN MASUK (CHECK-IN)
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-danger mb-0">
                            Tiket belum dibayar lunas. Silakan selesaikan pembayaran terlebih dahulu.
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="card card-mazer p-4 text-center text-danger">
                    <i class="bi bi-x-circle display-4 mb-2"></i>
                    <h6 class="fw-bold">Kode Booking Tidak Ditemukan!</h6>
                    <p class="small text-muted mb-0">Pastikan kode E-Ticket yang dimasukkan sudah benar.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Keanu_2TID\laragon-6.0-minimal\www\TiketWisataPakAli\resources\views/pemesanan/validasi.blade.php ENDPATH**/ ?>