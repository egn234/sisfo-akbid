<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $title ?></title>
    <link href="<?= base_url() ?>/assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>/favicon.ico">
</head>
<style>
    body {
        /* background-color: red !important; */
        background: url(img/background-akbid.jpeg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
</style>

<body class="">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center mt-3">
                                        <img src="<?= base_url('') ?>/img/ikbis_logo.png" class="img-fluid" style="width:200px">
                                    </div>
                                    <h4 class="text-center font-weight-light my-4">
                                        Sistem Informasi Akademik<br>
                                        Annisa
                                    </h4>
                                    <p class="text-center font-weight-light my-4" style="font-size: 20px;">
                                        Login
                                    </p>
                                    <?= session()->getFlashdata('notif'); ?>
                                    <form action="<?= url_to('auth-login') ?>" method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputUsername" type="text" name="username" placeholder="username" />
                                            <label for="inputUsername">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary">Login</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Akademi Kebidanan Annisa Jaya <img src="<?= base_url('') ?>/img/ikbis_logo_t.png" width="25" alt=""></div>
                        <!-- <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div> -->
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
        <?php if (isset($error)) {?>
            alert('<?php echo $msg ?>')
        <?php } ?>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>/assets/js/scripts.js"></script>
</body>

</html>