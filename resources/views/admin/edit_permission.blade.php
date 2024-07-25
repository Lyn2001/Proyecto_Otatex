<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
</head>
<body>

    @include('admin.header')
    
    <style type="text/css">
    .div_deg {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 60px;
        flex-direction: column;
    }
    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        width: 100%; /* Asegura que el contenedor ocupe todo el ancho disponible */
    }
    .form-group label {
        width: 200px; /* Ajusta este valor según tus necesidades */
        text-align: right;
        margin-right: 10px;
    }
    input[type='text'] {
        width: 350px;
        height: 40px;
    }
    textarea.large-textbox {
        width: 500px; /* Ajusta este valor según tus necesidades */
        height: 100px; /* Ajusta este valor según tus necesidades */
    }
    .form-group input, .form-group textarea {
        flex: 1;
    }
    </style>
    
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h1 style="color: black">Editar Permiso</h1>
                <div class="div_deg">
                    <form action="{{ url('update_permission', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" name="name" value="{{ $permission->name }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción:</label>
                            <textarea name="description" class="large-textbox">{{ $permission->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Actualizar Permiso">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.js')
</body>
</html>
