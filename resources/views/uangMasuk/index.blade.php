@extends('layouts.layout')
@section('content_header')
    <h1 class="m-0 text-dark">Data Uang Masuk</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Data Uang Masuk</h3>
                </div>
                <div class="card-body">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <a href="{{ route('uangMasuk.create') }}" class="btn btn-primary mb-2"> Tambah </a>
                    <a href="{{ url('/export-pdf-uangMasuk') }}" class="btn btn-success mb-2">Export PDF</a>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nominal</th>
                                    <th>Sumber</th>
                                    <th>Tanggal</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($masuk as $key => $mas)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>Rp. {{ number_format($mas->nominal, 0, ',', '.') }}</td>
                                        <td>{{ $mas->sumber }}</td>
                                        <td>{{ $mas->tanggal }}</td>
                                        <td>

                                            <a href="{{ route('uangMasuk.edit', $mas->id) }}"
                                                class="btn btn-primary btn-xs">
                                                Edit
                                            </a>
                                            <a href="{{ route('uangMasuk.destroy', $mas->id) }}"
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
                                    foreach ($totalMasuk as $tos) {
                                        echo 'Total Pemasukan Rp. ' . number_format($tos->jumlah, 0, ',', '.');
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
