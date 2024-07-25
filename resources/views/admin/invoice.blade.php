<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <center>

        <h1>Facturacion</h1>

        <h3>Nombre del Cliente: {{$data->name}}</h3>

        <h3>Direccion del Cliente: {{$data->rec_address}}</h3>

        <h3>Teléfono: {{$data->phone}}</h3>

        <h2>Nombre del Producto: {{$data->product->pro_name}}</h2>

        <h2>Precio: {{$data->product->pro_price}}</h2>

        <img height="250" width="300" src="products/{{$data->product->pro_image}}">
    </center>
</body>
</html>