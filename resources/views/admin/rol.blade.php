<!DOCTYPE html>
<html>
<head>
    @include('admin.css')

    <style>
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
            color: rgb(255, 255, 255);
            padding: 10px;
            border: 1px solid rgb(0, 0, 0);
        }

        .btn-disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h1>Role</h1>
                <div class="div_deg">
                    <form action="{{ url('add_rol') }}" method="post">
                        @csrf
                        <div>
                            <label for="role_name">Nombre del Rol:</label>
                            <input type="text" name="role_name">
                            <label for="role_description">Descripcion:</label>
                            <input type="text" name="role_description">
                            <input class="btn btn-primary" type="submit" value="Añadir Rol">
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <table class="table_deg">
                    <tr>
                        <th>Nombre del Rol</th>
                        <th>Descripción</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>

                    @foreach($data as $role)
                    <tr>
                        <td>{{ $role->rol_name }}</td>
                        <td>{{ $role->rol_description }}</td>
                        <td>
                            <a class="btn btn-success" href="{{ url('edit_role', $role->id) }}">Editar</a>
                        </td>
                        <td>
                            @if($role->id === 1 || $role->id === 2)
                                <button class="btn btn-danger btn-disabled">Eliminar</button>
                            @else
                                <a class="btn btn-danger" onclick="confirmation(event)" href="{{ url('delete_role', $role->id) }}">Eliminar</a>
                            @endif
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
