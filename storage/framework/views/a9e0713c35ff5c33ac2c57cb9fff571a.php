
<?php $__env->startSection('title', 'Pesan Tiket Wisata Pa Ali'); ?>
<?php $__env->startSection('page_title', 'Form Pemesanan & Pembayaran Tiket'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <div class="col-md-7">
        <div class="card card-mazer p-4">
            <h6 class="fw-bold mb-3">Detail Pemesanan Tiket</h6>
            <form action="<?php echo e(route('pemesanan.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Destinasi Wisata</label>
                    <select name="destinasi_id" id="destinasiSelect" class="form-select" required>
                        <?php $__currentLoopData = $destinasiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"
                                data-harga="<?php echo e($item->harga_tiket); ?>"
                                data-kuota="<?php echo e($item->kuota_harian); ?>"
                                <?php echo e((old('destinasi_id', $selectedDestinasi?->id) == $item->id) ? 'selected' : ''); ?>>
                                <?php echo e($item->nama_wisata); ?> - Rp <?php echo e(number_format($item->harga_tiket, 0, ',', '.')); ?>/tiket
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" class="form-control" min="<?php echo e(date('Y-m-d')); ?>" value="<?php echo e(old('tanggal_kunjungan', date('Y-m-d'))); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jumlah Tiket</label>
                        <input type="number" name="jumlah_tiket" id="jumlahTiket" class="form-control" min="1" max="50" value="<?php echo e(old('jumlah_tiket', 1)); ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="form-select" required>
                        <option value="QRIS">QRIS (Dana, OVO, GoPay, ShopeePay, Mobile Banking)</option>
                        <option value="Transfer VA">Virtual Account Bank (BRI, BNI, Mandiri, BCA)</option>
                        <option value="E-Wallet">E-Wallet Instan</option>
                        <option value="Bayar di Loket">Bayar Tunai di Loket Masuk</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" rows="2" class="form-control" placeholder="Contoh: Rombongan keluarga 5 orang..."><?php echo e(old('catatan')); ?></textarea>
                </div>

                <div class="form-check mb-4 p-3 bg-light rounded">
                    <input class="form-check-input ms-0 me-2" type="checkbox" name="bayar_sekarang" value="1" id="bayarSekarang" checked>
                    <label class="form-check-label fw-semibold" for="bayarSekarang">
                        Simulasi Pembayaran Otomatis Lunas Sekarang (Langsung Terbit E-Ticket QR Code)
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                    <i class="bi bi-check2-circle me-1"></i> Konfirmasi & Buat Pesanan
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card card-mazer p-4 bg-white">
            <h6 class="fw-bold mb-3">Ringkasan Biaya Tiket</h6>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Pemesan</span>
                <span class="fw-bold"><?php echo e(auth()->user()->name); ?></span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Harga Satuan</span>
                <span id="hargaSatuanText" class="fw-semibold">Rp 0</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="text-muted">Jumlah Tiket</span>
                <span id="jumlahText" class="fw-semibold">1 Tiket</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold fs-6">Total Pembayaran</span>
                <span id="totalHargaText" class="fs-4 fw-bold text-primary">Rp 0</span>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function hitungTotal() {
        const select = document.getElementById('destinasiSelect');
        const option = select.options[select.selectedIndex];
        const harga = parseFloat(option.getAttribute('data-harga')) || 0;
        const jumlah = parseInt(document.getElementById('jumlahTiket').value) || 1;
        const total = harga * jumlah;

        document.getElementById('hargaSatuanText').innerText = 'Rp ' + harga.toLocaleString('id-ID');
        document.getElementById('jumlahText').innerText = jumlah + ' Tiket';
        document.getElementById('totalHargaText').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
    document.getElementById('destinasiSelect').addEventListener('change', hitungTotal);
    document.getElementById('jumlahTiket').addEventListener('input', hitungTotal);
    hitungTotal();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Keanu_2TID\laragon-6.0-minimal\www\TiketWisataPakAli\resources\views/pemesanan/create.blade.php ENDPATH**/ ?>