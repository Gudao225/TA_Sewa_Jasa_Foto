<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Pesanan Saya</h1>
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
                <h4>Daftar Pesanan Saya</h4>
            </div>
            <div class="card-body">
                <?php if (empty($orders)): ?>
                    <div class="text-center py-5">
                        <h5>Anda belum memiliki pesanan</h5>
                        <p>Silakan pesan layanan fotografi untuk acara Anda</p>
                        <a href="<?= site_url('sewa') ?>" class="btn btn-primary mt-3">Pesan Sekarang</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped" id="ordersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Layanan</th>
                                    <th>Tanggal Acara</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= $order['id'] ?></td>
                                        <td><?= $order['service_name'] ?? 'Custom' ?></td>
                                        <td><?= date('d-m-Y H:i', strtotime($order['event_time'])) ?></td>
                                        <td>
                                            <?php
                                            $badge_class = 'badge-secondary';
                                            switch ($order['status']) {
                                                case 'pending':
                                                    $badge_class = 'badge-warning';
                                                    break;
                                                case 'negotiating':
                                                    $badge_class = 'badge-info';
                                                    break;
                                                case 'accepted':
                                                    $badge_class = 'badge-success';
                                                    break;
                                                case 'rejected':
                                                    $badge_class = 'badge-danger';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?= $badge_class ?>"><?= ucfirst($order['status']) ?></span>
                                        </td>
                                        <td><?= date('d-m-Y', strtotime($order['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= site_url('orders/detail/' . $order['id']) ?>" class="btn btn-primary btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#ordersTable').DataTable();
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>