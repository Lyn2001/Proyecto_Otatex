<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style type="text/css">
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 50px;
        }

        .form_deg {
            width: 80%;
            border: 3px solid greenyellow;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .table_deg {
            border: 2px solid #ccc;
            width: 100%;
            margin-top: 20px;
        }

        th {
            background-color: skyblue;
            color: black;
            font-size: 19px;
            font-weight: bold;
            padding: 10px;
        }

        td,
        tr {
            border: 1px solid #ccc;
            text-align: center;
            padding: 10px;
        }

        .add-product-button {
            margin-top: 20px;
            align-self: flex-end;
        }

        .total-display {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }

        .submit-button {
            margin-top: 30px;
            align-self: flex-end;
        }
    </style>
</head>

<body>

    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="div_deg">
                    <form action="{{ route('ventas.update', $venta->id) }}" method="post" class="form_deg">
                        @csrf
                        @method('PUT')

                        <!-- Cliente -->
                        <div class="form-group">
                            <label for="user_id">Cliente:</label>
                            <select name="user_id" id="user_id" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $venta->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->firstname }} {{ $user->firstlastname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fecha de Venta -->
                        <div class="form-group">
                            <label for="fecha_venta">Fecha de Venta:</label>
                            <input type="date" name="fecha_venta" id="fecha_venta" value="{{ $venta->fecha_venta }}"
                                required>
                        </div>

                        <!-- Método de Pago -->
                        <div class="form-group">
                            <label for="metodo_pago">Método de Pago:</label>
                            <select name="metodo_pago" id="metodo_pago" required>
                                <option value="Pago Físico"
                                    {{ $venta->metodo_pago == 'pago_fisico' ? 'selected' : '' }}>Pago Físico</option>
                            </select>
                        </div>


                        <!-- Productos -->
                        <div class="form-group">
                            <label>Productos:</label>
                            <table class="table_deg" id="products_table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($venta->products as $index => $product)
                                        <tr>
                                            <td>
                                                <select name="productos[{{ $index }}][product_id]"
                                                    class="product-select" onchange="updatePrice(this)" required>
                                                    <option value="">Seleccione un producto</option>
                                                    @foreach ($allProducts as $p)
                                                        <option value="{{ $p->id }}"
                                                            data-price="{{ $p->pro_price }}"
                                                            {{ $product->id == $p->id ? 'selected' : '' }}>
                                                            {{ $p->pro_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="productos[{{ $index }}][cantidad]"
                                                    min="1" value="{{ $product->pivot->cantidad }}"
                                                    onchange="updateSubtotal(this)" required>
                                            </td>
                                            <td class="product-price">{{ $product->pro_price }}</td>
                                            <td class="product-subtotal">{{ $product->pivot->subtotal }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="removeProduct(this)">Eliminar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="add-product-button">
                                <button type="button" class="btn btn-primary" onclick="addProduct()">Agregar
                                    Producto</button>
                            </div>
                        </div>

                        <!-- IVA -->
                        <div class="form-group">
                            <label for="iva">IVA (%):</label>
                            <input type="number" name="iva" id="iva" value="{{ $venta->iva }}"
                                onchange="calculateTotal()" required>
                        </div>

                        <!-- Total -->
                        <div class="total-display">
                            Total: $<span id="total_venta">{{ $venta->total_venta }}</span>
                        </div>

                        <!-- Submit -->
                        <div class="submit-button">
                            <input type="submit" class="btn btn-success" value="Actualizar Venta">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript files -->
    @include('admin.js')

    <script type="text/javascript">
        // Función para actualizar el precio unitario
        function updatePrice(selectElement) {
            var price = selectElement.options[selectElement.selectedIndex].getAttribute('data-price');
            var row = selectElement.closest('tr');
            row.querySelector('.product-price').textContent = price;
            updateSubtotal(row.querySelector('input[type="number"]'));
        }

        // Función para actualizar el subtotal de un producto
        function updateSubtotal(quantityInput) {
            var row = quantityInput.closest('tr');
            var price = parseFloat(row.querySelector('.product-price').textContent);
            var quantity = parseInt(quantityInput.value);
            var subtotal = price * quantity;
            row.querySelector('.product-subtotal').textContent = subtotal.toFixed(2);
            calculateTotal();
        }

        // Función para calcular el total de la venta
        function calculateTotal() {
            var total = 0;
            var rows = document.querySelectorAll('#products_table tbody tr');
            rows.forEach(function(row) {
                var subtotal = parseFloat(row.querySelector('.product-subtotal').textContent);
                total += subtotal;
            });

            var iva = parseFloat(document.getElementById('iva').value);
            total += total * (iva / 100);

            document.getElementById('total_venta').textContent = total.toFixed(2);
        }

        // Función para agregar un nuevo producto
        function addProduct() {
            var rowCount = document.getElementById('products_table').rows.length;
            var newRow = `
                <tr>
                    <td>
                        <select name="productos[${rowCount - 1}][product_id]" class="product-select" onchange="updatePrice(this)" required>
                            <option value="">Seleccione un producto</option>
                            @foreach ($allProducts as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->pro_price }}">{{ $product->pro_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="productos[${rowCount - 1}][cantidad]" min="1" value="1" onchange="updateSubtotal(this)" required>
                    </td>
                    <td class="product-price">0.00</td>
                    <td class="product-subtotal">0.00</td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="removeProduct(this)">Eliminar</button>
                    </td>
                </tr>
            `;
            document.querySelector('#products_table tbody').insertAdjacentHTML('beforeend', newRow);
        }

        // Función para eliminar un producto de la lista
        function removeProduct(button) {
            var row = button.closest('tr');
            row.remove();
            calculateTotal();
        }

        // Inicializar el cálculo del total al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotal();
        });
    </script>

</body>

</html>
