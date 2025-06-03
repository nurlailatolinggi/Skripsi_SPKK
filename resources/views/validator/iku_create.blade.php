@extends('layouts.app')

@section('title', 'Tambah Indikator Kinerja Utama')
@section('content')
  <div class="page-inner">
    <div
      class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
    >
      <div>
        <h3 class="fw-bold mb-3">@yield('title')</h3>
        <h6 class="op-7 mb-2">Lengkapi form berikut untuk menambahkan data baru.</h6>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        <a href="{{route('iku.list')}}" class="btn btn-danger btn-round">Kembali</a>
      </div>
    </div>
    <form action="{{route('iku.store')}}" method="POST">
    @csrf
    <div class="row">
      <div class="col-12">
        <div class="card card-round">
          <div class="card-header">
            <div class="card-head-row">
              <div class="card-title">Tambah Indikator Kinerja Utama</div>
              <div class="card-tools"></div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="deskripsi_indikator">Deskripsi Indikator</label>
                  <textarea name="deskripsi_indikator" id="deskripsi_indikator" class="form-control">{{old('deskripsi_indikator')}}</textarea>
                  @error('deskripsi_indikator')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="indikator_keberhasilan">Indikator Keberhasilan</label>
                  <input type="text" name="indikator_keberhasilan" id="indikator_keberhasilan" class="form-control" value="{{old('indikator_keberhasilan')}}">
                  @error('indikator_keberhasilan')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="parameter">Parameter</label>
                  <input type="text" name="parameter" id="parameter" class="form-control" value="{{old('parameter')}}">
                  @error('parameter')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="frekuensi_indikator">Frekuensi Indikator</label>
                  <select name="frekuensi_indikator" id="frekuensi_indikator" class="form-control">
                    <option value="">Pilih Opsi</option>
                    <option value="BULANAN" {{old('frekuensi_indikator') == 'BULANAN' ?'selected':''}}>BULANAN</option>
                    <option value="TAHUNAN" {{old('frekuensi_indikator') == 'TAHUNAN' ?'selected':''}}>TAHUNAN</option>
                  </select>
                  @error('frekuensi_indikator')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>

            </div>
          </div>
          <div class="card-footer d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i>
              <span>Simpan</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    </form>
    
  </div>
@endsection