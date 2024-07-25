<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style type="text/css">
    
    input[type='text']{
        width: 400px;
        height: 50px;
    }

    .div_deg{
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 30px
    }
    
    .table_deg
    {
      text-align: center;
      margin: auto;
      border: 2px solid yellowgreen;
      margin-top: 50px;
      width: 600px;
    }
    th{
      background-color: skyblue;
      padding: 15px;
      font-size: 20px;
      font-weight: bold;
      color: rgb(8, 8, 8);
      border: 1px solid black;
    }

    td{
      color: rgb(255, 255, 255);
      padding: 10px;
      border: 1px solid rgb(0, 0, 0);
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
            
            <h1 style="color:rgb(0, 0, 0)">Añadir Categoria</h1>

        <div class="div_deg">

            <form action="{{url('add_category')}}" method="post">
              @csrf
              <div>
                <label for="category">Nombre de la Categoría:</label>
                <input type="text" name="category">
                
                <label for="category_description">Descripción:</label>
                <input type="text" name="category_description">
                
                <input class="btn btn-primary" type="submit" value="Añadir Categoria">
            </div>

            </form>

        </div>
            
            </div>

            <div>

              <table class="table_deg">
                <tr>
                  <th>Nombre de Categoria</th>
                  <th> Descripcion</th>

                  <th>Editar</th>
                  <th>Eliminar</th>
                </tr>

                @foreach($data as $data)
                <tr>
                  <td>{{$data->cat_name}}</td>
                  <td>{{$data->cat_description}}</td>

                  <td>
                    <a class="btn btn-success" href="{{url('edit_category', $data->id)}}">Edit</a>
                  </td>



                  <td>
                    <a class="btn btn-danger" onclick="confirmation(event)"
                    href="{{url('delete_category',$data->id)}}">Delete</a>
                  </td>
                </tr>
                @endforeach

              </table>

            </div>

      </div>
    </div>
    <!-- JavaScript files-->

    @include('admin.js')
    
  </body>
</html>