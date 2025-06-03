@extends('layouts.app')

@section('title', 'Daftar Indikator Kinerja Individu')
@section('content')
  <div class="page-inner">
    <div
      class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
    >
      <div>
        <h3 class="fw-bold mb-3">@yield('title')</h3>
        {{-- <h6 class="op-7 mb-2">@yield('title') yang terdaftar di SPKK.</h6> --}}
      </div>
      <div class="ms-md-auto py-2 py-md-0">
        <a href="{{route('iki.create')}}" class="btn btn-primary btn-round">Tambah Data</a>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card card-round">
          <form action="" method="GET">
          <div class="card-header">
            <div class="card-head-row">
              <div class="card-title">Tabel IKI</div>
              <div class="card-tools">
                <div class="input-group">
                  <input type="text" class="form-control" name="search" id="search" value="{{$search}}">
                  <div class="input-group-apend">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-search"></i>
                    </button>
                    <a href="{{route('iki.list')}}" class="btn btn-danger">
                      <i class="fas fa-times"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </form>
<!--Tabel IKI-->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Deskripsi Indikator</th>
                    <th>Indikator Keberhasilan</th>
                    <th>Parameter</th>
                    <th>Unit</th>
                    <th>Last Updated</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($ikis as $iki)
                  <tr>
                    <td>
                      {{ ($ikis->currentPage() - 1) * $ikis->perPage() + $loop->iteration }}
                    </td>
                    <td>{{ $iki->deskripsi_indikator }}</td>
                    <td>{{ $iki->indikator_keberhasilan }}</td>
                    <td>{{ $iki->parameter }}</td>
                    <!--relasi ke model Unit-->
                    <td>{{ $iki->unit->nama_unit }}</td> 
                    <td>{{ $iki->updated_at->diffForHumans() }}</td>
                    <td>
                      <a href="{{ route('iki.edit', $iki->id) }}" class="btn btn-warning btn-sm">Edit</a>
                      <form action="{{ route('iki.destroy', $iki->id) }}" method="POST" style="display:inline" class="form-hapus">
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
            {{ $ikis->appends(['search' => request('search')])->links() }}
          </div>
        </div>
      </div>
    </div>
    
  </div>
@endsection