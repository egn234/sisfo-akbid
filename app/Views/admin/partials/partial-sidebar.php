            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link <?=($title == 'Dashboard')?'active':''?>" href="<?= url_to('admin/dashboard') ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Master Data</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#kelolaMD" aria-expanded="false" aria-controls="kelolaMD">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Kelola Pengguna
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?=($title == 'Daftar Mahasiswa' || $title == 'Daftar Dosen' )?'show':''?>" id="kelolaMD" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= ($title == 'Daftar Mahasiswa')?'active':''?>" href="<?= url_to('admin/mahasiswa') ?>">Mahasiswa</a>
                                    <a class="nav-link" href="layout-sidenav-light.html">Dosen</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?= $duser->userType ?>
                    </div>
                </nav>
            </div>