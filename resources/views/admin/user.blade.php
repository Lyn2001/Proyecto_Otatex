<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style type="text/css">
    
    .div_deg{
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 30px;
    }

    .table_deg{
        text-align: center;
        margin: auto;
        border: 2px solid yellowgreen;
        margin-top: 50px;
    }

    th{
        background-color: skyblue;
        padding: 15px;
        font-size: 20px;
        font-weight: bold;
        color: black;
    }

    td{
        color: rgb(255, 255, 255);
        padding: 10px;
        border: 1px solid skyblue;
    }

    .create-button-container {
            text-align: center; /* Centra el contenido dentro del contenedor */
            margin-bottom: 20px; /* Espacio entre el botón y la tabla */
        }

        .create-button {
            margin-top: 10px; /* Espacio entre el título y el botón */
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


             <!--Esta parte cambie del boton pilas y el stylo que diga boton -->
             <h1>Usuarios</h1>
             <!-- Botón de crear nuevo usuario alineado a la izquierda -->
             <a href="{{ url('add_user') }}" class="btn btn-primary create-button">Añadir nuevo usuario</a>
            
            <div class="div_deg">

                <table class="table_deg">
                <tr>
                    <th>Cedula</th>
                    <th>Primer Nombre</th>
                    <th>Segundo Nombre</th>
                    <th>Primer Apellido</th>
                    <th>Segundo Apellido</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Teléfono 1</th>
                    <th>Teléfono 2</th>
                    <th>Dirección</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>

                @foreach ($data as $data)
                    
               
                <tr>
                    <td>{{$data->identification}}</td>
                    <td>{{$data->firstname}}</td>
                    <td>{{$data->secondname}}</td>
                    <td>{{$data->firstlastname}}</td>
                    <td>{{$data->secondlastname}}</td>
                    <td>{{$data->email}}</td>
                    <td>{{$data->role->rol_name}}</td>
                    <td>{{$data->phone1}}</td>
                    <td>{{$data->phone2}}</td>
                    <td>{{$data->address}}</td>

                    <td>
                        <a class="btn btn-success" href="{{url('edit_user',$data->id)}}">Editar</a>
                    </td>
                    
                    <td>
                        <a class="btn btn-danger" onclick="confirmation(event)" href="{{url('delete_user',$data->id)}}">Eliminar</a>
                    </td>
                </tr>

                @endforeach

                </table>


            </div>


          </div>

      </div>
    </div>
    <!-- JavaScript files-->

    @include('admin.js')
  </body>
</html>