@extends('layouts.layout')
@section('content')
<header>
    <div class="container">
        <h2>Edit Data Uang Masuk</h2>
    </div>
</header>
    <form action="{{route('uangKeluar.update', $keluar->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputNama">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="exampleInputKeperluan" placeholder="Nama" name="nama" value="{{$keluar->nama ?? old('nama')}}">
                        @error('nama') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputNominal">Nominal</label>
                        <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" placeholder="Masukan Nominal" name="nominal" value="{{$keluar->nominal ?? old('nominal')}}">
                        @error('nominal') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputKeperluan">Keperluan</label>
                        <input type="text" class="form-control @error('keperluan') is-invalid @enderror" id="exampleInputKeperluan" placeholder="Keperluan Pengeluaran" name="keperluan" value="{{$keluar->keperluan ?? old('keperluan')}}">
                        @error('keperluan') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputTanggal">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="exampleInputPassword" placeholder="Masukan Tanggal" name="tanggal" value="{{$keluar->tanggal ?? old('tanggal')}}">
                        @error('tanggal') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputNota">Nota</label>
                        <input type="file" class="form-control @error('nota') is-invalid @enderror" id="exampleInputPassword" placeholder="Masukan Gambar Nota" name="nota" value="{{$keluar->nota ?? old('nota')}}">
                        @error('nota') <span class="text-danger">{{$message}}</span> @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{route('uangKeluar.index')}}" class="btn btn-default">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- <script type="text/javascript">
        var nominal = document.getElementById('nominal');
        nominal.addEventListener('keyup', function (e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatmasuk() untuk mengubah angka yang di ketik menjadi format angka
            nominal.value = formatmasuk(this.value, 'Rp ');
        });

        /* Fungsi formatmasuk */
        function formatmasuk(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                nominal = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                nominal += separator + ribuan.join('.');
            }

            nominal = split[1] != undefined ? nominal + ',' + split[1] : nominal;
            return prefix == undefined ? nominal : (nominal ? 'Rp ' + nominal : '');
        }
    </script> --}}
@endsection
