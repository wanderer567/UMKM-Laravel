@extends('layouts.pelanggan')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        
        <div class="col-lg-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 bg-white">
                <div class="text-center my-3">
                    <div class="d-inline-block p-2 bg-light rounded-circle mb-3">
                        <i class="bi bi-person-circle display-4 text-primary"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">{{ Auth::user()->nama }}</h6>
                    <small class="text-muted">@<span>{{ Auth::user()->username ?? 'username' }}</span></small>
                </div>
                
                <hr class="text-muted opacity-25 my-3">
                
                <div class="nav flex-column nav-pills gap-1">
                    <a href="{{ route('profile.edit') }}" class="nav-link rounded-3 fw-semibold {{ request()->routeIs('profile.edit') ? 'active bg-primary text-white' : 'text-secondary bg-light-subtle' }}">
                        <i class="bi bi-person-gear me-2"></i> Pengaturan Akun
                    </a>
                    <a href="{{ route('transaksi.history') }}" class="nav-link rounded-3 fw-semibold {{ request()->routeIs('transaksi.history') ? 'active bg-primary text-white' : 'text-secondary bg-light-subtle' }}">
                        <i class="bi bi-bag-check me-2"></i> Riwayat Transaksi
                    </a>
                    <a href="{{ route('cs.index') }}" class="nav-link rounded-3 fw-semibold {{ request()->routeIs('cs.*') ? 'active bg-primary text-white' : 'text-secondary bg-light-subtle' }}">
                        <i class="bi bi-headset me-2"></i> Customer Service
                    </a>
                    <a href="{{ route('home') }}" class="nav-link rounded-3 fw-semibold text-secondary">
                        <i class="bi bi-arrow-left-circle me-2"></i> Kembali Belanja
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row g-4">
                
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                        <h5 class="fw-bold text-dark mb-4"><i class="bi bi-pencil-square me-2 text-primary"></i>Ubah Data Profil</h5>
                        
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('patch')
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="form-control rounded-3 @error('nama') is-invalid @enderror" required>
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light rounded-start-3">@</span>
                                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control rounded-end-3 @error('username') is-invalid @enderror" required>
                                    </div>
                                    @error('username') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary">No. Handphone</label>
                                    <input type="text" name="hp" value="{{ old('hp', $user->hp) }}" class="form-control rounded-3 @error('hp') is-invalid @enderror" required>
                                    @error('hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary">Alamat Email (Statis)</label>
                                    <input type="email" value="{{ $user->email }}" class="form-control rounded-3 bg-light text-muted" readonly disabled>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                        <h5 class="fw-bold text-dark mb-4"><i class="bi bi-shield-lock me-2 text-danger"></i>Ganti Password</h5>
                        
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            @method('put')
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold text-secondary">Password Saat Ini</label>
                                    <div class="input-group">
                                        <input type="password" id="current_password" name="current_password" class="form-control rounded-start-3 @error('current_password', 'updatePassword') is-invalid @enderror" required>
                                        <button class="input-group-text bg-light rounded-end-3" type="button" onclick="togglePassword('current_password', 'icon_current')">
                                            <i class="bi bi-eye" id="icon_current"></i>
                                        </button>
                                    </div>
                                    @error('current_password', 'updatePassword') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold text-secondary">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" class="form-control rounded-start-3 @error('password', 'updatePassword') is-invalid @enderror" required>
                                        <button class="input-group-text bg-light rounded-end-3" type="button" onclick="togglePassword('password', 'icon_new')">
                                            <i class="bi bi-eye" id="icon_new"></i>
                                        </button>
                                    </div>
                                    @error('password', 'updatePassword') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold text-secondary">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control rounded-start-3" required>
                                        <button class="input-group-text bg-light rounded-end-3" type="button" onclick="togglePassword('password_confirmation', 'icon_confirm')">
                                            <i class="bi bi-eye" id="icon_confirm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">Perbarui Password</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fitur Intip/Lihat Password
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("bi-eye");
            toggleIcon.classList.add("bi-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("bi-eye-slash");
            toggleIcon.classList.add("bi-eye");
        }
    }

    // SweetAlert Pengingat Sukses Update Profil
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500,
            background: '#ffffff',
            iconColor: '#0d6efd',
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg'
            }
        });
    @endif

    // SweetAlert Pengingat Sukses Ganti Password
    @if(session('status') === 'password-updated')
        Swal.fire({
            icon: 'success',
            title: 'Sandi Diperbarui!',
            text: 'Password HOYOHOYO kamu telah berhasil diganti.',
            showConfirmButton: false,
            timer: 2500,
            background: '#ffffff',
            iconColor: '#dc3545',
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg'
            }
        });
    @endif
</script>
@endsection