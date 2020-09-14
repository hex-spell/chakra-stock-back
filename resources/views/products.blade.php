<html>

<head>
    <style>
        table {
            width: 100%;
            margin-bottom: 10px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            padding: 10px;
            font-size: 1.2rem;
        }

        td {
            padding: 5px;
        }

        .column-names td {
            font-weight: bold;
        }
    </style>
</head>

<body>
    @foreach ($data as $category)
    <table>
        <thead>
            <tr>
                <th>{{ $category->name }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr class="column-names">
                <td>Producto<br></td>
                <td>Precio</td>
            </tr>
            @foreach ($category->products as $product)
            <tr>
                <td>{{$product->name}}</td>
                <td>${{$product->sell_price}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
</body>

</html>