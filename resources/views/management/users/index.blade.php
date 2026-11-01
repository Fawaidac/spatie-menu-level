@extends ('layouts.app')

@section ('content')
    <section class="view is-active" data-view="users" style="display: block; opacity: 1">
        @include ('management.users.partials.content')
    </section>
@endsection
