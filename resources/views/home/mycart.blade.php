<!DOCTYPE html>
<html>

<head>

    @include('home.css')

    <style type="text/css">
    .div_deg{
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 60px;
    }

    table{
        border: 2px solid black;
        text-align: center;
        width: 800px;
        /* border-collapse: collapse;  */
    }

    th{
        border: 2px solid black;
        text-align: center;
        color: white;
        font: 20px;
        font-weight: bold;
        background-color: black;
    }

    td{
        border: 1px solid skyblue;
        text-align: center;
        padding: 8px;
    }

    .cart_value{
        text-align: center;
        margin-bottom: 70px;
        padding: 18px;
    }

    .order_deg{
        width: 300px;
        padding: 20px;
        border: 2px solid black;
        background-color: #f9f9f9;
        border-radius: 10px;
        margin-right: 100px;
    }

    label{
        display: inline-block;
        width: 150px;
    }

    .div_gap{
        padding: 8px;
    }

    </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->
  </div>

  <div class="div_deg">

    <div class="order_deg">
    
        <form action="{{url('confirm_order')}}" method="Post">

            @csrf

            <div class="div_gap">
                <label>Nombre del destinatario</label>

                <input type="text" name="name" value="{{Auth::user()->firstname}} {{Auth::user()->firstlastname}}">
            </div>


            <div class="div_gap">
                <label>Dirección del destinatario</label>

                <textarea name="address">{{Auth::user()->address}}</textarea>
            </div>

            <div class="div_gap">
                <label>Teléfono del destinatario</label>

                <input type="text" name="phone" value="{{Auth::user()->phone1}}">
            </div>

            <div class="div_gap">

                <input class="btn btn-primary" type="submit" value="Place Order">
            </div>

        </form>
    
    </DIV>    

    <table>
        <tr>
            <th>Nombre del Producto</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Eliminar</th>
        </tr>

        <?php 
        $value = 0;
        ?>

        @foreach($cart as $cart)
        <tr>
            <td>{{$cart->product->pro_name}}</td>
            <td>{{$cart->product->pro_price}}</td>
            <td>
                <img width="100" src="/products/{{$cart->product->pro_image}}" alt="">
            </td>
            <td>
                <a class="btn btn-danger" href="{{url('delete_cart',$cart->id)}}">Remove</a>
            </td>
        </tr>

        <?php 
        $value = $value + $cart->product->pro_price;
        ?>

        @endforeach
    </table>
</div>


  <div class="cart_value">
    <h3>El valor total del carrito es: $ {{$value}} </h3>
  </div>


  <!-- info section -->
  @include('home.footer')
</body>

</html>
