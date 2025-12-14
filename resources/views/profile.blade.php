    @extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    @endsection

    @section('content')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="profile-layout">
                <!-- Sidebar -->
                <aside class="profile-sidebar">
                    <!-- User Card -->
                    <div class="user-card">
                        <div class="user-avatar">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=2563eb&color=fff&size=120" alt="Avatar" id="avatarImage">
                            <button class="avatar-edit" onclick="changeAvatar()">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <h3 id="userName">John Doe</h3>
                        <p id="userEmail">john.doe@example.com</p>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="sidebar-nav">
                        <a href="javascript:void(0)" class="nav-item active" onclick="switchSection('profile')">
                            <div class="nav-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>Profil Saya</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <a href="history.html" class="nav-item">
                            <div class="nav-icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <span>Riwayat Pesanan</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <a href="javascript:void(0)" class="nav-item" onclick="switchSection('address')">
                            <div class="nav-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span>Alamat</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <a href="javascript:void(0)" class="nav-item" onclick="switchSection('password')">
                            <div class="nav-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <span>Keamanan</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <a href="javascript:void(0)" class="nav-item" onclick="switchSection('settings')">
                            <div class="nav-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <span>Notifikasi</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <a href="javascript:void(0)" class="nav-item logout" onclick="handleLogout()">
                            <div class="nav-icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <span>Keluar</span>
                            <i class="fas fa-chevron-right arrow"></i>
                        </a>
                    </nav>
                </aside>

                <!-- Content Area -->
                <div class="profile-content">
                    <!-- Profile Section -->
                    <section id="section-profile" class="content-section active">
                        <div class="section-header">
                            <h2>Informasi Profil</h2>
                        </div>

                        <form class="form-modern" id="profileForm" onsubmit="handleProfileSubmit(event)">
                            <div class="form-grid">
                                <div class="input-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" id="fullName" value="John Doe" required>
                                </div>
                                <div class="input-group">
                                    <label>Nomor Telepon</label>
                                    <input type="tel" id="phone" value="081234567890" required>
                                </div>
                            </div>

                            <div class="form-grid">
                                <div class="input-group">
                                    <label>Email</label>
                                    <input type="email" id="email" value="john.doe@example.com" required>
                                </div>
                                <div class="input-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" id="birthdate" value="1990-01-01">
                                </div>
                            </div>

                            <div class="input-group">
                                <label>Nama Perusahaan <span class="optional">(Opsional)</span></label>
                                <input type="text" id="company" placeholder="PT. Example Indonesia">
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </section>

                    <!-- Address Section -->
                    <section id="section-address" class="content-section">
                        <div class="section-header">
                            <h2>Alamat Pengiriman</h2>
                            <button class="btn btn-primary btn-sm" onclick="addNewAddress()">
                                <i class="fas fa-plus"></i>
                                Tambah Alamat
                            </button>
                        </div>

                        <div class="address-grid" id="addressList">
                            <!-- Addresses will be rendered here -->
                        </div>
                    </section>

                    <!-- Password Section -->
                    <section id="section-password" class="content-section">
                        <div class="section-header">
                            <h2>Ubah Password</h2>
                        </div>

                        <form class="form-modern" id="passwordForm" onsubmit="handlePasswordSubmit(event)">
                            <div class="input-group">
                                <label>Password Saat Ini</label>
                                <input type="password" id="currentPassword" required>
                            </div>

                            <div class="input-group">
                                <label>Password Baru</label>
                                <input type="password" id="newPassword" required>
                            </div>

                            <div class="input-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" id="confirmPassword" required>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key"></i>
                                    Ubah Password
                                </button>
                            </div>
                        </form>
                    </section>

                    <!-- Settings Section -->
                    <section id="section-settings" class="content-section">
                        <div class="section-header">
                            <h2>Pengaturan Notifikasi</h2>
                        </div>

                        <div class="settings-grid">
                            <div class="setting-card">
                                <div class="setting-info">
                                    <div class="setting-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <h4>Notifikasi Email</h4>
                                        <p>Terima update pesanan via email</p>
                                    </div>
                                </div>
                                <label class="toggle">
                                    <input type="checkbox" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="setting-card">
                                <div class="setting-info">
                                    <div class="setting-icon">
                                        <i class="fab fa-whatsapp"></i>
                                    </div>
                                    <div>
                                        <h4>Notifikasi WhatsApp</h4>
                                        <p>Terima notifikasi via WhatsApp</p>
                                    </div>
                                </div>
                                <label class="toggle">
                                    <input type="checkbox" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="setting-card">
                                <div class="setting-info">
                                    <div class="setting-icon">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <div>
                                        <h4>Newsletter</h4>
                                        <p>Terima tips dan artikel menarik</p>
                                    </div>
                                </div>
                                <label class="toggle">
                                    <input type="checkbox">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    @endsection

    @push('scripts')
    <script src="{{ asset('js/profile.js') }}"></script>
    @endpush