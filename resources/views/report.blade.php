<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>
        <center>{{ $title }}</center>
    </h1>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Nomor Telpon</th>
                <th>Jumlah Transaksi</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $no += 1 }}</td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ $sale->customer->address }}</td>
                    <td>{{ $sale->customer->phone_number }}</td>
                    <td>{{ $sale->total_price }}</td>
                    <td>{{ $sale->date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
