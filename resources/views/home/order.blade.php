<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>

    @include('home.css')

    <style type="text/css">
    .div_center{
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 60px;
    }

    table{
        border: 2px solid black;
        text-align: center;
        width:800px;
    }

    th{
        border: 2px solid skyblue;
        background-color: black;
        color: white;
        font-size: 19px;
        font-weight: bold;
        text-align: center;
    }

    td{
        border: 1px solid skyblue;
        padding: 10px;
    }

    </style>

</head>
<body>
    

    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header')

        <div class="div_center">
            <table>
                <tr>
                    <th>Nombre del Producto</th>
                    <th>Precio</th>
                    <th>Estado de Entrega</th>
                    <th>Imagen</th>
                </tr>

                @foreach ($order as $order)
                    
                
                <tr>
                    <td>{{$order->product->pro_name}}</td>
                    <td>{{$order->product->pro_price}}</td>
                    <td>{{$order->status}}</td>
                    <td>
                        <img height="150" width="150" src="products/{{$order->product->pro_image}}">
                    </td>
                </tr>

                @endforeach
            </table>
        </div>



    </div>




    @include('home.footer')

</body>
</html>