@extends('layouts.app')

@section('title', 'Laporan Kinerja')
@php
  if(!$periode) $periode = date('Y');
  
  $formatter = new \IntlDateFormatter('id_ID', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE, null, null, 'MMMM');
  $bulans = [];
  for ($i = 1; $i <= 12; $i++) {
    $date = mktime(0, 0, 0, $i, 1);
    $bulans[$i] = $formatter->format($date);
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
            <label for="periode" class="form-label">Periode Tahun</label>
            <input type="text" name="periode" id="periode" class="form-control" placeholder="Pilih Periode Tahun" autocomplete="off" value={{$periode}}>
          </div>
          
          <div class="col-auto">
            <div class="btn-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
              <a href="{{route('karyawan.laporankinerja')}}" class="btn btn-danger">
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
          <div class="card-header"></div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <tr>
                  <th>Nama :</th>
                  <td>{{$user->karyawan->nama_user}}</td>
                </tr>
                <tr>
                  <th>Unit :</th>
                  <td>{{$user->karyawan->unit->nama_unit}}</td>
                </tr>
                <tr>
                  <th>Jabatan :</th>
                  <td>{{$user->karyawan->jabatan->nama_jabatan}}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card card-round">
          <div class="card-header">
            <div class="card-head-row">
              <div class="card-title">Daftar Kinerja</div>
              <div class="card-tools"></div>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Periode</th>
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
                  @forelse ($bulans as $key=>$bulan)
                  @php
                    $inputDate = DateTime::createFromFormat('Y-m', "$periode-$key");
                    $today = new DateTime();
                    if($inputDate > $today) continue;
                    $ikuvalid = getuploadikubulanandetail([
                      'karyawan_id'=> $user->karyawan_id,
                      'tahun'=> (int) $periode,
                      'bulan'=> (int) $key,
                    ],'VALID') + getuploadikutahunandetail([
                      'karyawan_id'=> $user->karyawan_id,
                      'tahun'=> (int) $periode,
                    ],'VALID');
                    $ikivalid = getuploadikidetail([
                      'karyawan_id'=> $user->karyawan_id,
                    ],'VALID');
                  @endphp
                  <tr>
                    <td>
                      {{ $loop->iteration }}
                    </td>
                    <td>{{$bulan}} {{$periode}}</td>
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
          <div class="card-footer"></div>
        </div>
      </div>
    </div>
    
  </div>
  <script>
    $('#periode').datepicker({
      format: "yyyy",
      minViewMode: 2,
      autoclose: true,
      orientation: 'bottom',
    });
  </script>
@endsection