@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Product Details</h2>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $product->id }}</p>
            <p><strong>Name:</strong> {{ $product->name }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Price:</strong> Rp {{ number_format($product->price, 2) }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>
            <p><strong>Created:</strong> {{ $product->created_at->format('d M Y H:i') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
