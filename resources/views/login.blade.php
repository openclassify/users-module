{{--{% extends layout('users') %}--}}
@extends('theme::layouts.default')

@section('content')
    <div>

        {{ form('login')->redirect(request('redirect', '/'))->make() }}

        <br>

        <a href="{{ route('anomaly.module.users::password.forgot', ['redirect' => request('redirect', '/')]) }}">
            {{ trans('anomaly.module.users::message.forgot_password') }}
        </a>

    </div>
@endsection
