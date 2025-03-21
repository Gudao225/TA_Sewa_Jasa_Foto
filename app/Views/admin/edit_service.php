<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Edit Layanan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="<?= site_url('admin') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= site_url('admin/services') ?>">Layanan</a></div>
            <div class="breadcrumb-item active">Edit Layanan</div>
        </div>
    </div>

    <div class="section-body">
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h4>Form Edit Layanan</h4>
            </div>
            <div class="card-body">
                <form action="<?= site_url('admin/update_service/' . $service['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label for="name">Nama Layanan</label>
                        <input type="text" class="form-control <?= (isset(session('errors')['name'])) ? 'is-invalid' : '' ?>" 
                               id="name" name="name" value="<?= old('name', $service['name']) ?>" required>
                        <div class="invalid-feedback">
                            <?= session('errors')['name'] ?? '' ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Deskripsi Layanan</label>
                        <textarea class="form-control <?= (isset(session('errors')['description'])) ? 'is-invalid' : '' ?>" 
                                  id="description" name="description" rows="5" required><?= old('description', $service['description']) ?></textarea>
                        <div class="invalid-feedback">
                            <?= session('errors')['description'] ?? '' ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Harga (Rp)</label>
                        <input type="number" class="form-control <?= (isset(session('errors')['price'])) ? 'is-invalid' : '' ?>" 
                               id="price" name="price" value="<?= old('price', $service['price']) ?>" required min="0">
                        <div class="invalid-feedback">
                            <?= session('errors')['price'] ?? '' ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="<?= site_url('admin/services') ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>