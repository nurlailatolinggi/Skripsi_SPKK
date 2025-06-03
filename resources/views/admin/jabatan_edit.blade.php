@extends('layouts.app')

@section('title', 'Edit Jabatan')
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
        <a href="{{route('jabatan.list')}}" class="btn btn-danger btn-round">Kembali</a>
      </div>
    </div>
    <form action="{{route('jabatan.update', $jabatan->id)}}" method="POST">
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
                  <label for="nama_jabatan">Nama Jabatan</label>
                  <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control" value="{{$jabatan->nama_jabatan}}">
                  @error('nama_jabatan')
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