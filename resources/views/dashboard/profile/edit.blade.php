@extends('layouts.dashboard')

@section('title', ' Edit profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Profile </li>


@endsection
@section('content')

    <x-alert type="success" />
    <form action="{{ route('dashboard.profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="frist_name" label="Frist Name" :value="$user->profile->frist_name" />
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="last_name" label="Last Name" :value="$user->profile->last_name" />
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="birthday" type="date" label="BirthDay" :value="$user->profile->birthday" />
            </div>
        </div>

        <div class="col-md-6">
            <label for="">Gender</label>
            <x-form.radio name="gender" :option="['male' => 'Male', 'female' => 'Female']" :checked="$user->profile->gender" />
        </div>


        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="street_adress" label="Street Address" :value="$user->profile->street_adress" />
            </div>
        </div>


        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="city" label="City" :value="$user->profile->city" />
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="state" label="State" :value="$user->profile->state" />
            </div>
        </div>


        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="postal_code" label="Postal Code" :value="$user->profile->postal_code" />
            </div>
        </div>


        <div class="form-row">
            <div class="col-md-6">
                <x-form.select name="country" :options="$countries" label="Country" :selected="$user->profile->country" />
                <x-form.select name="locale" :options="$locales" label="Locale" :selected="$user->profile->locale" />

            </div>
        </div>



        <button type="submit" class="btn btn-primary">save</button>
    </form>
@endsection
