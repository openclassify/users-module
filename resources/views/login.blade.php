@extends('theme::layouts/blank')

@section('content')
    <div class="container">
        <div class="col-lg-6 col-lg-offset-3">

            {{ form('login').redirect(request('redirect', '/')) }}

            <br>

            <a href="{{ route('anomaly.module.users::password.forgot', [
                'redirect' => request('redirect', '/')
            ]) }}">
                {{ trans('anomaly.module.users::message.forgot_password') }}
            </a>

        </div>
    </div>
@endsection
