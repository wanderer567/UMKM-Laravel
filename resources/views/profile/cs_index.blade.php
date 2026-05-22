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
    
    <h6 class="fw-bold text-dark mb-1 d-flex align-items-center justify-content-center gap-1">
        {{ Auth::user()->nama }}
        @if(Auth::user()->is_vip == 1)
            <span class="badge bg-warning text-dark border border-warning-subtle rounded-pill shadow-sm" style="font-size: 9px; padding: 3px 6px;" data-bs-toggle="tooltip" title="Kamu mendapat diskon 30% untuk semua produk!">
                <i class="bi bi-crown-fill text-danger"></i> VIP
            </span>
        @endif
    </h6>
    
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
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-chat-left-dots me-2 text-primary"></i>Hubungi Customer Service</h5>
                        <p class="text-muted small">Mengalami kendala aplikasi, pembayaran, atau pertanyaan seputar produk HOYOHOYO? Kirim pesan pengaduan di bawah ini.</p>
                        
                        <form action="{{ route('cs.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label small fw-semibold text-secondary">Subjek Masalah</label>
                                    <input type="text" name="subjek" class="form-control rounded-3" placeholder="Contoh: Gagal upload bukti bayar / Tanya Spek Produk" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-semibold text-secondary">Tipe Kategori</label>
                                    <select name="tipe" class="form-select rounded-3" required>
                                        <option value="tanya">Pertanyaan (Tanya)</option>
                                        <option value="error">Kendala Sistem (Error)</option>
                                        <option value="saran">Kritik & Saran</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-secondary">Detail Isi Pesan</label>
                                    <textarea name="isi_pesan" rows="4" class="form-control rounded-3" placeholder="Tuliskan secara detail apa yang bisa kami bantu..." required></textarea>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="bi bi-send me-1"></i> Kirim Tiket Bantuan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-journal-text me-2 text-secondary"></i>Status Tiket Pengaduan Kamu</h5>
                        
                        @if($pesanSaya->isEmpty())
                            <div class="text-center py-4 text-muted small">
                                <i class="bi bi-chat-square-text display-6 d-block mb-2 text-light-emphasis"></i> Belum ada riwayat pesan bantuan yang kamu kirimkan.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Kategori</th>
                                            <th>Subjek Masalah</th>
                                            <th>Status Respon</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pesanSaya as $ps)
                                            <tr>
                                                <td style="font-size: 0.9rem;">{{ $ps->created_at->translatedFormat('d M Y, H:i') }} WIB</td>
                                                <td>
                                                    @if($ps->tipe == 'error')
                                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2">Error</span>
                                                    @elseif($ps->tipe == 'saran')
                                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2">Saran</span>
                                                    @else
                                                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle rounded-pill px-2">Tanya</span>
                                                    @endif
                                                </td>
                                                <td class="fw-semibold text-dark">{{ $ps->subjek }}</td>
                                                <td>
                                                    @if($ps->status == 'unread')
                                                        <span class="badge bg-secondary rounded-pill px-2">Pending</span>
                                                    @elseif($ps->status == 'read')
                                                        <span class="badge bg-primary rounded-pill px-2">Dibaca Admin</span>
                                                    @else
                                                        <span class="badge bg-success rounded-pill px-2"><i class="bi bi-reply-all-fill"></i> Dibalas</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('cs.show', $ps->id_pesan) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                        <i class="bi bi-eye-fill"></i> Detail & Balasan
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500,
            customClass: { popup: 'rounded-4 border-0' }
        });
    @endif
</script>
@endsection