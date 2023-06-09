

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-7">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Halaman login!</h1>
                                    </div>
                                    <?= $this->session->flashdata('pesan'); ?>
                                    <form class="user" method="post" action="<?= base_url('authentifikasi'); ?>">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="email" placeholder="Masukan Email..." value="<?= set_value('email'); ?>" name="email">
                                            <?= form_error('email','<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" placeholder="Password" name="password" value="<?= set_value('password'); ?>">
                                            <?= form_error('password','<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <hr>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('authentifikasi/forgotPassword') ?>">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('authentifikasi/registrasi'); ?>">Registrasi!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    