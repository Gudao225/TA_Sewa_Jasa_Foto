<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Dashboard Admin</h1>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pesanan</h4>
                    </div>
                    <div class="card-body">
                        <?= $orders_count ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pending</h4>
                    </div>
                    <div class="card-body">
                        <?= $pending_count ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Negotiating</h4>
                    </div>
                    <div class="card-body">
                        <?= $negotiating_count ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-check"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Accepted</h4>
                    </div>
                    <div class="card-body">
                        <?= $accepted_count ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
        <div class="card">
                <div class="card-header">
                    <h4>Menu Cepat</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= site_url('admin/orders') ?>" class="btn btn-primary btn-lg btn-block mb-4">
                                <i class="fas fa-tasks"></i> Kelola Pesanan
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= site_url('admin/services') ?>" class="btn btn-info btn-lg btn-block mb-4">
                                <i class="fas fa-list"></i> Kelola Layanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>