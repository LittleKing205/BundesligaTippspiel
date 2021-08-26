@extends('layouts.app')

@section('title', $leagueName)

@section('breadcump')
    <li class="breadcrumb-item active">{{ $leagueName }}</li>
    <li class="breadcrumb-item active">{{ $day }}. Spieltag</li>
@endsection

@push('meta')
    <meta name="tipp-url" content="{{ route('tippStore') }}">
@endpush

@section('content')
    <x-tipp-day-paginate currentPage="3" />
    @foreach($matches as $matchPerDay)
        <x-day-separator>{{ $matchPerDay[0]->match_start->dayName }}, den {{ $matchPerDay[0]->match_start->format('d.m.Y') }}</x-day-separator>
        <div class="row">
            @foreach($matchPerDay as $match)
                <x-tipp-box :match="$match->id" />
            @endforeach
        </div>
    @endforeach
    <x-tipp-day-paginate currentPage="3" />
@endsection
