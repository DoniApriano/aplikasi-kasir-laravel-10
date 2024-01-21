@extends('layout.app')
@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h3>Data Pelanggan</h3>
            </div>
            <div class="card-body">
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert" id="myalert">
                        {{ Session::get('success') }}
                    </div>
                @elseif($errors->any())
                    <div class="alert alert-danger" role="alert" id="myalert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#modal-input-customer">
                    Tambah Data Pelanggan
                </button>
                <div class="modal fade" id="modal-input-customer" tabindex="-1" data-bs-backdrop="static"
                    data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitleId">
                                    Tambah Data Pelanggan
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pelanggan.store') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="">Nama</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Nomor Telpon</label>
                                        <input type="text" class="form-control" name="phone_number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Alamat</label>
                                        <input type="text" class="form-control" name="address">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Tutup
                                        </button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table id="table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nomor Telpon</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ $no += 1 }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->phone_number }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>
                                        <div class="d-flex justify-content-evently">
                                            <div class="m-1">
                                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#modal-edit-customer{{ $customer->id }}">Ubah</button>
                                                <div class="modal fade" id="modal-edit-customer{{ $customer->id }}"
                                                    tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                                                    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalTitleId">
                                                                    Ubah Data Pelanggan
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('pelanggan.update',$customer->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="mb-3">
                                                                        <label for="">Nama</label>
                                                                        <input type="text" class="form-control"
                                                                            name="name" value="{{ $customer->name }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="">Nomor Telpon</label>
                                                                        <input type="text" class="form-control"
                                                                            name="phone_number" value="{{ $customer->phone_number }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="">Alamat</label>
                                                                        <input type="text" class="form-control"
                                                                            name="address" value="{{ $customer->address }}">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">
                                                                            Tutup
                                                                        </button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-1">
                                                <form action="{{ route('pelanggan.destroy', $customer->id) }}"
                                                    method="post" onclick="return confirm('Yakin ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
