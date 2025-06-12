@extends('layouts.app')

@section('title', 'Laporan Kinerja')
@section('content')
<div class="page-inner">

    <div class="row">
      <div class="col-12">
        <h4 class="page-title">Laporan Kinerja Karyawan</h4>
        <form method="GET" action="" class="row g-2 align-items-end mb-3">

          <div class="col-12 col-md-3">
            <label for="periode" class="form-label">Filter Tahun</label>
            {{-- <input type="text" name="periode" id="periode" class="form-control" placeholder="Pilih Bulan & Tahun" autocomplete="off" value={{$periode}}> --}}
            <input type="text" name="periode" id="periode" class="form-control" placeholder="Pilih Tahun" autocomplete="off">
          </div>

          <div class="col-auto">
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
                {{-- <a href="{{route('validator.laporankinerja')}}" class="btn btn-danger"> --}}
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

                <div class="card-header">
                    @foreach ($rekap as $d )
                        <h5>Nama : {{ $d->karyawan->nama_user }}</h5>
                        <h5>Unit : {{ $d->karyawan->unit->nama_unit }}</h5>
                    @endforeach
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