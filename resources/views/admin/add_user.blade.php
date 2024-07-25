<!DOCTYPE html>
{{-- Esto cambie todo por eso me sale en verde es nuevo esto pilas --}}
<html>
<head>
    @include('admin.css')
    <style>
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 60px;
        }

        h1 {
            color: black;
            text-align: center;
        }

        .form-container {
            width: 80%;
            margin: 0 auto;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        label {
            display: inline-block;
            width: 200px; /* Ajusta el ancho según sea necesario */
            font-size: 18px !important;
            color: black !important;
            vertical-align: middle;
        }

        .form-group {
            display: flex;
            align-items: center;
            width: calc(50% - 10px); /* Dos columnas con un espacio entre ellas */
            margin-bottom: 15px;
        }

        textarea,
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"],
        select {
            flex: 1;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid black; /* Cambia el color del borde a negro */
            border-radius: 2px;
            font-size: 14px; /* Ajusta el tamaño de fuente según tu preferencia */
            width: 100%;
        }

        .password-container input[type="password"] {
            width: 25%; /* Asegura que el campo ocupe todo el ancho del contenedor */
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            padding: 8px 16px; /* Aumenta el padding para hacer el botón un poco más grande */
            font-size: 16px; /* Aumenta el tamaño de la fuente */
            margin-top: 20px; /* Añade espacio superior para separar el botón del resto del formulario */
            width: auto; /* Ajusta el ancho del botón según el contenido */
            text-align: center; /* Centra el texto dentro del botón */
            display: inline-block; /* Permite que el botón se ajuste a su contenido y se alinee a la izquierda */
        }

        .full-width {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .password-container {
            position: relative;
            width: 49%;
        }

        .password-container .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: black;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

@include('admin.header')
@include('admin.sidebar')

<!-- Sidebar Navigation end-->
<div class="page-content">
    <div class="page-header">
        <div class="container-fluid form-container">

            <h1>Añadir Usuario</h1>

            <div class="div_deg">
                <form id="addUserForm" action="{{url('upload_user')}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="identification">ID (Cedula)</label>
                        <input type="text" id="identification" name="identification" required>
                    </div>

                    <div class="form-group">
                        <label for="firstname">Primer Nombre</label>
                        <input type="text" id="firstname" name="firstname" required>
                    </div>

                    <div class="form-group">
                        <label for="secondname">Segundo Nombre</label>
                        <input type="text" id="secondname" name="secondname">
                    </div>

                    <div class="form-group">
                        <label for="firstlastname">Primer Apellido</label>
                        <input type="text" id="firstlastname" name="firstlastname" required>
                    </div>

                    <div class="form-group">
                        <label for="secondlastname">Segundo Apellido</label>
                        <input type="text" id="secondlastname" name="secondlastname">
                    </div>

                    <div class="form-group">
                        <label for="email">Correo</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group password-container">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required>
                        <span class="toggle-password" onclick="togglePassword()">👁️</span>
                        @if ($errors->has('password'))
                            <div class="error-message">{{ $errors->first('password') }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="rol">Rol</label>
                        <select id="rol" name="rol_id" required>
                            <option value="">Seleccionar un rol</option>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->rol_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="phone1">Telefónico 1</label>
                        <input type="text" id="phone1" name="phone1" required>
                    </div>

                    <div class="form-group">
                        <label for="phone2">Telefónico 2 (Opcional)</label>
                        <input type="text" id="phone2" name="phone2">
                    </div>

                    <div class="form-group full-width">
                        <label for="address">Dirección</label>
                        <textarea id="address" name="address"></textarea>
                    </div>

                    <div class="form-group">
                        <input class="btn btn-success" type="submit" value="Add User">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- JavaScript files-->
<script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"></script>
<script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
<script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('admincss/js/charts-home.js')}}"></script>
<script src="{{asset('admincss/js/front.js')}}"></script>

<script>
    function togglePassword() {
        var passwordField = document.getElementById('password');
        var toggleIcon = document.querySelector('.toggle-password');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.textContent = '🙈'; // Cambia el icono al estado de mostrar
        } else {
            passwordField.type = 'password';
            toggleIcon.textContent = '👁️'; // Cambia el icono al estado de ocultar
        }
    }

    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        var identification = document.getElementById('identification').value;
        var email = document.getElementById('email').value;
        var phone1 = document.getElementById('phone1').value;
        var phone2 = document.getElementById('phone2').value;
        var password = document.getElementById('password').value;

        var idRegex = /^\d{10}$/;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var phoneRegex = /^\d{10}$/;
        var passwordMinLength = 8;

        if (!idRegex.test(identification)) {
            alert('Identification must be exactly 10 digits.');
            e.preventDefault(); // Evita el envío del formulario
        }

        if (!emailRegex.test(email)) {
            alert('Email address is not valid.');
            e.preventDefault(); // Evita el envío del formulario
        }

        if (!phoneRegex.test(phone1)) {
            alert('Phone 1 must be exactly 10 digits.');
            e.preventDefault(); // Evita el envío del formulario
        }

        if (password.length < passwordMinLength) {
            alert('Password must be at least 8 characters long.');
            e.preventDefault(); // Evita el envío del formulario
        }
    });
</script>

</body>
</html>
