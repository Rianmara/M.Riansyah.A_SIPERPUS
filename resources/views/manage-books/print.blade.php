<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Kode Rak Buku Perpustakaan</title>
    <style>
        th, td{
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1 style="text-align: center;">List Kode Rak Buku Perpustakaan</h1>
    </header>
    <section>
        <table border="1" style="border-collapse: collapse; margin: 0px 10px 0px 10px" >
            <thead>
                <th>No</th>
                <th>Kode Rak Buku</th>
                <th>Nama Rak Buku</th>
            </thead>
            <tbody style="text-align: center;">
                @foreach ($bookshelves as $book)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$book->code}}</td>
                        <td>{{$book->name}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</body>
</html>