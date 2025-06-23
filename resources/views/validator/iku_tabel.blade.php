@extends('layouts.app')

@section('title', 'Daftar Indikator Kinerja Utama')
@section('content')
  <div class="page-inner">
    <div
      class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
    >
      <div>
        <h3 class="fw-bold mb-3">@yield('title')</h3>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        <a href="{{route('iku.create')}}" class="btn btn-primary btn-round">Tambah Data</a>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card card-round">
          <form action="" method="GET">
          <div class="card-header">
            <div class="card-head-row">
              <div class="card-title">Daftar IKU</div>
              <div class="card-tools">
                <div class="input-group">
                  <input type="text" class="form-control" name="search" id="search" value="{{$search}}">
                  <div class="input-group-apend">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{route('iku.list')}}" class="btn btn-danger">
                      <i class="fas fa-times"></i> Batal
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </form>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Deskripsi Indikator</th>
                    <th>Indikator Keberhasilan</th>
                    <th>Parameter</th>
                    <th>Frekuensi Indikator</th>
                    <th>Last Updated</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($ikus as $iku)
                  <tr>
                    <td>
                      {{ ($ikus->currentPage() - 1) * $ikus->perPage() + $loop->iteration }}
                    </td>
                    <td>{{ $iku->deskripsi_indikator }}</td>
                    <td>{{ $iku->indikator_keberhasilan }}</td>
                    <td>{{ $iku->parameter }}</td>
                    <td>{{ $iku->frekuensi_indikator }}</td>
                    <td>{{ $iku->updated_at->diffForHumans() }}</td>
                    <td>
                      <a href="{{ route('iku.edit', $iku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                      <form action="{{ route('iku.destroy', $iku->id) }}" method="POST" style="display:inline" class="form-hapus">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm btn-proses">Hapus</button>
                      </form>
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
            {{ $ikus->appends(['search' => request('search')])->links() }}
          </div>
        </div>
      </div>
    </div>
    
  </div>
@endsection