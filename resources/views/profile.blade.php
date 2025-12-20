@php
    $user = auth()->user();
@endphp

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

<main class="main-content">
    <div class="container">
        <div class="profile-layout">

            <!-- Sidebar -->
            <aside class="profile-sidebar">
                <div class="user-card">
                    <div class="user-avatar">
                        <img
                            id="avatarImage"
                            src="{{ $user->profile_photo
                                ? asset('storage/' . $user->profile_photo)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=2563eb&color=fff&size=120' }}"
                            alt="Avatar"
                        >

                        <!-- tombol kamera -->
                        <button type="button" class="avatar-edit" onclick="changeAvatar()">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>

                    <h3>{{ $user->name }}</h3>
                    <p>{{ $user->email }}</p>
                </div>

                <nav class="sidebar-nav">
                    <a href="javascript:void(0)" class="nav-item active" onclick="switchSection('profile')">
                        <div class="nav-icon"><i class="fas fa-user"></i></div>
                        <span>Profil Saya</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>

                    <a href="{{ route('history') }}" class="nav-item">
                        <div class="nav-icon"><i class="fas fa-history"></i></div>
                        <span>Riwayat Pesanan</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </a>

                     <a href="javascript:void(0)" class="nav-item logout"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                </nav>
            </aside>

            <!-- Content -->
            <div class="profile-content">
                <section id="section-profile" class="content-section active">
                    <div class="section-header">
                        <h2>Informasi Profil</h2>
                    </div>

                    @if(session('success'))
                        <div class="alert-success">{{ session('success') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert-error">
                            <ul>
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="profileForm" class="form-modern"
                          method="POST" action="{{ route('profile.update') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- hidden input foto untuk tombol kamera -->
                        <input type="file" id="profilePhotoInput" name="profile_photo" accept="image/*" hidden>

                        <div class="form-grid">
                            <div class="input-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="input-group">
                                <label>Nomor Telepon</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}">
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="input-group">
                                <label>Email</label>
                                <input type="email" value="{{ $user->email }}" disabled>
                            </div>

                            <div class="input-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="birth_date"
                                       value="{{ old('birth_date', optional($user->birth_date)->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="input-group">
                            <label>Nama Perusahaan (Opsional)</label>
                            <input type="text" name="company_name"
                                   value="{{ old('company_name', $user->company_name) }}">
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </section>
            </div>

        </div>
    </div>
</main>

@endsection

@push('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endpush
