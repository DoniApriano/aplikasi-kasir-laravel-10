@extends('layout.app')
@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h3>Data Transaksi</h3>
            </div>
            <div class="card-body">
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert" id="myalert">
                        {{ Session::get('success') }}
                    </div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger" role="alert" id="myalert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-start">
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#modal-input-transaksi">
                                Tambah Transaksi
                            </button>
                            <div class="modal fade" id="modal-input-transaksi" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Tambah Transaksi
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('transaksi.store') }}" method="post">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="customer_id" class="form-label">Nama Pelanggan</label>
                                                    <select class="form-select form-select-md" name="customer_id"
                                                        id="customer_id">
                                                        <option selected>Pilih Pelanggan</option>
                                                        @foreach ($customers as $customer)
                                                            <option value="{{ $customer->id }}">{{ $customer->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-">
                                                    <input readonly hidden type="date" name="date"
                                                        value="{{ $today }}" id="" class="form-control">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
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
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-success mb-3" data-bs-target="#modal-laporan-transaksi"
                                data-bs-toggle="modal">
                                Cetak Laporan
                            </button>
                            <div class="modal fade" id="modal-laporan-transaksi" tabindex="-1" data-bs-backdrop="static"
                                data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalTitleId">
                                                Cetak Laporan
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('report') }}" method="get">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="">Judul</label>
                                                    <input type="text" name="title" id=""
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="">Tanggal Awal</label>
                                                    <input type="date" name="start_date" id=""
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="">Tanggal Akhir</label>
                                                    <input type="date" name="end_date" id=""
                                                        class="form-control">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Tutup
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">Cetak</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Optional: Place to the bottom of scripts -->
                            <script>
                                const myModal = new bootstrap.Modal(
                                    document.getElementById("modalId"),
                                    options,
                                );
                            </script>

                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table id="table" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>Total Transaksi</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $no += 1 }}</td>
                                    <td>{{ $sale->customer->name }}</td>
                                    <td>Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                    <td>{{ $sale->date }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal-detail-transaksi{{ $sale->id }}">
                                            Detal Transaksi
                                        </button>
                                        <div class="modal fade" id="modal-detail-transaksi{{ $sale->id }}"
                                            tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                                            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalTitleId">
                                                            Detail Transaksi
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Nama Pelanggan : {{ $sale->customer->name }}</p>
                                                        <p>Nomor Telpon : {{ $sale->customer->phone_number }}</p>
                                                        <p>Alamat : {{ $sale->customer->address }}</p>
                                                        <p>Tanggal Transaksi : {{ $sale->date }}</p>
                                                        <div class="table-responsive text-nowrap">
                                                            <table class="table table-hover" id="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Barang</th>
                                                                        <th>Jumlah Barang</th>
                                                                        <th>Sub Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($sale->sale_detail as $sale_detail)
                                                                        <tr>
                                                                            <td>{{ $sale_detail->product->name }}</td>
                                                                            <td>{{ $sale_detail->amount_product }}</td>
                                                                            <td>{{ $sale_detail->sub_total }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <h5 class="text-center mt-3">Total : Rp.
                                                            {{ number_format($sale->total_price, 0, ',', '.') }}</h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Tutup
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
