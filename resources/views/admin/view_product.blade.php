<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style type="text/css">

      .div_deg {
          display: flex;
          justify-content: center;
          align-items: center;
          margin-top: 50px;
      }

      .table_deg {
          border: 3px solid greenyellow;
      }

      th{
        background-color: skyblue;
        color: black;
        font-size: 19px;
        font-weight: bold;
        padding: 15px
      }

      td, tr{
        border: 2px solid skyblue;
        text-align: center;
      }

      input[type='search']{
        width: 500px;
        height: 50px;
        margin-left: 40px;
      }

    </style>
  </head>
  <body>

    @include('admin.header')
    @include('admin.sidebar')
    
    <div class="page-content">
      <div class="page-header">
        <div class="container-fluid">


          <form action="{{url('product_search')}}" method="get">
            @csrf
            <input type="search" name="search">
            <input type="submit" class="btn btn-secondary" value="Search">
          </form>


          <div class="div_deg">
            <table class="table_deg">
              <tr>
                <th>Nombre del Porducto</th>
                <th>Descripción</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Editar</th>
                <th>Eliminar</th>
              </tr>

              @foreach ($product as $products)
              <tr>
                <td>{{$products->pro_name}}</td>
                <td>{!!Str::limit($products->pro_description,50)!!}</td>
                <td>{{$products->category}}</td>
                <td>{{$products->pro_price}}</td>
                <td>{{$products->pro_stock}}</td>
                
                <td>
                    <img height="120" width="120" src="products/{{$products->pro_image}}">
                </td>

                <td>
                  <a class="btn btn-success" href="{{url('update_product', $products->id)}}">Editar</a>
                </td>

                <td>
                  <a class="btn btn-danger" onclick="confirmation(event)" href="{{url('delete_product',$products->id)}}">Eliminar</a>
                </td>
              </tr>

              @endforeach

            </table>


          </div>
          <div class="div_deg">
            {{$product->onEachSide(1)->links()}}
          </div>
          
        </div>
      </div>
    </div>
    
    <!-- JavaScript files-->
    @include('admin.js')
  </body>
</html>
