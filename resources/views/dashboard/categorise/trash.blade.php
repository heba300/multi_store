@extends('layouts.dashboard')

@section('title', 'trashed categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item ">categories Page</li>
    <li class="breadcrumb-item active">trash</li>

@endsection
@section('content')
    <div class="mb-5">
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-primary">Back</a>
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

            <th>Status</th>
            <th>Deleted_at</th>
            <th colspan="2"></th>
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
                    <td>{{ $category->name }}</td>

                    <td>{{ $category->status }}</td>
                    <td>{{ $category->deleted_at }}</td>
                    <td>
                        <form action="{{ route('dashboard.categories.restore', $category->id) }}" method="post">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-sm btn-outline-info">restore</button>
                        </form>

                    </td>
                    <td>
                        <form action="{{ route('dashboard.categories.force-delete', $category->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <td colspan="7">
                    <h3>sorry no date now</h3>
                </td>
            @endforelse

        </tbody>
    </table>
    {{ $categories->withQueryString()->links() }}
@endsection
