@extends('layouts.app')

@section('title', 'Laporan Kinerja')
@section('content')
{{-- <div class="page-inner">

    <div class="row">
      <div class="col-12">
        <h4 class="page-title">Laporan Kinerja Seluruh Karyawan</h4>
            <form method="GET" action="" class="row g-2 align-items-end mb-3">
                
                <div class="col-12 col-md-3">
                    <label for="periode" class="form-label">Bulan & Tahun</label>
                    <input type="text" name="periode" id="periode" class="form-control" placeholder="Pilih Bulan & Tahun" autocomplete="off">
                </div>
                <div class="col-12 col-md-3">
                    <label for="search" class="form-label">Pencarian Karyawan</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="Nama karyawan">
                </div>
                <div class="col-12 col-md-3">
                    <label for="unit_id" class="form-label">Unit</label>
                    <select name="unit_id" id="unit_id" class="form-control">
                    <option value="">Pilih Unit</option>
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-auto">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="" class="btn btn-danger">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <a href="" class="btn btn-primary">
                            <i class="fas fa-print"></i> Cetak
                        </a>
                    </div>
                </div>
                
            </form>
      </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-round">
        
                @foreach ($rekap as $unit => $dataUnit)
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Unit: {{ $unit }}</div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Bulan</th>
                                        <th>Persentase Kinerja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataUnit as $data)
                                            <tr>
                                                <td>{{ $data->karyawan->nama_user }}</td>
                                                <td>{{ $data->bulan }}</td>
                                                <td>{{ $data->persentase_kinerja }}%</td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div> --}}

<div class="container">
    <h4>Laporan Kinerja Karyawan</h4>

    <!-- Filter Form -->
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <label for="bulan">Bulan</label>
            <select name="bulan" id="bulan" class="form-select">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="col-md-4">
            <label for="tahun">Tahun</label>
            <select name="tahun" id="tahun" class="form-select">
                @foreach ($tahunList as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search"></i> Filter
            </button>
        </div>
    </form>

    <form action="{{ route('laporan.kinerja.pdf') }}" method="GET" target="_blank" class="mb-3">
        <input type="hidden" name="bulan" value="{{ $bulan }}">
        <input type="hidden" name="tahun" value="{{ $tahun }}">
        <button class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export PDF
        </button>
    </form>


    <!-- Tabel Per Unit -->
    @forelse ($rekaps as $unit => $dataUnit)
        <div class="mb-4">
            <h5 class="text-primary">{{ $unit }}</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Persentase Kinerja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataUnit as $rekap)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rekap->karyawan->nama_user ?? '-' }}</td>
                            <td>{{ number_format($rekap->persentase_kinerja, 2) }} %</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <div class="alert alert-info">Tidak ada data kinerja untuk bulan dan tahun ini.</div>
    @endforelse
</div>
@endsection