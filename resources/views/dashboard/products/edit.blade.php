@extends('layouts.dashboard')

@section('title', ' Edit product')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">products </li>
    <li class="breadcrumb-item active">Edit product</li>

@endsection
@section('content')
    <form action="{{ route('dashboard.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.products._form', ['tags' => $tags])
    </form>
@endsection
