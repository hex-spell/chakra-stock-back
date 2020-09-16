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
            text-align: left;
            padding-left: 3px;
            font-size: 1.2rem;
            font-weight: bold;
            border-left: none;
            border-right: none;
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
    <table>
        <thead>
            <tr>
                <th>Cant.<br></th>
                <th>Producto<br></th>
                <th>Precio Uni.<br></th>
                <th>Total.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ticket as $product)
            <tr>
                <td>{{$product->ammount}}</td>
                <td>{{$product->name}}</td>
                <td>${{$product->price}}</td>
                <td>${{$product->total_value}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>