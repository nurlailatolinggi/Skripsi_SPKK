@extends('layouts.app')

@section('title', 'Daftar Dokumen IKU Karyawan')
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
      <div class="ms-md-auto py-2 py-md-0">
        <a href="{{route('validasiiku.list')}}" class="btn btn-danger btn-round">Kembali</a>
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
                <tr>
                  <th>Periode :</th>
                  <td>{{getbulandantahun($bulan,$tahun)}}</td>
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
              <div class="card-title">Daftar IKU</div>
              <div class="card-tools"></div>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Deskripsi Indikator</th>
                    <th>Indikator Keberhasilan</th>
                    <th>Dokumen</th>
                    <th>Satus</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($ikus as $iku)
                  @php
                    $uploaded = false;
                    switch ($iku->frekuensi_indikator) {
                      case 'BULANAN':
                        $uploaded = \App\Models\UploadIku::where([
                          'karyawan_id'=> $user->karyawan_id,
                          'indikator_iku_id'=> $iku->id,
                          'tahun'=> (int) $tahun,
                          'bulan'=> (int) $bulan,
                        ])->first();
                      break;
                      case 'TAHUNAN':
                        $uploaded = \App\Models\UploadIku::where([
                          'karyawan_id'=> $user->karyawan_id,
                          'indikator_iku_id'=> $iku->id,
                          'tahun'=> (int) $tahun,
                        ])->first();
                      break;
                    }
                  @endphp
                  <tr>
                    <td>
                      {{ $loop->iteration }}
                    </td>
                    <td>{{ $iku->deskripsi_indikator }}</td>
                    <td>{{ $iku->indikator_keberhasilan }}</td>
                    @if ($uploaded)
                    <td>
                      <a href="{{ asset('storage/' . $uploaded->path_file_iku)}}" class="btn btn-info btn-sm" target="_blank"><i class="fas fa-eye"></i></a>
                    </td>
                    {!!tdstatusdokumen($uploaded->status)!!}
                    <td>
                      <button type="button" class="btn btn-primary btnAct" data-bs-toggle="modal" data-bs-target="#modalAct" data-id="{{$uploaded->id}}" data-status="{{$uploaded->status}}">
                        Validasi
                      </button>
                    </td>
                    @else
                    <td><i>belum ada file</i></td>
                    <td>-</td>
                    <td>-</td>
                    @endif
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
  <!-- Modal -->

  <div class="modal fade" id="modalAct" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalActLabel">Validasi Dokumen</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('validasiiku.update')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="">
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
              <option value="">Pilih Opsi</option>
              <option value="BARU">BARU</option>
              <option value="VALID">VALID</option>
              <option value="TIDAK VALID">TIDAK VALID</option>
            </select>
            @error('role')
              <small class="text-danger">{{$message}}</small>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    const btnAct = $('.btnAct')
    if(btnAct.length){
      $('.btnAct').on('click', function(){
        const id = $(this).data('id')
        const status = $(this).data('status')
        $('[name=id]').val(id)
        $('[name=status]').val(status).trigger('change')
      })
    }
  </script>
@endsection