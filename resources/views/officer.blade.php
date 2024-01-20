@extends('layout.app')
@section('content')
    <div class="container m-3">
        <div class="card">
            <div class="card-header">
                <h3>Data Petugas</h3>
            </div>
            <div class="card-body">
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert" id="myalert">{{ Session::get('success') }}</div>
                @elseif($errors->any())
                    <div class="alert alert-danger" role="alert" id="myalert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                <div class="d-flex justify-content-end mb-4">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#modal-input-officer">Tambah
                        Data</button>
                </div>
                <div class="table-responsive text-nowrap">
                    <table id="table" class="table table-responsive table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($officers as $officer)
                                <tr>
                                    <td>{{ $no += 1 }}</td>
                                    <td>{{ $officer->name }}</td>
                                    <td>{{ $officer->email }}</td>
                                    <td>
                                        <div class="d-flex justify-content-evently">
                                            <div>
                                                <button class="btn btn-primary m-1" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#modal-edit-officer{{ $officer->id }}">Ubah</button>
                                            </div>
                                            <div>
                                                <form action="{{ route('petugas.destroy', $officer->id) }}"
                                                    onclick="return confirm('Yakin??')" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger m-1" type="submit">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="modal-edit-officer{{ $officer->id }}" tabindex="-1"
                                            data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                            aria-labelledby="modalTitleId" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalTitleId">
                                                            Ubah Data Petugas
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('petugas.update',$officer->id) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label class="mb-2" for="">Nama</label>
                                                                <input name="name" value="{{ $officer->name }}"
                                                                    type="text" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="mb-2" for="">Email</label>
                                                                <input name="email" value="{{ $officer->email }}"
                                                                    type="email" class="form-control">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="mb-2" for="">Password</label>
                                                                <input name="password" type="password" class="form-control">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <p>tidak ada data</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-input-officer" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Tambah Data Petugas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('petugas.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="mb-2" for="">Nama</label>
                            <input name="name" type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2" for="">Email</label>
                            <input name="email" type="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="mb-2" for="">Password</label>
                            <input name="password" type="password" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
