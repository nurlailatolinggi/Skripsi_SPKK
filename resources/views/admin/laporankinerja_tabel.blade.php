@extends('layouts.app')
@section('content')

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