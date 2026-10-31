@extends('layouts.app')

@section('content')
<section class="view is-active" data-view="patients" style="display: block; opacity: 1;">
    @include('patients.partials.header')
    @include('patients.partials.table')
</section>
@endsection
