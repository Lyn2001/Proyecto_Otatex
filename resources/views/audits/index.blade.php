<!DOCTYPE html>
<html>
<head>
    @include('admin.css')
    <style type="text/css">
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
            flex-direction: column;
        }

        .table_deg {
            border: 3px solid greenyellow;
            border-collapse: collapse;
            width: 90%;
        }

        th {
            background-color: skyblue;
            color: black;
            font-size: 19px;
            font-weight: bold;
            padding: 15px;
        }

        td,
        tr {
            border: 2px solid skyblue;
            text-align: center;
            padding: 10px;
        }

        input[type='search'] {
            width: 500px;
            height: 50px;
            margin-left: 40px;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 5px;
            text-align: left;
        }

        .field-name {
            font-weight: bold;
        }
    </style>
</head>
<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <form action="{{ route('audits.index') }}" method="get">
                    @csrf
                    <input type="search" name="search" placeholder="Buscar auditorías...">
                    <input type="submit" class="btn btn-secondary" value="Buscar">
                </form>

                <div class="div_deg">
                    <table class="table_deg">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Tipo de Evento</th>
                                <th>Modelo Auditado</th>
                                <th>Valores Anteriores</th>
                                <th>Valores Nuevos</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($audits as $audit)
                                <tr>
                                    <td>{{ $audit->id }}</td>
                                    <td class="user-firstname" data-user-id="{{ $audit->user_id }}">
                                        Cargando...
                                    </td>
                                    <td>{{ ucfirst($audit->event) }}</td>
                                    <td>{{ class_basename($audit->auditable_type) }} (ID: {{ $audit->auditable_id }})</td>
                                    <td>
                                        <ul>
                                            @foreach ($audit->old_values as $field => $value)
                                                <li><span class="field-name">{{ ucfirst($field) }}:</span> {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            @foreach ($audit->new_values as $field => $value)
                                                <li><span class="field-name">{{ ucfirst($field) }}:</span> {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $audit->created_at->format('d-m-Y H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No hay registros de auditoría disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="div_deg">
                    {{ $audits->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('admin.js')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.user-firstname').each(function() {
                var userId = $(this).data('user-id');
                var $this = $(this);

                $.ajax({
                    url: '/user/firstname/' + userId,
                    method: 'GET',
                    success: function(response) {
                        $this.text(response.firstname);
                    },
                    error: function() {
                        $this.text('Usuario Desconocido');
                    }
                });
            });
        });
    </script>
</body>
</html>
