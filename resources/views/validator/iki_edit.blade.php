@extends('layouts.app')

@section('title', 'Edit Indikator Kinerja Individu')
@section('content')
  <div class="page-inner">
    <div
      class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
    >
      <div>
        <h3 class="fw-bold mb-3">@yield('title')</h3>
        <h6 class="op-7 mb-2">Lengkapi form berikut untuk memperbaharui data.</h6>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        <a href="{{route('iki.list')}}" class="btn btn-danger btn-round">Kembali</a>
      </div>
    </div>
    <form action="{{route('iki.update', $iki->id)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
      <div class="col-12">
        <div class="card card-round">
          <div class="card-header">
            <div class="card-head-row">
              <div class="card-title">FORM</div>
              <div class="card-tools"></div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="deskripsi_indikator">Deskripsi Indikator</label>
                  <textarea name="deskripsi_indikator" id="deskripsi_indikator" class="form-control">{{$iki->deskripsi_indikator}}</textarea>
                  @error('deskripsi_indikator')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="indikator_keberhasilan">Indikator Keberhasilan</label>
                  <input type="text" name="indikator_keberhasilan" id="indikator_keberhasilan" class="form-control" value="{{$iki->indikator_keberhasilan}}">
                  @error('indikator_keberhasilan')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="parameter">Parameter</label>
                  <input type="text" name="parameter" id="parameter" class="form-control" value="{{$iki->parameter}}">
                  @error('parameter')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="unit_id">Unit</label>
                  <select name="unit_id" id="unit_id" class="form-control">
                    <option value="">Pilih Opsi</option>
                    @foreach ($units as $unit)
                    <option value="{{$unit->id}}" {{$iki->unit_id==$unit->id?'selected':''}}>{{$unit->nama_unit}}</option>
                    @endforeach
                  </select>
                  @error('unit_id')
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