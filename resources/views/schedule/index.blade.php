@extends('layouts.app')

@section('content')
<section class="view sc is-active" data-view="schedule" style="display: block; opacity: 1;">
    @include('schedule.partials.filter-bar')
    @include('schedule.partials.calendar-board')
</section>
@endsection
