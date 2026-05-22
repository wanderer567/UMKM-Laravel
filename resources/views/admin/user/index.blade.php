@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Manajemen Pelanggan</h2>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            {{ $user->nama }}
                            @if($user->is_vip) 
                                <span class="badge bg-warning text-dark ms-1">VIP</span> 
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info rounded-pill text-white" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $user->id }}">
                                <i class="bi bi-eye me-1"></i> Detail
                            </button>
                            
                            {{-- Tombol Hapus dengan SweetAlert --}}
                            <form id="delete-form-{{ $user->id }}" action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger rounded-pill" onclick="confirmDeleteUser('{{ $user->id }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- MODAL DETAIL -->
                    <div class="modal fade" id="modalDetail{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content border-0 rounded-4">
                                <div class="modal-header border-0 bg-primary text-white rounded-top-4">
                                    <h5 class="modal-title fw-bold">
                                        <i class="bi bi-person-circle me-2"></i> Edit Data: {{ $user->username }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('user.update', $user->id) }}" method="POST">
                                    @csrf 
                                    @method('PUT')
                                    <div class="modal-body p-4">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Nama Lengkap</label>
                                                <input type="text" name="nama" class="form-control rounded-3" value="{{ $user->nama }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Username</label>
                                                <input type="text" name="username" class="form-control rounded-3" value="{{ $user->username }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Email</label>
                                                <input type="email" name="email" class="form-control rounded-3" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">No. WhatsApp/HP</label>
                                                <input type="text" name="hp" class="form-control rounded-3" value="{{ $user->hp }}" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Ganti Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="password" id="passInput{{ $user->id }}" class="form-control rounded-start-3" placeholder="Isi untuk ganti">
                                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePass('passInput{{ $user->id }}')">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    {{-- Tombol Reset dengan SweetAlert --}}
                                                    <button type="button" class="btn btn-outline-danger" onclick="confirmResetPassword('{{ $user->id }}')">
                                                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                                                    </button>
                                                </div>
                                                <small class="text-muted">Isi hanya jika ingin mengganti password manual.</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Status Member</label>
                                                <select name="is_vip" class="form-select rounded-3">
                                                    <option value="0" {{ !$user->is_vip ? 'selected' : '' }}>Reguler (Harga Normal)</option>
                                                    <option value="1" {{ $user->is_vip ? 'selected' : '' }}>VIP (Diskon 30%)</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                                <textarea name="alamat" class="form-control rounded-3" rows="3" required>{{ $user->alamat }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 p-4">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                                    </div>
                                </form>

                                {{-- Form tersembunyi untuk proses reset password --}}
                                <form id="reset-form-{{ $user->id }}" action="{{ route('user.reset-password', $user->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Toggle Lihat Password
    function togglePass(id) {
        const input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }

    // 2. Konfirmasi Hapus User
    function confirmDeleteUser(id) {
        Swal.fire({
            title: 'Hapus Pelanggan?',
            text: "Data akun dan riwayatnya akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }

    // 3. Konfirmasi Reset Password
    function confirmResetPassword(id) {
        Swal.fire({
            title: 'Reset Password?',
            text: "Password akan diubah kembali ke default: 12345678",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#0dcaf0',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Reset!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('reset-form-' + id).submit();
            }
        })
    }

    // 4. Alert Sukses Otomatis
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>
@endsection