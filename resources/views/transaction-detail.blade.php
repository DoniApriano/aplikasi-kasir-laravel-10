@extends('layout.app')
@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h3>Detail Transaksi</h3>
            </div>
            <div class="card-body">
                @if (Session::has('error'))
                    <div class="alert alert-danger" role="alert" id="myalert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <h5>Nama : {{ $sale->customer->name }}</h5>
                <h5>Nomor Telpon : {{ $sale->customer->phone_number }}</h5>
                <h5>Alamat : {{ $sale->customer->address }}</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-input-product">
                    Tambah Barang
                </button>

                <div class="modal fade" id="modal-input-product" tabindex="-1" role="dialog"
                    aria-labelledby="modalTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitleId">
                                    Tambah Barang
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <form action="{{ route('transaksi.update', $sale->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="product_id" class="form-label">Barang</label>
                                            <select class="form-select form-select-md" name="product_id" id="product_id">
                                                <option selected>Pilih Barang</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} Rp.
                                                        {{ $product->price }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Jumlah Barang</label>
                                            <input type="number" name="amount_product" id="" class="form-control">
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
                </div>

                <div class="table-responsive text-nowrap mt-3">
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Banyak</th>
                                <th>Sub Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales_detail as $sale_detail)
                                <tr>
                                    <td>{{ $no += 1 }}</td>
                                    <td>{{ $sale_detail->product->name }}</td>
                                    <td>{{ $sale_detail->amount_product }}</td>
                                    <td>Rp. {{ number_format($sale_detail->sub_total, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('transaksi.destroy', $sale_detail->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <h3>Total Belanja : Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</h3>
                </div>
                <div class="row">
                    <div class="col">
                        <form action="{{ route('transaksi.cancel',$sale->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="d-flex justify-content-start">
                                <button class="btn btn-danger">Batal</button>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <form action="{{ route('transaksi.finish',$sale->id) }}" method="post">
                                @csrf
                                <button class="btn btn-success text-white">Selesai</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
