@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Riwayat Transaksi</h2>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">No. Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                    <tr>
                        <td class="ps-4 fw-bold">#TRX-{{ $t->id_transaksi }}</td>
                        <td>{{ $t->pelanggan->nama }}</td>
                        <td>{{ date('d M Y', strtotime($t->tanggal)) }}</td>
                        <td>
                            @if($t->pelanggan->is_vip)
                                <small class="text-muted text-decoration-line-through">
                                    Rp {{ number_format($t->total_harga / 0.7, 0, ',', '.') }}
                                </small>
                                <br>
                                <span class="text-success fw-bold">
                                    Rp {{ number_format($t->total_harga, 0, ',', '.') }} 
                                    <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">Disc 30%</span>
                                </span>
                            @else
                                <span class="fw-bold text-dark">
                                    Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-success rounded-pill px-3">Selesai</span>
                        </td>
                        
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('transaksi.show', $t->id_transaksi) }}" class="btn btn-sm btn-info text-white rounded-pill px-3">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <!-- Tombol Hapus dengan ID unik untuk Form -->
                                <form id="delete-form-{{ $t->id_transaksi }}" action="{{ route('transaksi.destroy', $t->id_transaksi) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger rounded-pill px-3" onclick="confirmDelete('{{ $t->id_transaksi }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada riwayat transaksi.</td>
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
    // 1. Fungsi Konfirmasi Hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data transaksi yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
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

    // 2. Alert Sukses (Muncul jika ada session 'success' dari controller)
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