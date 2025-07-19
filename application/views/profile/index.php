<?php $this->load->view('templates/sidebar', $user); ?>
<div class="container-fluid" style="min-height:100vh;background:#f6f8fc;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5 shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4">Profil Saya</h3>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold">Nama</div>
                        <div class="col-sm-9">: <?php echo htmlspecialchars($user['nama'] ?? '-'); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold">Email</div>
                        <div class="col-sm-9">: <?php echo htmlspecialchars($user['email'] ?? '-'); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold">Role</div>
                        <div class="col-sm-9">: <?php echo htmlspecialchars($user['role'] ?? '-'); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold">Username</div>
                        <div class="col-sm-9">: <?php echo htmlspecialchars($user['username'] ?? '-'); ?></div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="btn btn-primary mr-2">Edit Profil</a>
                        <a href="#" class="btn btn-warning">Ganti Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>