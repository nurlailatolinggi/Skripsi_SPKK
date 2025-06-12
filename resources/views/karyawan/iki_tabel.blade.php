@extends('layouts.app')

@section('title', 'Upload Indikator Kinerja Individu')
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
      </div>
    </div>
     {{-- <div class="col-12">
         <form method="GET" action="" class="row g-2 align-items-end mb-3">
          <div class="col-12 col-md-4">
            <label for="periode" class="form-label">Bulan & Tahun</label>
            <input type="text" name="periode" id="periode" class="form-control" placeholder="Pilih Bulan & Tahun" autocomplete="off" value={{$periode}}>
          </div>
          <div class="col-12 col-md-4">
            <label for="search" class="form-label">Pencarian</label>
            <input type="text" class="form-control" name="search" id="search" value="{{$search}}">
          </div>
          <div class="col-auto">
            <div class="btn-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
              <a href="{{route('uploadiku.list')}}" class="btn btn-danger">
                <i class="fas fa-times"></i>
              </a>
            </div>
          </div>
      </form>
      </div> --}}

      <form method="GET" action="" class="row g-2 align-items-end mb-3">
          <div class="col-12 col-md-4">
              <label for="periode" class="form-label">Bulan & Tahun</label>
              <input type="month" name="periode" id="periode" class="form-control"
                    value="{{ $periode }}">
          </div>
          <div class="col-12 col-md-4">
              <label for="search" class="form-label">Pencarian</label>
              <input type="text" class="form-control" name="search" id="search" value="{{ $search }}">
          </div>
          <div class="col-auto">
              <div class="btn-group">
                  <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                  <a href="{{ route('uploadiku.list') }}" class="btn btn-danger"><i class="fas fa-times"></i></a>
              </div>
          </div>
      </form>


    <div class="row">
      <div class="col-12">
        <div class="card card-round">
          <form action="" method="GET">
          <div class="card-header">
            <div class="card-head-row">
              <div class="card-title">Tabel IKI</div>
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
                    <th>Unit</th>
                    <th>Dokumen</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                {{-- <tbody>
                  @forelse ($ikis as $iki)
                  @php
                    $uploaded = \App\Models\UploadIki::where([
                      'karyawan_id'=> auth()->user()->karyawan_id,
                      'indikator_iki_id'=> $iki->id,
                    ])->first();
                  @endphp
                  <tr>
                    <td>
                      {{ ($ikis->currentPage() - 1) * $ikis->perPage() + $loop->iteration }}
                    </td>
                    <td>{{ $iki->deskripsi_indikator }}</td>
                    <td>{{ $iki->indikator_keberhasilan }}</td>
                    <td>{{ $iki->unit->nama_unit }}</td>
                    @if ($uploaded)
                    <td>
                      <a href="{{ asset('storage/' . $uploaded->path_file_iki)}}" class="btn btn-info btn-sm" target="_blank"><i class="fas fa-eye"></i></a>
                    </td>
                    {!!tdstatusdokumen($uploaded->status)!!}
                    <td>{{ $uploaded->updated_at->diffForHumans() }}</td>
                    <td>
                      <form action="{{ route('uploadiki.destroy', $uploaded->id) }}" method="POST" style="display:inline" class="form-hapus">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm btn-proses"><i class="fas fa-trash"></i></button>
                      </form>
                    </td>
                    @else
                    <td><i>belum ada file</i></td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                      <button type="button" class="btn btn-primary btnAct" data-bs-toggle="modal" data-bs-target="#modalAct" data-id="{{$iki->id}}">
                        <i class="fas fa-upload"></i>
                      </button>
                    </td>
                    @endif
                  </tr>
                  @empty
                  <tr>
                    <td colspan="100">Tidak ada data ditemukan.</td>
                  </tr>
                  @endforelse
                </tbody> --}}

                <tbody>
                @forelse ($ikis as $iki)
                    @php
                        $uploaded = $uploads[$iki->id] ?? null;
                    @endphp
                    <tr>
                        <td>{{ ($ikis->currentPage() - 1) * $ikis->perPage() + $loop->iteration }}</td>
                        <td>{{ $iki->deskripsi_indikator }}</td>
                        <td>{{ $iki->indikator_keberhasilan }}</td>
                        <td>{{ $iki->unit->nama_unit }}</td>

                        @if ($uploaded)
                            <td>
                                <a href="{{ asset('storage/' . $uploaded->path_file_iki) }}" class="btn btn-info btn-sm" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            {!! tdstatusdokumen($uploaded->status) !!}
                            <td>{{ $uploaded->updated_at->diffForHumans() }}</td>
                            <td>
                                <form action="{{ route('uploadiki.destroy', $uploaded->id) }}" method="POST" class="form-hapus" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        @else
                            <td><i>belum ada file</i></td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                <button type="button" class="btn btn-primary btnAct" data-bs-toggle="modal" data-bs-target="#modalAct" data-id="{{ $iki->id }}">
                                    <i class="fas fa-upload"></i>
                                </button>
                            </td>
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
          <div class="card-footer">
            {{ $ikis->appends(['search' => request('search')])->links() }}
          </div>
        </div>
      </div>
    </div>
    
  </div>
  <!-- Modal -->

  <div class="modal fade" id="modalAct" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalActLabel">Upload Dokumen</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('uploadiki.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="indikator_iki_id" value="">
        <input type="hidden" name="bulan" value="{{$bulan}}">
        <input type="hidden" name="tahun" value="{{$tahun}}">
        <div class="modal-body">
          <div class="mb-3">
            <label for="file" class="form-label">File Dokumen</label>
            <input class="form-control" type="file" id="file" name="file" required>
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
  {{-- <script>
      $('#periode').datepicker({
      format: "mm-yyyy",
      minViewMode: 1,
      autoclose: true,
      orientation: 'bottom',
    });
    const btnAct = $('.btnAct')
    if(btnAct.length){
      $('.btnAct').on('click', function(){
        const indikator_iki_id = $(this).data('id')
        $('[name=indikator_iki_id]').val(indikator_iki_id)
      })
    }
  </script> --}}

<script>
  document.querySelectorAll('.btnAct').forEach(button => {
    button.addEventListener('click', function () {
      const indikatorId = this.getAttribute('data-id');
      const input = document.querySelector('#modalAct input[name="indikator_iki_id"]');
      if (input) {
        input.value = indikatorId;
      }
    });
  });
</script>


@endsection