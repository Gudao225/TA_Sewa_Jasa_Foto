<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Detail Pesanan #<?= $order['id'] ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="<?= site_url('orders') ?>">Pesanan Saya</a></div>
            <div class="breadcrumb-item active">Detail</div>
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

        <div class="row">
            <!-- Order Information Card -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Pesanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Status:</strong>
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
                        </div>
                        <div class="mb-3">
                            <strong>ID Pesanan:</strong> #<?= $order['id'] ?>
                        </div>
                        <div class="mb-3">
                            <strong>Tanggal Pesan:</strong> <?= date('d-m-Y H:i', strtotime($order['created_at'])) ?>
                        </div>
                        <div class="mb-3">
                            <strong>Tanggal Acara:</strong> <?= date('d-m-Y H:i', strtotime($order['event_time'])) ?>
                        </div>
                        <div class="mb-3">
                            <strong>Layanan:</strong> <?= $order['service_name'] ?? 'Custom' ?>
                        </div>
                        <?php if (isset($order['service_price'])): ?>
                        <div class="mb-3">
                            <strong>Harga Layanan:</strong> Rp. <?= number_format($order['service_price'], 0, ',', '.') ?>
                        </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <strong>Status Penjelasan:</strong>
                            <p class="mt-1">
                                <?php if ($order['status'] == 'pending'): ?>
                                    Pesanan Anda sedang menunggu respon dari admin.
                                <?php elseif ($order['status'] == 'negotiating'): ?>
                                    Pesanan Anda sedang dalam proses negosiasi.
                                <?php elseif ($order['status'] == 'accepted'): ?>
                                    Pesanan Anda telah diterima. Silakan tunggu konfirmasi selanjutnya.
                                <?php elseif ($order['status'] == 'rejected'): ?>
                                    Maaf, pesanan Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Details and Chat -->
            <div class="col-md-8">
                <!-- Order Details Card -->
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Kebutuhan</h4>
                    </div>
                    <div class="card-body">
                        <p><?= nl2br($order['custom_details']) ?></p>
                    </div>
                </div>
                
                <!-- Chat Card -->
                <div class="card chat-box" id="chat-box">
                    <div class="card-header">
                        <h4>Negosiasi dengan Admin</h4>
                    </div>
                    <div class="card-body chat-content" id="chat-content" style="height: 400px; overflow-y: scroll;">
                        <?php if (empty($chats)): ?>
                            <div class="text-center text-muted mt-5">
                                <p>Belum ada pesan. Admin akan menghubungi Anda segera.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($chats as $chat): ?>
                                <?php $isUser = $chat['sender_role'] === 'user'; ?>
                                <div class="chat-item <?= $isUser ? 'chat-right' : 'chat-left' ?>">
                                    <div class="chat-details">
                                        <div class="chat-text"><?= nl2br($chat['message']) ?></div>
                                        <div class="chat-time"><?= $chat['sender_name'] ?> - <?= date('d-m-Y H:i', strtotime($chat['sent_at'])) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer chat-form">
                        <form id="chat-form" action="<?= site_url('orders/send_message') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <div class="input-group">
                                <textarea name="message" class="form-control" placeholder="Ketik pesan..." required></textarea>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Auto scroll to bottom of chat
    var chatContent = document.getElementById('chat-content');
    chatContent.scrollTop = chatContent.scrollHeight;
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>