@extends('layouts.base')

@section('head')
    @yield('head_includes')
@endsection
@section('body')
    <div id="app">  
    @include('layouts.main_nav_read_only')
    @include('layouts.session_messages')
    @yield('content')
    </div>
    @yield('content-no-app')
    @include('layouts.bottom_scripts')
    @stack('bottom-scripts')
@endsection

