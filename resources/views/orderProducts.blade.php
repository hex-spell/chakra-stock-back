<html>

<head>
    <style>
        body {
            font-size: 16px;
        }

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
            font-size: 1.2em;
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

        .data {
            padding-top: 5px;
            padding-bottom: 5px;
            padding-right: 5px;
            display: table;
        }

        .data div {
            display: table-cell;
            padding-right: 10px;
        }

        .datacontainer {
            display: block;
            margin-bottom: 20px;
        }

        .date {
            position:absolute;
            top:5px;
            right:5px;
        }

        .space {
            height:50px;
        }
    </style>
</head>

<body>
    <div class="date">
        <b>Fecha</b> : <u>{{$date}}</u>
    </div>
    <div class="space"></div>
    <div class="datacontainer">
        <div class="data">
            <div>
                <b>Cliente</b> : <u>{{$contact->name}}</u>
            </div>
            <div>
                <b>Dirección</b> : <u>{{$contact->address}}</u>
            </div>
        </div>
        <div class="data">
            <div>
                <b>Teléfono</b> : <u>{{$contact->phone}}</u>
            </div>

        </div>
    </div>
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
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>TOTAL: ${{$sum}}</td>
            </tr>
        </tbody>
    </table>

</body>

</html>