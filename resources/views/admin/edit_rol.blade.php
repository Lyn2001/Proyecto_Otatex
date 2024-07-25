<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    
    <style>
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
    </style>    
  </head>
  <body>

    @include('admin.header')
    
    
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">

            <h1>Editar Rol</h1>

            <div class="div_deg">
              <form action="{{ url('update_role/' . $data->id) }}" method="POST">
                  @csrf
                  <input type="text" name="role_name" value="{{ $data->rol_name }}">
                  <input type="text" name="role_description" value="{{ $data->rol_description }}">
                  <input class="btn btn-primary" type="submit" value="Update Role">
              </form>
            </div>


          </div>

      </div>
    </div>
    <!-- JavaScript files-->

    @include('admin.js')
</html>