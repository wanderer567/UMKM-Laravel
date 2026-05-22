@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('pesan.index') }}" class="btn btn-outline-secondary rounded-circle me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-0">{{ $pesan->pelanggan->nama }}</h4>
            <small class="text-muted">
                <i class="bi bi-circle-fill text-success" style="font-size: 0.5rem;"></i> Online | {{ $pesan->subjek }}
            </small>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        {{-- Background Chat Container --}}
        <div class="card-body p-4" style="background-color: #e5ddd5; min-height: 500px; background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png'); background-blend-mode: overlay;">
            
            {{-- Tanggal Pesan --}}
            <div class="text-center mb-4">
                <span class="badge bg-white text-dark px-3 rounded-pill shadow-sm small">
                    {{ $pesan->created_at->format('d M Y') }}
                </span>
            </div>

            {{-- 1. Pesan Awal dari Pelanggan (Sisi Kiri) --}}
            <div class="d-flex mb-4">
                <div class="bg-white p-3 rounded-4 shadow-sm position-relative bubble-left" style="max-width: 75%;">
                    @if($pesan->tipe == 'error')
                        <span class="badge bg-danger mb-2">Laporan Error</span>
                    @endif
                    
                    <p class="mb-1 text-dark">{{ $pesan->isi_pesan }}</p>
                    
                    <div class="text-end">
                        <small class="text-muted" style="font-size: 0.7rem;">
                            {{ $pesan->created_at->format('H:i') }}
                        </small>
                    </div>
                </div>
            </div>

            {{-- 2. Looping Balasan dari Database (Sisi Kanan) --}}
            @foreach($pesan->balasan as $balas)
            <div class="d-flex justify-content-end mb-4">
                <div class="p-3 rounded-4 shadow-sm position-relative bubble-right" style="max-width: 75%; background-color: #dcf8c6;">
                    <p class="mb-1 text-dark">{{ $balas->pesan_balasan }}</p>
                    <div class="text-end">
                        <small class="text-muted" style="font-size: 0.7rem;">
                            {{ $balas->created_at->format('H:i') }} <i class="bi bi-check2-all text-primary"></i>
                        </small>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        {{-- Footer: Quick Replies & Input --}}
        <div class="card-footer bg-white border-0 p-3">
            <div class="mb-3 d-flex gap-2 flex-wrap">
                <small class="text-muted d-block w-100 mb-1">Balasan Cepat:</small>
                
                <form action="{{ route('pesan.balas', $pesan->id_pesan) }}" method="POST">
                    @csrf
                    <input type="hidden" name="pesan_balasan" value="Sedang dalam proses">
                    <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill">⌛ Sedang dalam proses</button>
                </form>

                <form action="{{ route('pesan.balas', $pesan->id_pesan) }}" method="POST">
                    @csrf
                    <input type="hidden" name="pesan_balasan" value="Tunggu sebentar admin sedang sibuk">
                    <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill">☕ Admin sedang sibuk</button>
                </form>

                <form action="{{ route('pesan.balas', $pesan->id_pesan) }}" method="POST">
                    @csrf
                    <input type="hidden" name="pesan_balasan" value="Permintaan sudah di proses silahkan di cek">
                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill">✅ Selesai diproses</button>
                </form>
            </div>

            <form action="{{ route('pesan.balas', $pesan->id_pesan) }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="pesan_balasan" class="form-control rounded-pill border-light bg-light px-4" placeholder="Ketik balasan manual..." required>
                    <button class="btn btn-primary rounded-circle ms-2" type="submit">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Bubble kiri (Pelanggan) */
    .bubble-left { border-top-left-radius: 0 !important; }
    .bubble-left::before {
        content: "";
        position: absolute;
        top: 0;
        left: -10px;
        border-width: 10px 10px 0 0;
        border-style: solid;
        border-color: white transparent transparent transparent;
    }

    /* Bubble kanan (Admin) */
    .bubble-right { border-top-right-radius: 0 !important; }
    .bubble-right::before {
        content: "";
        position: absolute;
        top: 0;
        right: -10px;
        border-width: 10px 0 0 10px;
        border-style: solid;
        border-color: #dcf8c6 transparent transparent transparent;
    }
</style>
@endsection