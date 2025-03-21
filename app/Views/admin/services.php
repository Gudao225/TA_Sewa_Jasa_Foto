<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Kelola Layanan</h1>
        <div class="section-header-button">
            <a href="<?= site_url('admin/add_service') ?>" class="btn btn-primary">Tambah Layanan Baru</a>
        </div>
    </div>

    <div class="section-body">
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h4>Daftar Layanan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="servicesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Layanan</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Dibuat Pada</th>
                                <th>Diperbarui Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><?= $service['id'] ?></td>
                                    <td><?= $service['name'] ?></td>
                                    <td><?= substr($service['description'], 0, 100) . (strlen($service['description']) > 100 ? '...' : '') ?></td>
                                    <td>Rp <?= number_format($service['price'], 0, ',', '.') ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($service['created_at'])) ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($service['updated_at'])) ?></td>
                                    <td>
                                        <a href="<?= site_url('admin/edit_service/' . $service['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <button onclick="showDeleteConfirmation('<?= $service['id'] ?>', '<?= $service['name'] ?>')" class="btn btn-danger btn-sm">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus layanan <span id="serviceNameSpan"></span>?</p>
                <p class="text-danger">Peringatan: Layanan yang memiliki pesanan terkait tidak dapat dihapus!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
// Definisikan fungsi showDeleteConfirmation di global scope
function showDeleteConfirmation(id, name) {
    console.log('Showing confirmation for:', id, name);
    document.getElementById('serviceNameSpan').textContent = name;
    
    // Simpan ID untuk digunakan nanti
    document.getElementById('confirmDeleteBtn').setAttribute('data-id', id);
    
    // Tampilkan modal
    var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    myModal.show();
}

// Tambahkan event listener setelah DOM loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded');
    
    // Event listener untuk tombol konfirmasi hapus
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        var serviceId = this.getAttribute('data-id');
        console.log('Delete confirmed for ID:', serviceId);
        if (serviceId) {
            window.location.href = '<?= site_url('admin/delete_service/') ?>' + serviceId;
        }
    });
});
</script>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Script tambahan jika diperlukan -->
<?= $this->endSection() ?>