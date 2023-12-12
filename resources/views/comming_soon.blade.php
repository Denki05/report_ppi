@extends('layouts.app')

@section('content')

    <div class="page page-center">
      <div class="container-tight py-4">
        <div class="empty">
          <div class="empty-img"><img src="{{ asset('public/image/comming_soon.svg') }}" height="128" alt="">
          </div>
          <p class="empty-title">Comming Soon Page!</p>
          <p class="empty-subtitle text-muted">
            Sorry for the inconvenience, but we are working on it at this time. We'll be back online soon!
          </p>
          <div class="empty-action">
            <a href="{{ route('home') }}" class="btn btn-primary">
              <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
              Take me home
            </a>
          </div>
        </div>
      </div>
    </div>

@endsection