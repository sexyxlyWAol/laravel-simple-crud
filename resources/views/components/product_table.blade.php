<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        @if(session('authenticated'))
            <th>Options</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse ($products as $product)
        <tr class="product-row">
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            @if(session('authenticated'))
                <td>
                    <button class="btn btn-primary edit-product" data-product-id="{{ $product->id }}">Edit</button>
                    <button class="btn btn-danger delete-product" data-product-id="{{ $product->id }}">Delete</button>
                </td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">No products found</td>
        </tr>
    @endforelse
    </tbody>
</table>
