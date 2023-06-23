            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link <?= ($title == 'Dashboard') ? 'active' : '' ?>" href="<?= url_to('dosen/dashboard') ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Perkuliahan</div>
                            <a class="nav-link <?= ($title == 'Kelola BAP') ? 'active' : '' ?>" href="<?= url_to('dosen/bap') ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Kelola BAP
                            </a>
                            <a class="nav-link <?= ($title == 'Kelola Nilai') ? 'active' : '' ?>" href="<?= url_to('dosen/nilai') ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Kelola Nilai
                            </a>
                            <div class="sb-sidenav-menu-heading">Koordinator</div>
                            <a class="nav-link <?= ($title == 'Kelola Indeks Nilai') ? 'active' : '' ?>" href="<?= url_to('dosen/koordinator') ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Kelola Indeks Nilai
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?= $duser->userType ?>
                    </div>
                </nav>
            </div>