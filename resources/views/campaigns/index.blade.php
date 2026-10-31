@extends('layouts.app')

@section('content')
<section class="view is-active" data-view="campaigns" style="display: block; opacity: 1;">
    <div class="cp-list">
        @include('campaigns.partials.tabs')
        <div class="cp-body">
            @include('campaigns.partials.broadcast-list')
            @include('campaigns.partials.templates-list')
        </div>
    </div>
</section>
@endsection
