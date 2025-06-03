@extends('layouts.app')

@section('title', 'Laporan Kinerja')
@php
  $bulan = date('m');
  $tahun = date('Y');
  if($periode){
    [$bulan, $tahun] = explode('-', $periode);
  }else{
    $periode = $bulan."-".$tahun;
  }
@endphp
@section('content')
  <div class="page-inner">
    <div
      class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
    >
      <div>
        <h3 class="fw-bold mb-3">@yield('title')</h3>
      </div>
      <div class="ms-md-auto py-2 py-md-0"></div>
    </div>
    <div class="row">
      <div class="col-12">
        <form method="GET" action="" class="row g-2 align-items-end mb-3">
          <div class="col-12 col-md-3">
            <label for="periode" class="form-label">Bulan & Tahun</label>
            <input type="text" name="periode" id="periode" class="form-control" placeholder="Pilih Bulan & Tahun" autocomplete="off" value={{$periode}}>
          </div>
          <div class="col-12 col-md-3">
            <label for="search" class="form-label">Pencarian</label>
            <input type="text" class="form-control" name="search" id="search" value="{{$search}}">
          </div>
          <div class="col-12 col-md-3">
            <label for="unit_id" class="form-label">Unit</label>
            <select name="unit_id" id="unit_id" class="form-control">
              <option value="">Semua</option>
              @foreach ($units as $unit)
                <option value="{{$unit->id}}" {{$unit_id==$unit->id?'selected':''}}>{{$unit->nama_unit}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-auto">
            <div class="btn-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
              <a href="{{route('admin.laporankinerja')}}" class="btn btn-danger">
                <i class="fas fa-times"></i>
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
            <div class="card-head-row">
              <div class="card-title">Daftar</div>
              <div class="card-tools"></div>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Karyawan</th>
                    <th rowspan="2">Unit/Jabatan</th>
                    <th colspan="2" class="text-center">Indikator Kinerja Utama</th>
                    <th colspan="2" class="text-center">Indikator Kinerja Individu</th>
                    <th rowspan="2">Persentase Kinerja</th>
                  </tr>
                  <tr class="text-center">
                    <th>Total</th>
                    <th>Valid</th>
                    <th>Total</th>
                    <th>Valid</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($users as $user)
                  @php
                    $iku = \App\Models\IndikatorIku::count();
                    $ikuvalid = getuploadikubulanandetail([
                      'karyawan_id'=> $user->karyawan_id,
                      'tahun'=> (int) $tahun,
                      'bulan'=> (int) $bulan,
                    ],'VALID') + getuploadikutahunandetail([
                      'karyawan_id'=> $user->karyawan_id,
                      'tahun'=> (int) $tahun,
                    ],'VALID');
                    $iki = getikiunit($user->karyawan->unit_id);
                    $ikivalid = getuploadikidetail([
                      'karyawan_id'=> $user->karyawan_id,
                    ],'VALID');
                  @endphp
                  <tr>
                    <td>
                      {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                    </td>
                    <td>
                      <h5 class="my-0 fw-bold">{{$user->karyawan->nama_user}}</h5>
                      <p class="my-0 text-muted">{{$user->karyawan->nik_user}}</p>
                    </td>
                    <td>
                      {{ $user->karyawan->unit->nama_unit }}/{{ $user->karyawan->jabatan->nama_jabatan }}
                    </td>
                    <td class="text-center">{{$iku}}</td>
                    <td class="text-center">{{$ikuvalid}}</td>
                    <td class="text-center">{{$iki}}</td>
                    <td class="text-center">{{$ikivalid}}</td>
                    <td class="text-center">
                      {!!hitungpersentasekinerja($iku, $ikuvalid, $iki, $ikivalid)!!}%
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="100">Tidak ada data ditemukan.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            {{ $users->appends(['search' => request('search')])->links() }}
          </div>
        </div>
      </div>
    </div>
    
  </div>
  <script>
    $('#periode').datepicker({
      format: "mm-yyyy",
      minViewMode: 1,
      autoclose: true,
      orientation: 'bottom',
    });
  </script>
@endsection