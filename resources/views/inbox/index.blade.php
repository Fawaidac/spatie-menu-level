@extends ('layouts.app')

@section ('content')
    <section class="view is-active" data-view="inbox" style="display: block; opacity: 1">
        @include ('inbox.partials.header')
        <div class="ib">
            @include ('inbox.partials.chat-list')
            @include ('inbox.partials.chat-thread')
            @include ('inbox.partials.patient-panel')
        </div>
    </section>
@endsection
