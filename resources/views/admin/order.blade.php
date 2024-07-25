<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style type="text/css">

        table{
            border: 2px solid skyblue;
            text-align: center;
        }

        th{
            background-color: skyblue;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            color: black;
        }

        td{
            color: rgb(255, 255, 255) ;
            font-weight: bold;
            padding: 10px;
            border: 1px solid skyblue;
        }

        .table_center{
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
  </head>
  <body>

    @include('admin.header')
    
    
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">


            <div class="table_center">

                <table>
                    <tr>
                        <th>Nombre del Cliente</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Estado</th>
                        <th>Cambio de Estado</th>
                        <th>Imprimir PDF</th>

                    </tr>


                    @foreach ($data as $data)
                        
                    <tr>
                        <td>{{$data->name}}</td>
                        <td>{{$data->rec_address}}</td>
                        <td>{{$data->phone}}</td>
                        <td>{{$data->product->pro_name}}</td>
                        <td>{{$data->product->pro_price}}</td>
                        <td>
                            <img width="150" src="products/{{$data->product->pro_image}}" alt="">
                        </td>
                        <td>
                            @if($data->status == 'in progresss')

                            <span style="color: red">{{$data->status}}</span>

                            @elseif($data->status == 'On the way')

                            <span style="color: skyblue">{{$data->status}}</span>

                            @else

                            <span style="color: green">{{$data->status}}</span>

                            @endif
                        </td>
                        <td>
                            <a class="btn btn-success" href="{{url('on_the_way',$data->id)}}">En camino</a>
                            <a class="btn btn-danger" href="{{url('delivered',$data->id)}}">Entregado</a>

                        </td>

                        <td>
                            <a  class="btn btn-secondary" href="{{url('print_pdf',$data->id)}}">Imprimir PDF</a>
                        </td>
                    </tr>

                    @endforeach

                </table>

            </div>

        </div>

      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
  </body>
</html>