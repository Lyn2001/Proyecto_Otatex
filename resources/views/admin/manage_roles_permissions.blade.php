<!DOCTYPE html>
<html>
<head>
  @include('admin.css')
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  @include('admin.header')
  @include('admin.sidebar')

  <div class="page-content">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header text-center">
              <h1 style="color: black">Administrar Roles y Permisos</h1>
            </div>
            <div class="card-body">
              @foreach ($roles as $role)
                <div class="role mb-4">
                  <h3>{{ $role->rol_name }}</h3>
                  <p>{{ $role->rol_description }}</p>

                  <!-- Formulario para asignar permisos -->
                  <form action="{{ url('assign_permissions', $role->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="permissions">Asignar Permisos:</label>
                      <select name="permissions[]" class="form-control" multiple>
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}" {{ $role->permissions->contains($permission->id) ? 'selected' : '' }}>
                                {{ $permission->name }}
                            </option>
                        @endforeach
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Asignar Permisos</button>
                  </form>

                  <!-- Tabla de permisos asignados -->
                  <table class="table mt-3">
                    <thead>
                      <tr>
                        <th>Permiso</th>
                        <th>Descripción</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($role->permissions as $permission)
                        <tr>
                          <td>{{ $permission->name }}</td>
                          <td>{{ $permission->description }}</td>
                          <td>
                            <form action="{{ url('remove_permission', [$role->id, $permission->id]) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="3">No se han asignado permisos a este rol.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
                <hr>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('admin.js')
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
