@extends('layouts.dashboard')

@section('title', ' Edit category')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">categories </li>
    <li class="breadcrumb-item active">Edit categories</li>

@endsection
@section('content')
    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.categorise._form', [
            'button_label' => 'Update',
        ])
    </form>
@endsection
