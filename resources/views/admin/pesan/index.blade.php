@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Pesan Pembelian & CS</h2>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Pengirim</th>
                        <th>Subjek</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($semuaPesan as $p)
                    <tr class="{{ $p->status == 'unread' ? 'fw-bold bg-light' : '' }}">
                        <td class="ps-4">{{ $p->pelanggan->nama }}</td>
                        <td>{{ $p->subjek }}</td>
                        <td>
                            @if($p->tipe == 'error')
                                <span class="badge bg-danger">Error</span>
                            @else
                                <span class="badge bg-info text-white">Tanya</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $p->status == 'unread' ? 'bg-warning' : 'bg-secondary' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>{{ $p->created_at->diffForHumans() }}</td>
                        <td class="text-center">
                            <a href="{{ route('pesan.show', $p->id_pesan) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                Baca
                            </a>
                            
                            {{-- Tombol Hapus dengan SweetAlert --}}
                            <form id="delete-form-{{ $p->id_pesan }}" action="{{ route('pesan.destroy', $p->id_pesan) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="confirmDeletePesan('{{ $p->id_pesan }}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada pesan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPT SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Fungsi Konfirmasi Hapus Pesan
    function confirmDeletePesan(id) {
        Swal.fire({
            title: 'Hapus Pesan?',
            text: "Pesan yang dihapus tidak dapat dipulihkan!",
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

    // 2. Alert Sukses Otomatis (Muncul setelah baca atau hapus)
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