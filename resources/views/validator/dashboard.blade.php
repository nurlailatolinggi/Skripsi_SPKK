@extends('layouts.app')

@section('content')

<div class="container">
    <h3 class="mt-3">Dashboard Validator</h3>

    <form method="GET" action="{{ route('validator.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="bulan">Bulan</label>
                <select name="bulan" id="bulan" class="form-control">
                    @for ($b = 1; $b <= 12; $b++)
                        <option value="{{ $b }}" {{ $b == $bulan ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label for="tahun">Tahun</label>
                <select name="tahun" id="tahun" class="form-control">
                    @for ($y = now()->year - 2; $y <= now()->year + 1; $y++)
                        <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </div>
    </form>

    <h4>Daftar Karyawan yang Belum Upload IKI / IKU</h4>

    @foreach($data_per_unit as $unit)
        @if($unit['karyawans']->count() > 0)
        <h6>Unit {{ $unit['nama_unit'] }}</h6>
        <table class="table table-bordered mb-4 table-hover">
            <thead>
                <tr>
                    <th>Nama Karyawan</th>
                    <th>Status IKI</th>
                    <th>Status IKU</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unit['karyawans'] as $karyawan)
                <tr>
                    <td>{{ $karyawan['nama'] }}</td>
                    {{-- <td>{{ $karyawan['iki'] }}</td> --}}
                    <td>
                        @if ($karyawan['iki'] === 'Sudah Upload')
                            <span class="text-success">{{ $karyawan['iki'] }}</span>
                        @elseif ($karyawan['iki'] === 'Belum Upload')
                            <span class="text-danger">{{ $karyawan['iki'] }}</span>
                        @elseif ($karyawan['iki'] === 'Belum Selesai Upload')
                            <span class="text-warning">{{ $karyawan['iki'] }}</span>
                        @else
                            <span>{{ $karyawan['iki'] }}</span>
                        @endif
                    </td>
                    {{-- <td>{{ $karyawan['iku'] }}</td> --}}
                    <td>
                        @if ($karyawan['iku'] === 'Sudah Upload')
                            <span class="text-success">{{ $karyawan['iku'] }}</span>
                        @elseif ($karyawan['iku'] === 'Belum Upload')
                            <span class="text-danger">{{ $karyawan['iku'] }}</span>
                        @elseif ($karyawan['iku'] === 'Belum Selesai Upload')
                            <span class="text-warning">{{ $karyawan['iku'] }}</span>
                        @else
                            <span>{{ $karyawan['iku'] }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    @endforeach

</div>
@endsection