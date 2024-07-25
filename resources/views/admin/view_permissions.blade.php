<!DOCTYPE html>
<html>
<head>
    @include('admin.css')

    <style type="text/css">
        input[type='text'] {
            width: 400px;
            height: 50px;
        }

        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px;
        }

        .table_deg {
            text-align: center;
            margin: auto;
            border: 2px solid yellowgreen;
            margin-top: 50px;
            width: 600px;
        }

        th {
            background-color: skyblue;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            color: rgb(8, 8, 8);
            border: 1px solid black;
        }

        td {
            color: black;
            padding: 10px;
            border: 1px solid rgb(0, 0, 0);
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')
    
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h1 style="color:rgb(0, 0, 0)">Añadir Permiso</h1>

                <div class="div_deg">
                    <form action="{{ url('add_permission') }}" method="post">
                        @csrf
                        <div>
                            <label for="name">Nombre del Permiso:</label>
                            <input type="text" name="name" required>
                            
                            <label for="description">Descripcion:</label>
                            <input type="text" name="description">
                            
                            <input class="btn btn-primary" type="submit" value="Añadir permiso">
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <table class="table_deg">
                    <tr>
                        <th>Nombre Permiso</th>
                        <th>Descripcion</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>

                    @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->description }}</td>

                        <td>
                            <a class="btn btn-success" href="{{ url('edit_permission', $permission->id) }}">Editar</a>
                        </td>

                        <td>
                            <a class="btn btn-danger" onclick="confirmation(event)"
                            href="{{url('delete_permission',$permission->id)}}">Eliminar</a>
                          </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>

    @include('admin.js')
</body>
</html>
