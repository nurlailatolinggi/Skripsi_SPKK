@extends('layouts.app')

@section('title', 'Laporan Kinerja')
@section('content')
<div class="page-inner">

    <div class="row">
      <div class="col-12">
        <h4 class="page-title">Laporan Kinerja Seluruh Karyawan</h4>
            <form method="GET" action="" class="row g-2 align-items-end mb-3">
                
                <div class="col-12 col-md-3">
                    <label for="periode" class="form-label">Bulan & Tahun</label>
                    {{-- <input type="text" name="periode" id="periode" class="form-control" placeholder="Pilih Bulan & Tahun" autocomplete="off" value={{$periode}}> --}}
                    <input type="text" name="periode" id="periode" class="form-control" placeholder="Pilih Bulan & Tahun" autocomplete="off">
                </div>
                <div class="col-12 col-md-3">
                    <label for="search" class="form-label">Pencarian Karyawan</label>
                    {{-- <input type="text" class="form-control" name="search" id="search" value="{{$search}}"> --}}
                    <input type="text" class="form-control" name="search" id="search" placeholder="Nama karyawan">
                </div>
                <div class="col-12 col-md-3">
                    <label for="unit_id" class="form-label">Unit</label>
                    <select name="unit_id" id="unit_id" class="form-control">
                    <option value="">Pilih Unit</option>
                    {{-- @foreach ($units as $unit) --}}
                        {{-- <option value="{{$unit->id}}" {{$unit_id==$unit->id?'selected':''}}>{{$unit->nama_unit}}</option> --}}
                        <option value=""></option>
                    {{-- @endforeach --}}
                    </select>
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
</div>
@endsection