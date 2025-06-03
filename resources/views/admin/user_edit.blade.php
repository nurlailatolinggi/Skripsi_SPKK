@extends('layouts.app')

@section('title', 'Edit User')
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
        <a href="{{route('user.list')}}" class="btn btn-danger btn-round">Kembali</a>
      </div>
    </div>
    <form action="{{route('user.update', $user->id)}}" method="POST">
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
                  <label for="nik_user">NIK</label>
                  <input type="text" name="nik_user" id="nik_user" class="form-control" value="{{$user->karyawan->nik_user}}">
                  @error('nik_user')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="nama_user">Nama Lengkap</label>
                  <input type="text" name="nama_user" id="nama_user" class="form-control" value="{{$user->karyawan->nama_user}}">
                  @error('nama_user')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" name="username" id="username" class="form-control" value="{{$user->username}}">
                  @error('username')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password" id="password" class="form-control" value="">
                  @error('password')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="role">Role</label>
                  <select name="role" id="role" class="form-control">
                    <option value="">Pilih Opsi</option>
                    <option value="ADMIN" {{$user->role == 'ADMIN' ?'selected':''}}>ADMIN</option>
                    <option value="VALIDATOR" {{$user->role == 'VALIDATOR' ?'selected':''}}>VALIDATOR</option>
                    <option value="KARYAWAN" {{$user->role == 'KARYAWAN' ?'selected':''}}>KARYAWAN</option>
                  </select>
                  @error('role')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label for="jabatan_id">Jabatan</label>
                  <select name="jabatan_id" id="jabatan_id" class="form-control">
                    <option value="">Pilih Opsi</option>
                    @foreach ($jabatans as $jabatan)
                    <option value="{{$jabatan->id}}" {{$user->karyawan->jabatan_id==$jabatan->id?'selected':''}}>{{$jabatan->nama_jabatan}}</option>
                    @endforeach
                  </select>
                  @error('jabatan_id')
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
                    <option value="{{$unit->id}}" {{$user->karyawan->unit_id==$unit->id?'selected':''}}>{{$unit->nama_unit}}</option>
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