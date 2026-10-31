@extends ('layouts.app')

@section ('content')
    <section class="view is-active" data-view="users" style="display: block; opacity: 1; padding: 24px 32px 64px">
        @include ('management.users.partials.content')
    </section>
@endsection
