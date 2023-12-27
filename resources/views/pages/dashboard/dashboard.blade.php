@extends('layout.app')
@section('content')
    @include('components.dashboard.customer-list')
    @include('components.dashboard.customer-create')
    @include('components.dashboard.customer-update')
@endsection