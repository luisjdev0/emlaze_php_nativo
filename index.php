<?php
require_once 'ajax/products.php';
$title = "Listado de productos";
require_once 'templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Tabla con DataTables y Bootstrap</title>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h2 class="mb-4">Listado de productos</h2>
            <a href="login.php">Cerrar sesión</a>
        </div>
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-primary" id="addProduct" data-bs-toggle="modal" data-bs-target="#creationFormModal">Agregar producto</button>
        </div>
        <table id="miTabla" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sku</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th width="50">Editar</th>
                    <th width="50">Eliminar</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="creationFormModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="creationFormModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="creationFormModalLabel">Agregar producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="product-form" method="post">
                    <input type="hidden" name="form-id" id="form-id" />
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text">SKU</span>
                            <input type="text" class="form-control" placeholder="Ej. 1001" id="form-sku" required />
                            <div class="invalid-feedback" id="invalidSKU">
                                El SKU ya está en uso, por favor ingrese uno diferente.
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Nombre</span>
                            <input type="text" class="form-control" placeholder="Ej. Producto 1" id="form-name" required />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Descripción</span>
                            <textarea class="form-control" placeholder="Descripción del producto" id="form-desc" required></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Cantidad</span>
                            <input type="number" class="form-control" placeholder="Ej. 10" id="form-count" min="1" required />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Precio</span>
                            <input type="number" class="form-control" placeholder="Ej. 100.00" id="form-price" min="1" required />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Total</span>
                            <input type="number" class="form-control" readonly id="form-total" disabled />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" id="crear-item" class="btn btn-primary">Guardar</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        const calcularTotal = () => {
            const count = parseFloat($('#form-count').val()) || 0
            const price = parseFloat($('#form-price').val()) || 0
            $('#form-total').val((count * price).toFixed(2))
        }

        const getProductBySku = async (sku) => {
            const response = await fetch(`index.php?request=by_sku&sku=${sku}`)
            if (!response.ok) throw new Error('Error al validar SKU')
            const data = await response.json()
            return data
        }

        $(document).ready(() => {
            //Definición de la tabla
            const table = $('#miTabla').DataTable({
                ajax: {
                    url: "index.php?request=get_products",
                    dataSrc: ''
                },
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                columns: [
                    { data: 'id' },
                    { data: 'sku' },
                    { data: 'nombre' },
                    { data: 'cantidad' },
                    { data: 'precio' },
                    { data: 'total' },
                    // Botones de acción
                    {
                        data: null,
                        render: (data, _, __) => `<button class="btn btn-warning btn-sm edit-button" data-bs-toggle="modal" data-bs-target="#creationFormModal" target='${data.sku}'><i class="bi bi-pencil"></i></button>`,
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: null,
                        render: (data, _, __) => `<button class="btn btn-danger btn-sm delete-button" target='${data.sku}'><i class="bi bi-trash"></i></button>`,
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                columnDefs: [{
                    targets: [-1, -2], // Últimas dos columnas
                    orderable: false, // Desactiva orden
                    searchable: false // Desactiva búsqueda
                }]
            })

            //Calcular total al cambiar cantidad o precio
            $('#form-count, #form-price').on('input', calcularTotal)

            //Validar SKU al digitar un código
            const formSku = $('#form-sku')
            formSku.blur(async () => {
                const sku = $(formSku).val()
                if (sku) {
                    const exists = await getProductBySku(sku)
                    if (exists) {
                        formSku.removeClass('is-valid')
                        formSku.addClass('is-invalid')
                        formSku.val('')
                    } else {
                        formSku.removeClass('is-invalid')
                        formSku.addClass('is-valid')
                    }
                }
            })

            //Abrir modal para agregar producto
            $('#addProduct').click(() => {
                $('#product-form')[0].reset()
                $('#creationFormModalLabel').html('Agregar producto')
                $('#form-id').val(null)
                $('#crear-item').html('Guardar')
                $('#form-sku').prop('disabled', false)
            })

            //Abrir modal para editar producto
            $(document).on('click', '.edit-button', async (btn) => {
                $('#creationFormModalLabel').html('Editar producto')
                const productSku = $(btn.currentTarget).attr('target')
                const product = await getProductBySku(productSku)

                $('#form-id').val(product.id)
                $('#form-sku').val(product.sku)
                $('#form-name').val(product.nombre)
                $('#form-desc').val(product.descripcion)
                $('#form-count').val(product.cantidad)
                $('#form-price').val(product.precio)
                $('#form-total').val(product.total)
                $('#crear-item').html('Editar')

                $('#form-sku').prop('disabled', true)
            })

            //Abrir modal para eliminar producto
            $(document).on('click', '.delete-button', async (btn) => {
                const productSku = $(btn.currentTarget).attr('target')
                console.log(productSku)
                if (confirm(`¿Está seguro de eliminar el producto con SKU: ${productSku}?`)) {
                    try {
                        const request = await $.post('', {
                            delete_sku: productSku
                        })
                        table.ajax.reload(null, false)
                        alert('Producto eliminado exitosamente.')
                    } catch (error) {
                        console.error('Error al eliminar el producto:', error)
                        alert('Error al eliminar el producto. Por favor, inténtelo de nuevo.')
                    }
                }
            })

            //Validación y petición para guardar producto
            $('#product-form').submit(async () => {
                event.preventDefault()
                const data = {
                    sku: $('#form-sku').val().trim(),
                    nombre: $('#form-name').val().trim(),
                    descripcion: $('#form-desc').val().trim(),
                    cantidad: parseInt($('#form-count').val()),
                    precio: parseFloat($('#form-price').val()),
                    total: parseFloat($('#form-total').val())
                }

                if ($('#form-id').val()) {
                    data['id'] = parseInt($('#form-id').val())
                }

                if (!data.sku || !data.nombre || !data.descripcion || isNaN(data.cantidad) || isNaN(data.precio) || isNaN(data.total)) {
                    alert('Por favor, complete todos los campos correctamente.')
                    return
                }

                try {
                    const request = await $.post('', data)
                    const modal = bootstrap.Modal.getInstance('#creationFormModal')
                    modal.hide()

                    if (data['id']) {
                        alert('Producto actualizado exitosamente.')
                    } else {
                        alert('Producto creado exitosamente.')
                    }

                    table.ajax.reload(null, false)
                } catch (error) {
                    console.error('Error al crear el producto:', error)
                    alert('Error al crear el producto. Por favor, inténtelo de nuevo.')
                }
            })
        })
    </script>
</body>

</html>