@extends ('layouts.app')

@section ('content')
    <section class="view is-active" data-view="patients" style="display: block; opacity: 1">
        @include ('satusehat.patient.partials.header')
        @include ('satusehat.patient.partials.table')
    </section>
@endsection
