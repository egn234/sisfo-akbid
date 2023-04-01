            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link <?= ($title == 'Dashboard') ? 'active' : '' ?>" href="<?= url_to('mahasiswa/dashboard') ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Master Data</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#kelolaMD" aria-expanded="false" aria-controls="kelolaMD">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Menu Mahasiswa
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?= ($title == 'Lihat Posting' || $title == 'Jadwal' || $title == 'Nilai' || $title == 'Kuesioner') ? 'show' : '' ?>" id="kelolaMD" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= ($title == 'Lihat Posting') ? 'active' : '' ?>" href="<?= url_to('mahasiswa/posting') ?>">Posting</a>
                                    <a class="nav-link <?= ($title == 'Jadwal') ? 'active' : '' ?>" href="<?= url_to('mahasiswa/jadwal') ?>">Jadwal</a>
                                    <a class="nav-link <?= ($title == 'Nilai') ? 'active' : '' ?>" href="<?= url_to('mahasiswa/nilai') ?>">Nilai</a>
                                    <a class="nav-link <?= ($title == 'Kuesioner') ? 'active' : '' ?>" href="<?= url_to('mahasiswa/kuesioner') ?>">Kuesioner</a>

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