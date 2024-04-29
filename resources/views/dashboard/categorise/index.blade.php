@extends('layouts.dashboard')

@section('title', 'categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">
        categories Page</li>

@endsection
@section('content')
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
        <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-sm btn-outline-dark">tarsh</a>
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
            <th>PARENT</th>
            <th>Products</th>
            <th>Status</th>
            <th>Created_at</th>
            <th>actions</th>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" height="60" alt="">
                        @else
                            <img src="{{ asset('dist/img/heba.png') }}" height="60">
                        @endif
                    </td>
                    <td>{{ $category->id }}</td>
                    <td>
                        <a href="{{ route('dashboard.categories.show', $category->id) }}">{{ $category->name }}</a>
                    </td>
                    <td>{{ $category->parent->name }}</td>
                    <td>{{ $category->products_number }}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td class="d-flex">

                        <a class="btn btn-sm btn-outline-success mr-2"
                            href="{{ route('dashboard.categories.edit', $category->id) }}" role="button">Edit</a>

                        <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
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
    {{ $categories->withQueryString()->links() }}
@endsection
