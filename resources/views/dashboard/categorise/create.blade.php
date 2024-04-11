@extends('layouts.dashboard')

@section('title', 'categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">categories Page</li>

@endsection
@section('content')
    <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('dashboard.categorise._form')
    </form>
@endsection
