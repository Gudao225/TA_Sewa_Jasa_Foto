<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="section">
    <div class="hero text-center bg-primary text-white py-5" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/img/hero-bg.jpg') center/cover;">
        <div class="container">
            <h1 class="mb-4">Abadikan Momen Berharga Anda</h1>
            <p class="lead mb-4">Kami menyediakan jasa fotografi profesional untuk berbagai kebutuhan</p>
            <a href="<?= site_url('sewa') ?>" class="btn btn-light btn-lg">Pesan Sekarang</a>
        </div>
    </div>
</section>

<!-- Layanan Section -->
<section class="section">
    <div class="container">
        <div class="section-header text-center">
            <h2>Layanan Kami</h2>
            <p class="text-muted">Pilih paket sesuai kebutuhan Anda</p>
        </div>
        
        <div class="row">
            <?php foreach ($services as $service): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= $service['name'] ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Rp <?= number_format($service['price'], 0, ',', '.') ?></h6>
                        <p class="card-text"><?= $service['description'] ?></p>
                        <a href="<?= site_url('sewa?service=' . $service['id']) ?>" class="btn btn-primary">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Keunggulan Section -->
<section class="section bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2>Mengapa Memilih Kami?</h2>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 bg-transparent">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-camera fa-3x text-primary"></i>
                        </div>
                        <h4>Fotografer Profesional</h4>
                        <p>Tim fotografer berpengalaman dengan portfolio yang luas</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 bg-transparent">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-clock fa-3x text-primary"></i>
                        </div>
                        <h4>Tepat Waktu</h4>
                        <p>Pengerjaan dan pengiriman hasil sesuai jadwal yang dijanjikan</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-0 bg-transparent">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-star fa-3x text-primary"></i>
                        </div>
                        <h4>Kualitas Terbaik</h4>
                        <p>Hasil foto berkualitas tinggi dengan editing profesional</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section class="section">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2>Portfolio Kami</h2>
            <p class="text-muted">Beberapa hasil karya terbaik kami</p>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <img src="assets/img/portfolio/1.jpg" alt="Portfolio 1" class="img-fluid rounded">
            </div>
            <div class="col-md-4 mb-4">
                <img src="assets/img/portfolio/2.jpg" alt="Portfolio 2" class="img-fluid rounded">
            </div>
            <div class="col-md-4 mb-4">
                <img src="assets/img/portfolio/3.jpg" alt="Portfolio 3" class="img-fluid rounded">
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="#" class="btn btn-outline-primary">Lihat Semua Portfolio</a>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section class="section bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2>Apa Kata Mereka?</h2>
            <p class="text-muted">Testimoni dari klien kami</p>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-quote-left text-primary"></i>
                        </div>
                        <p class="card-text">"Hasil fotonya sangat memuaskan, fotografernya profesional dan ramah."</p>
                        <footer class="blockquote-footer">Andi Pratama</footer>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-quote-left text-primary"></i>
                        </div>
                        <p class="card-text">"Pengerjaan cepat dan hasilnya sesuai ekspektasi. Recommended!"</p>
                        <footer class="blockquote-footer">Siti Rahma</footer>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-quote-left text-primary"></i>
                        </div>
                        <p class="card-text">"Pelayanan sangat baik, hasil foto berkualitas tinggi."</p>
                        <footer class="blockquote-footer">Budi Santoso</footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section">
    <div class="container text-center">
        <h2 class="mb-4">Siap Mengabadikan Momen Anda?</h2>
        <p class="lead mb-4">Hubungi kami sekarang untuk konsultasi gratis</p>
        <a href="<?= site_url('sewa') ?>" class="btn btn-primary btn-lg">Pesan Sekarang</a>
    </div>
</section>
<?= $this->endSection() ?>