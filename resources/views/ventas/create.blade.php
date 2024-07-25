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
                    <form action="{{ route('ventas.store') }}" method="post" class="form_deg">
                        @csrf

                        <!-- Cliente -->
                        <div class="form-group">
                            <label for="user_id">Cliente:</label>
                            <select name="user_id" id="user_id" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->firstname }}
                                        {{ $user->firstlastname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fecha de Venta -->
                        <div class="form-group">
                            <label for="fecha_venta">Fecha de Venta:</label>
                            <input type="date" name="fecha_venta" id="fecha_venta" required>
                        </div>

                        <!-- Método de Pago -->
                        <div class="form-group">
                            <label for="metodo_pago">Método de Pago:</label>
                            <select name="metodo_pago" id="metodo_pago" required>
                                <option value="Pago Físico">Pago Físico</option>
                            </select>
                        </div>


                        <!-- Productos -->
                        <div class="form-group">
                            <label>Productos:</label>
                            <table class="table_deg" id="products_table">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th>Acciones</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="productos[0][product_id]" class="product-select"
                                            onchange="updatePrice(this)" required>
                                            <option value="">Seleccione un producto</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    data-price="{{ $product->pro_price }}">{{ $product->pro_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="productos[0][cantidad]" min="1"
                                            value="1" onchange="updateSubtotal(this)" required></td>
                                    <td class="product-price">0</td>
                                    <td class="product-subtotal">0</td>
                                    <td>
                                        <button type="button" class="btn btn-danger"
                                            onclick="removeProduct(this)">Eliminar</button>
                                    </td>
                                </tr>
                            </table>
                            <div class="add-product-button">
                                <button type="button" class="btn btn-primary" onclick="addProduct()">Agregar
                                    Producto</button>
                            </div>
                        </div>

                        <!-- IVA -->
                        <div class="form-group">
                            <label for="iva">IVA (%):</label>
                            <input type="number" name="iva" id="iva" value="0"
                                onchange="calculateTotal()" required>
                        </div>

                        <!-- Total -->
                        <div class="total-display">
                            Total: $<span id="total_venta">0.00</span>
                        </div>

                        <!-- Submit -->
                        <div class="submit-button">
                            <input type="submit" class="btn btn-success" value="Crear Venta">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript files -->
    @include('admin.js')

    <script type="text/javascript">
        function addProduct() {
            var rowCount = document.getElementById('products_table').rows.length;
            var table = document.getElementById('products_table');
            var newRow = table.insertRow(rowCount);

            var productCell = newRow.insertCell(0);
            var quantityCell = newRow.insertCell(1);
            var priceCell = newRow.insertCell(2);
            var subtotalCell = newRow.insertCell(3);
            var actionCell = newRow.insertCell(4);

            var productSelect = `<select name="productos[${rowCount - 1}][product_id]" class="product-select" onchange="updatePrice(this)" required>
                                    <option value="">Seleccione un producto</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->pro_price }}">{{ $product->pro_name }}</option>
                                    @endforeach
                                </select>`;

            productCell.innerHTML = productSelect;
            quantityCell.innerHTML =
                `<input type="number" name="productos[${rowCount - 1}][cantidad]" min="1" value="1" onchange="updateSubtotal(this)" required>`;
            priceCell.className = "product-price";
            priceCell.innerHTML = "0";
            subtotalCell.className = "product-subtotal";
            subtotalCell.innerHTML = "0";
            actionCell.innerHTML =
                `<button type="button" class="btn btn-danger" onclick="removeProduct(this)">Eliminar</button>`;
        }

        function updatePrice(select) {
            var price = select.options[select.selectedIndex].getAttribute('data-price');
            var row = select.parentNode.parentNode;
            row.querySelector('.product-price').innerHTML = parseFloat(price).toFixed(2);
            updateSubtotal(row.querySelector('input[type="number"]'));
        }

        function updateSubtotal(input) {
            var quantity = input.value;
            var row = input.parentNode.parentNode;
            var price = parseFloat(row.querySelector('.product-price').innerHTML);
            var subtotal = quantity * price;
            row.querySelector('.product-subtotal').innerHTML = subtotal.toFixed(2);
            calculateTotal();
        }

        function calculateTotal() {
            var table = document.getElementById('products_table');
            var total = 0;
            for (var i = 1, row; row = table.rows[i]; i++) {
                total += parseFloat(row.querySelector('.product-subtotal').innerHTML);
            }
            var iva = parseFloat(document.getElementById('iva').value);
            total = total + (total * iva / 100);
            document.getElementById('total_venta').innerHTML = total.toFixed(2);
        }

        function removeProduct(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
            calculateTotal();
        }
    </script>
</body>

</html>
