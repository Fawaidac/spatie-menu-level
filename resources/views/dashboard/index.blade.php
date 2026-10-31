@extends ('layouts.app')

@section ('content')
    <header class="head">
        <div class="head__lead">
            <div>
                <p class="head__eyebrow">Dashboard</p>
                <h1 class="head__title">Pengiriman <em>Data Satu Sehat</em></h1>
            </div>
        </div>
    </header>
    <section class="view is-active" data-view="today" style="display: block; opacity: 1">
        @include ('dashboard.partials.satusehat-table')
    </section>
@endsection
