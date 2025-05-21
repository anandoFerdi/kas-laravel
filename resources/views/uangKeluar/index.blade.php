@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Data Uang Keluar</h3>
                </div>
                <div class="card-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <a href="{{ route('uangKeluar.create') }}" class="btn btn-primary mb-2">
                        Tambah
                    </a>
                    <a href="{{ url('/export-pdf-uangKeluar') }}" class="btn btn-success mb-2">Export PDF</a>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Nominal</th>
                                    <th>Keperluan</th>
                                    <th>Tanggal</th>
                                    <th>Nota</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($keluar as $key => $kel)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $kel->nama }}</td>
                                        <td>Rp. {{ number_format($kel->nominal, 0, ',', '.') }}</td>
                                        <td>{{ $kel->keperluan }}</td>
                                        <td>{{ $kel->tanggal }}</td>
                                        <td>
                                            <img src="{{ Storage::url('public/nota/') . $kel->nota }}" class="rounded"
                                                style="width: 150px">
                                        </td>
                                        <td>
                                            <a href="{{ route('uangKeluar.edit', $kel->id) }}"
                                                class="btn btn-primary btn-xs">
                                                Edit
                                            </a>
                                            <a href="{{ route('uangKeluar.destroy', $kel->id) }}"
                                                onclick="notificationBeforeDelete(event, this)"
                                                class="btn btn-danger btn-xs">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>


                            <h3>
                                @php
                                    foreach ($totalKeluar as $tok) {
                                        echo 'Total Pengeluaran Rp. ' . number_format($tok->jumlah, 0, ',', '.');
                                    }
                                @endphp
                            </h3>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
@stop

@push('js')
    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>

    <script>
        $('masuk').DataTable({
            "responsive": true,
        });

        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }
    </script>
    {{-- @endsection --}}
