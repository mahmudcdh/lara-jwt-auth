@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto">
        @include('components.dashboard.summary')
    </div>
@endSection
