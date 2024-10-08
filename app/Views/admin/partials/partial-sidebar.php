            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link <?= ($title == 'Dashboard') ? 'active' : '' ?>" href="<?= url_to('admin/dashboard') ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Master Data</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#kelolaMD" aria-expanded="false" aria-controls="kelolaMD">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Kelola User
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?= ($title == 'Daftar Mahasiswa' || $title == 'Daftar Dosen') ? 'show' : '' ?>" id="kelolaMD" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= ($title == 'Daftar Mahasiswa') ? 'active' : '' ?>" href="<?= url_to('admin/mahasiswa') ?>">Mahasiswa</a>
                                    <a class="nav-link <?= ($title == 'Daftar Dosen') ? 'active' : '' ?>" href="<?= url_to('admin/dosen') ?>">Dosen</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#kelolaPerkuliahan" aria-expanded="false" aria-controls="kelolaMD">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Kelola Perkuliahan
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?= ($title == 'Daftar Prodi' || $title == 'Daftar Mata Kuliah' || $title == 'Kelola Nilai' || $title == 'Daftar Ruangan' || $title == 'Daftar Tahun Ajaran' || $title == 'Daftar Kelas' || $title == 'Kelola Registrasi Matkul') ? 'show' : '' ?>" id="kelolaPerkuliahan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= ($title == 'Daftar Prodi') ? 'active' : '' ?>" href="<?= url_to('admin/prodi') ?>">Program Studi</a>
                                    <a class="nav-link <?= ($title == 'Daftar Tahun Ajaran') ? 'active' : '' ?>" href="<?= url_to('admin/tahun-ajaran') ?>">Tahun Ajaran</a>
                                    <a class="nav-link <?= ($title == 'Daftar Mata Kuliah') ? 'active' : '' ?>" href="<?= url_to('admin/matkul') ?>">Mata Kuliah</a>
                                    <a class="nav-link <?= ($title == 'Daftar Kelas') ? 'active' : '' ?>" href="<?= url_to('admin/kelas') ?>">Kelas</a>
                                    <a class="nav-link <?= ($title == 'Kelola Nilai') ? 'active' : '' ?>" href="<?= url_to('admin/nilai') ?>">Kelola Nilai</a>
                                    <a class="nav-link <?= ($title == 'Daftar Ruangan') ? 'active' : '' ?>" href="<?= url_to('admin/ruangan') ?>">Ruangan</a>
                                    <a class="nav-link <?= ($title == 'Kelola Registrasi Matkul') ? 'active' : '' ?>" href="<?= url_to('admin/registrasi') ?>">Registrasi Matkul</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#kelolaInformasi" aria-expanded="false" aria-controls="kelolaMD">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Kelola Informasi
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?= ($title == 'Daftar Posting') ? 'show' : '' ?>" id="kelolaInformasi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= ($title == 'Daftar Posting') ? 'active' : '' ?>" href="<?= url_to('admin/posting') ?>">Posting</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#kelolaKuesioner" aria-expanded="false" aria-controls="kelolaKuesioner">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Kelola Kuesioner
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse <?= ($title == 'Daftar Kuesioner') ? 'show' : '' ?>" id="kelolaKuesioner" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?= ($title == 'Daftar Kuesioner') ? 'active' : '' ?>" href="<?= url_to('admin/kuesioner') ?>">Kuesioner</a>
                                </nav>
                            </div>
                            <a class="nav-link <?= ($title == 'Daftar Kordinator Mata Kuliah') ? 'active' : '' ?>" href="<?= url_to('admin/kordinator') ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Kelola Kordinator Mata Kuliah
                            </a>
                            <a class="nav-link <?= ($title == 'Daftar Jadwal') ? 'active' : '' ?>" href="<?= url_to('admin/jadwal') ?>">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Kelola Jadwal
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?= $duser->userType ?>
                    </div>
                </nav>
            </div>