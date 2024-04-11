@extends('layouts.dashboard')

@section('title', $category->name)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">categories </li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>

@endsection
@section('content')
    <a class="btn btn-sm btn-success mb-2" href="{{ route('dashboard.categories.index') }}">goToCategories</a>
    <table class="table">
        <thead>
            <th></th>
            <th>NAME</th>
            <th>store</th>
            <th>Status</th>
            <th>Created_at</th>

        </thead>
        <tbody>
            @php
                $products = $category->products()->with('store')->latest()->paginate(5);
            @endphp
            @forelse ($products as $product)
                <tr>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" height="60" alt="">
                        @else
                            <img src="{{ asset('dist/img/heba.png') }}" height="60">
                        @endif
                    </td>

                    <td>{{ $product->name }}</td>
                    <td>{{ $product->store->name }}</td>
                    <td>{{ $product->stutas }}</td>
                    <td>{{ $product->created_at }}</td>

                </tr>
            @empty
                <td colspan="5">
                    <h3>sorry no date now</h3>
                </td>
            @endforelse

        </tbody>
    </table>
    {{ $products->links() }}
@endsection
