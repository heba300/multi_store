@extends('layouts.dashboard')

@section('title', 'products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">
        products Page</li>

@endsection
@section('content')
    <div class="mb-5">
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
        {{-- <a href="{{ route('dashboard.products.trash') }}" class="btn btn-sm btn-outline-dark">tarsh</a> --}}
    </div>

    <x-alert type='success' />
    <x-alert type='info' />

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name='name' placeholder='name' class="mx-2" :value="request('name')" />
        <select name="status" class="form control" class="mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="archived" @selected(request('status') == 'archived')>Archived</option>
        </select>
        <button class="btn btn-dark mx-2">Filter</button>
    </form>

    <table class="table">
        <thead>
            <th>Image</th>
            <th>ID</th>
            <th>NAME</th>
            <th>Category</th>
            <th>store</th>
            <th>Status</th>
            <th>Created_at</th>
            <th colspan="2"></th>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" height="60" alt="">
                        @else
                            <img src="{{ asset('dist/img/heba.png') }}" height="60">
                        @endif
                    </td>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->store->name }}</td>
                    <td>{{ $product->stutas }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>

                        <a class="btn btn-sm btn-outline-success"
                            href="{{ route('dashboard.products.edit', $product->id) }}" role="button">Edit</a>

                    </td>
                    <td>
                        <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <td colspan="9">
                    <h3>sorry no date now</h3>
                </td>
            @endforelse

        </tbody>
    </table>
    {{ $products->withQueryString()->links() }}
@endsection
