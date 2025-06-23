<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kinerja Karyawan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        h4 { margin-bottom: 0; }
    </style>
</head>
<body>
    <h4>Laporan Kinerja Karyawan - Bulan {{ $bulan }} Tahun {{ $tahun }}</h4>

    @foreach ($rekaps as $unit => $dataUnit)
        <h5>Unit: {{ $unit }}</h5>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Persentase Kinerja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataUnit as $rekap)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $rekap->karyawan->nama_user ?? '-' }}</td>
                        <td>{{ number_format($rekap->persentase_kinerja, 2) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
