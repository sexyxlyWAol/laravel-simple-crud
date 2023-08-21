<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Table and Form Layout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .logout-link {
            position: fixed;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md">
            <h2>Products</h2>
            <div id="product-table">
                @component('components.product_table', ['products' => $products])
                @endcomponent
            </div>
        </div>
        @if(session('authenticated'))
            <div class="col-md">
                <h2>Editor</h2>
                <form id="editor" action="{{ url('/api/product') }}">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01">
                    </div>
                    <button type="submit" id="submit-edit" class="btn btn-success">Create</button>
                    <button type="button" id="cancel-edit" class="btn btn-secondary" style="display: none">Cancel</button>
                </form>
            </div>
        @endif
    </div>
    <div class="logout-link">
        @if(session('authenticated'))
            <a href="/logout">Logout</a>
        @else
            Please login to edit the data
        @endif

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    let editorMode = "create";
    $(document).ready(function() {
        // create / edit
        $('form').submit(function(event) {
            event.preventDefault();

            const formData = new FormData($(this)[0]);
            formData.append('_method', editorMode === 'create' ? 'POST' : 'PATCH');
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function() {
                    $.get('/products/table', function(html) {
                        $('#product-table').html(html);
                    });
                    resetForm();
                },
                error: function() {
                    alert("Failed to apply changes");
                }
            });
        });

        // delete
        $(document).on('click', '.delete-product', function() {
            const productId = $(this).data('product-id');

            $.ajax({
                url: '/api/product/' + productId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function() {
                    $.get('/products/table', function(html) {
                        $('#product-table').html(html);
                    });
                },
                error: function() {
                    alert("Failed to delete data");
                }
            });
        });

        // update
        $(document).on('click', '.edit-product', function() {
            editorMode = "edit";
            const row = $(this).closest('.product-row');
            const productId = $(this).data('product-id');
            const productName = row.find('td:eq(1)').text();
            const productPrice = row.find('td:eq(2)').text();

            const form = $('#editor');
            form.find('input[name="id"]').val(productId);
            form.find('input[name="name"]').val(productName);
            form.find('input[name="price"]').val(productPrice);
            $('#cancel-edit').show();
            $('#submit-edit').text("Submit");
        });

        $('#cancel-edit').click(() => {
            resetForm();
        })
    });

    function resetForm(){
        editorMode = "create";
        $('#cancel-edit').hide();
        $('#submit-edit').text("Create");

        const form = $('#editor');
        form.find('input[name="id"]').val("");
        form.find('input[name="name"]').val("");
        form.find('input[name="price"]').val("");
    }
</script>
</body>
</html>
