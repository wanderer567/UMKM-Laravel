@extends('layouts.pelanggan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <div class="mb-3">
                <a href="{{ route('cs.index') }}" class="btn btn-light rounded-pill btn-sm text-secondary fw-semibold px-3 shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pengaduan
                </a>
            </div>

            <div class="card shadow-sm border-0 rounded-4 bg-white mb-4">
                <div class="card-header bg-primary text-white rounded-top-4 p-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-chat-square-quote me-2"></i>Detail Tiket: {{ $pesan->subjek }}</h6>
                    <span class="small opacity-75">{{ $pesan->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                </div>
                <div class="card-body p-4">
                    <div class="mb-2">
                        <span class="small text-secondary d-block mb-1 fw-bold">Pesan Awal Kamu:</span>
                        <div class="bg-light p-3 rounded-3 text-dark text-break">
                            {{ $pesan->isi_pesan }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 bg-white p-4">
                <h6 class="fw-bold text-dark mb-4"><i class="bi bi-chat-left-text text-success me-2"></i>Tanggapan & Respon Obrolan</h6>

                @if($balasan->isEmpty())
                    <div class="text-center py-4 text-muted small bg-light rounded-3">
                        <i class="bi bi-hourglass-split display-6 d-block mb-2 text-warning"></i> Belum ada balasan dari Admin. Mohon ditunggu ya, Syad!
                    </div>
                @else
                    <div class="d-flex flex-column gap-3">
                        @foreach($balasan as $b)
                            <div class="align-self-start bg-success-subtle border border-success-subtle text-dark p-3 rounded-4 shadow-sm" style="max-width: 80%; border-top-left-radius: 0px !important;">
                                <div class="d-flex align-items-center mb-1">
                                    <small class="fw-bold text-success me-2"><i class="bi bi-patch-check-fill"></i> Admin Toko UMKM</small>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $b->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 text-break" style="font-size: 0.95rem;">{{ $b->pesan_balasan }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection