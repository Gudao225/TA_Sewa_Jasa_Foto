<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<section class="section">
<div class="section-header">
<h1>Halaman Sewa</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Penyewaan</h4>
                    </div>
                    <div class="card-body">
                        <?php if (session()->has('error')): ?>
                            <div class="alert alert-danger">
                                <?= session('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->has('success')): ?>
                            <div class="alert alert-success">
                                <?= session('success') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= site_url('sewa/process') ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label>Pilih Layanan</label>
                                <select name="service_id" class="form-control select2" required>
                                    <option value="">Pilih Layanan</option>
                                    <?php foreach ($services as $service): ?>
                                        <option value="<?= $service['id'] ?>" 
                                                data-price="<?= number_format($service['price'], 0, ',', '.') ?>"
                                                data-description="<?= htmlspecialchars($service['description']) ?>">
                                            <?= $service['name'] ?> - Rp <?= number_format($service['price'], 0, ',', '.') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        <div class="form-group" id="serviceDetails" style="display: none;">
                            <label>Detail Layanan</label>
                            <div class="alert alert-info">
                                <p id="serviceDescription"></p>
                                <p class="mb-0">Harga: <strong id="servicePrice"></strong></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Waktu Acara</label>
                            <input type="datetime-local" name="event_time" class="form-control flatpickr" required>
                        </div>

                        <div class="form-group">
                            <label>Detail Kebutuhan</label>
                            <textarea name="custom_details" class="form-control" rows="4" required 
                                    placeholder="Jelaskan detail kebutuhan Anda..."></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Kirim Permintaan Sewa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
$(document).ready(function() {
    // Inisialisasi Select2
    $('.select2').select2({
        placeholder: "Pilih Layanan",
        allowClear: true
    }).on('change', function() {
        var selectedOption = $(this).find('option:selected');
        if (selectedOption.val()) {
            $('#serviceDescription').text(selectedOption.data('description'));
            $('#servicePrice').text('Rp ' + selectedOption.data('price'));
            $('#serviceDetails').show();
        } else {
            $('#serviceDetails').hide();
        }
    });

    // Inisialisasi Flatpickr
    flatpickr(".flatpickr", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        locale: "id",
        time_24hr: true
    });
});
</script>
          </div>
        </section>
<?= $this->endSection() ?>