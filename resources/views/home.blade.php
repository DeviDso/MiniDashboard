@extends('layouts.main')

@section('content')
    <transition name="fade">
        <router-view name="home"></router-view>
        <router-view></router-view>
    </transition>
@endsection
