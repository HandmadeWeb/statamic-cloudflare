@extends('statamic::layout')
@section('title', __('Cloudflare Manager'))

@section('content')

<header class="mb-3">
  @include('statamic::partials.breadcrumb', [
            'url' => cp_route('utilities.index'),
            'title' => __('Utilities')
        ])

  <div class="flex items-center justify-between">
    <h1>{{ __('Cloudflare') }}</h1>

    <form
      method="POST"
      action="{{ cp_route('utilities.cloudflare.purgeAll') }}"
    >
      @csrf
      <button class="btn-primary">{{ __('Purge All') }}</button>
    </form>
  </div>
</header>

@stop
