@extends ('layouts.app')

@section ('content')
    <section class="view is-active" data-view="reports" style="display: block; opacity: 1">
        @include ('reports.partials.header')
        <div class="r-grid">
            @include ('reports.partials.no-show-analysis')
            @include ('reports.partials.whatsapp-funnel')
            @include ('reports.partials.patient-mix')
            @include ('reports.partials.clinician-utilization')
        </div>
    </section>
@endsection
