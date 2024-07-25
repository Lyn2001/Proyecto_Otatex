<!DOCTYPE html>
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
        }

        label {
            display: inline-block;
            width: 250px;
            font-size: 18px !important;
            color: rgb(255, 255, 255) !important;
        }

        /* Ajustes para el textarea y los input */
        textarea,
        input[type="text"],
        input[type="number"] {
            width: calc(75% - 138px); /* Ajusta el ancho para textarea y input */
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid black; /* Cambia el color del borde a negro */
            border-radius: 2px;
            font-size: 14px; /* Ajusta el tamaño de fuente según tu preferencia */
            resize: vertical; /* Permite redimensionar verticalmente el textarea */
        }

        select {
            width: calc(53% - 138px); /* Ajusta el ancho para el select */
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid black; /* Cambia el color del borde a negro */
            border-radius: 2px;
            font-size: 14px; /* Ajusta el tamaño de fuente según tu preferencia */
        }

        .input_deg{
          padding: 7px;

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

            <h1>Añadir Producto</h1>

            <div class="div_deg">

                <form action="{{url('upload_product')}}" method="Post" enctype="multipart/form-data">

                  @csrf

                    <div class="input_deg">
                        <label>Nombre del Producto</label>
                        <input type="text" name="producto_name" required>
                    </div>

                    <div class="input_deg">
                        <label>Descripción</label>
                        <textarea name="producto_description" rows="4" required></textarea>
                    </div>

                    <div class="input_deg">
                        <label>Precio</label>
                        <input type="text" name="producto_price">
                    </div>

                    <div class="input_deg">
                        <label>Stock</label>
                        <input type="number" name="producto_stock">
                    </div>

                    <div class="input_deg">
                        <label>Categoria</label>


            <select  name="producto_category" required>

                      <option>Seleccionar una opcion</option>

                @foreach($category as $category)

                  <option value="{{$category->cat_name}}">{{$category->cat_name}}</option>

                @endforeach
                        
            </select>
                    </div>

                    <div class="input_deg">
                        <label>Imagen</label>
                        <input type="file" name="producto_image">
                    </div>

                    <div class="input_deg">
                      <input class="btn btn-success" type="submit" value="Añadir Producto">
                    </div>
                </form>
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
