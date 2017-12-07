@extends('layouts.main')

@section('content')
    <transition>
        <router-view name="home"></router-view>
        <router-view></router-view>
    </transition>
@endsection
