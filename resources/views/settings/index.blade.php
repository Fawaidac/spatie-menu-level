@extends ('layouts.app')

@section ('content')
    <section class="view is-active" data-view="settings" style="display: block; opacity: 1">
        @include ('settings.partials.header')
        <div class="s-grid">
            @include ('settings.partials.nav')
            <div class="s-stage">
                @include ('settings.partials.tab-clinic')
                @include ('settings.partials.tab-whatsapp')
                @include ('settings.partials.tab-hours')
                @include ('settings.partials.tab-team')
            </div>
        </div>
    </section>
@endsection
