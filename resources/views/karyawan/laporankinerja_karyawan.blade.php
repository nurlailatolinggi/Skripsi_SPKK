@extends('layouts.app')

@section('title', 'Laporan Kinerja')
@section('content')
<div class="page-inner">

    <div class="row">
      <div class="col-12">
        <h4 class="page-title">Laporan Kinerja Karyawan Tahun {{ $tahunDipilih }}</h4>
        <form method="GET" action="{{ route('karyawan.laporankinerjakaryawan') }}" class="row g-2 align-items-end mb-3">
          <div class="col-12 col-md-3">
            <label for="periode" class="form-label">Filter Tahun</label>
            <label for="tahun">Pilih Tahun:</label>
            <div>
                <select name="tahun" id="tahun" class="form-select" onchange="this.form.submit()">
                @foreach ($daftarTahun as $tahun)
                    <option value="{{ $tahun }}" {{ $tahun == $tahunDipilih ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endforeach
            </select>
            </div>
          </div>

          <div class="col-auto">
            <div class="btn-group">
                {{-- <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button> --}}
                {{-- <a href="{{route('validator.laporankinerja')}}" class="btn btn-danger"> --}}
                {{-- <a href="" class="btn btn-danger">
                    <i class="fas fa-times"></i> Batal
                </a> --}}
                <a href="#" class="btn btn-primary">
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

                <div class="card-header">
                        @if ($karyawan)
                        <div class="mb-3">
                            <h5 class="mb-1">Nama: {{ $karyawan->nama_user }}</h5>
                            <h6 class="text-muted">Unit: {{ $karyawan->unit->nama_unit ?? '-' }}</h6>
                        </div>
                    @endif
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Persentase Kinerja</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekap as $data)
                                    <tr>
                                        <td>{{ $data->bulan }}</td>
                                        <td>{{ $data->persentase_kinerja }}%</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection