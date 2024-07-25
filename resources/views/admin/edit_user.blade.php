<!DOCTYPE html>
<html>
<head>
    @include('admin.css')

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
            width: 100%;
        }

        .form-group label {
            width: 200px;
            text-align: right;
            margin-right: 10px;
        }

        input[type='text'] {
            width: 350px;
            height: 40px;
        }

        textarea.large-textbox {
            width: 500px;
            height: 100px;
        }

        .form-group input, .form-group textarea {
            flex: 1;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h1>Actualizar Usuario</h1>
                <div class="div_deg">
                    <form action="{{ url('update_user', $data->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="usr_identification">Cedula:</label>
                            <input type="text" name="usr_identification" value="{{ $data->identification }}">
                        </div>

                        <div class="form-group">
                            <label for="urs_firstname">Primer Nombre:</label>
                            <input type="text" name="urs_firstname" value="{{ $data->firstname }}">
                        </div>

                        <div class="form-group">
                            <label for="urs_secondname">Segundo Nombre:</label>
                            <input type="text" name="urs_secondname" value="{{ $data->secondname }}">
                        </div>

                        <div class="form-group">
                            <label for="urs_firstlastname">Primer Apellido:</label>
                            <input type="text" name="urs_firstlastname" value="{{ $data->firstlastname }}">
                        </div>

                        <div class="form-group">
                            <label for="urs_secondlastname">Segundo Apellido:</label>
                            <input type="text" name="urs_secondlastname" value="{{ $data->secondlastname }}">
                        </div>

                        <div class="form-group">
                            <label for="correo">Correo:</label>
                            <input type="text" name="correo" value="{{ $data->email }}">
                        </div>

                        <div class="form-group">
                            <label for="urs_rol">Rol:</label>
                            <select name="urs_rol">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $data->rol_id == $role->id ? 'selected' : '' }}>{{ $role->rol_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="urs_phone1">Teléfono 1:</label>
                            <input type="text" name="urs_phone1" value="{{ $data->phone1 }}">
                        </div>

                        <div class="form-group">
                            <label for="urs_phone2">Teléfono 2:</label>
                            <input type="text" name="urs_phone2" value="{{ $data->phone2 }}">
                        </div>

                        <div class="form-group">
                            <label for="urs_direccion">Dirección:</label>
                            <input type="text" name="urs_direccion" value="{{ $data->address }}">
                        </div>

                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Actualizar Usuario">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript files -->
    <script src="{{ asset('admincss/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('admincss/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admincss/js/charts-home.js') }}"></script>
    <script src="{{ asset('admincss/js/front.js') }}"></script>
</body>
</html>
