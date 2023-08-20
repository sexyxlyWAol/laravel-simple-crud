<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Options</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>
                <button class="btn btn-primary">Edit</button>
                <button class="btn btn-danger">Delete</button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">No products found</td>
        </tr>
    @endforelse
    </tbody>
</table>
