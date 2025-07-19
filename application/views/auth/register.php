<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 430px;
        }

        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .register-body {
            padding: 40px 30px;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="register-card">
                    <div class="register-header">
                        <i class="fas fa-user-plus fa-3x mb-3"></i>
                        <h4 class="mb-0">Registrasi Akun Baru</h4>
                        <p class="mb-0 mt-2">Silakan isi data Anda</p>
                    </div>
                    <div class="register-body">
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?= validation_errors('<div>', '</div>') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        <?= form_open('auth/register', ['id' => 'registerForm']) ?>
                        <div class="mb-3">
                            <label for="nip" class="form-label"><i class="fas fa-id-card me-2"></i>NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip" value="<?= set_value('nip') ?>" placeholder="NIP Pegawai" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label"><i class="fas fa-user me-2"></i>Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name') ?>" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label"><i class="fas fa-lock me-2"></i>Konfirmasi Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
                        </div>
                        <div class="form-group">
                            <label for="role_id">Role</label>
                            <select name="role_id" id="role_id" class="form-control" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="1" <?php echo set_select('role_id', '1'); ?>>Admin</option>
                                <option value="2" <?php echo set_select('role_id', '2'); ?>>Guru</option>
                                <option value="3" <?php echo set_select('role_id', '3'); ?>>Siswa/Pegawai</option>
                            </select>
                            <?php echo form_error('role_id', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-register">
                                <i class="fas fa-user-plus me-2"></i>Daftar
                            </button>
                        </div>
                        <?= form_close() ?>
                        <div class="text-center">
                            <a href="<?= base_url('auth/login') ?>" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>