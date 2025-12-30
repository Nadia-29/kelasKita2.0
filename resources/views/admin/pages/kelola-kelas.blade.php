@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Kelola Kelas</h2>
        <button class="btn btn-primary">Tambah Kelas</button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Mentor</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Belajar Laravel Dasar</td>
                <td>Sandhika Galih</td>
                <td>Rp 0</td>
                <td>
                    <button class="btn btn-sm btn-warning">Edit</button>
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Mastering React JS</td>
                <td>Dea Afrizal</td>
                <td>Rp 150.000</td>
                <td>
                    <button class="btn btn-sm btn-warning">Edit</button>
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </td>
            </tr>
        </tbody>
    </table>
@endsection