<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-5 mb-5">

            <h1 class="h1 text-info mt-5 pt-3 text-center font-weight-bold" style="text-shadow: 2px 2px black;"><b>WASLAI REHABDAS PTSI</b> </h1>
            <div class="card o-hidden border-0 shadow-lg mt-0 m-2 mb-5 border-bottom-info">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> GAMBAR-->
                        <div class="col-lg">
                            <div class="pt-2 p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2 font-weight-bold">Login Page</h1>
                                    <hr>
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form class="user" method="post" action="<?= base_url('auth'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <button type="submit" href="index.html" class="btn btn-info btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/') ?>registration">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>