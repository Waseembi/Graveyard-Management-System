@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4">Select a Grave from Map</h4>

    <div class="grave-map">
        @foreach($graves as $grave)
        {{-- {{ $grave->status === 'available' ? route('grave.book', $grave->id) : '#' }} --}}
            <a href=""
               class="grave-box {{ $grave->status === 'available' ? 'available' : 'booked' }}">
                {{ $grave->id }}
            </a>
        @endforeach
    </div>
</div>

<style>
    .grave-map {
        display: grid;
        grid-template-columns: repeat(40, 1fr); /* 40 columns */
        gap: 5px;
    }
    .grave-box {
        min-height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        border-radius: 4px;
        text-decoration: none;
        transition: 0.2s;
    }
    .grave-box.available {
        background-color: #28a745; /* green */
        color: white;
        cursor: pointer;
    }
    .grave-box.booked {
        background-color: #dc3545; /* red */
        color: white;
        cursor: not-allowed;
    }
    .grave-box:hover.available {
        transform: scale(1.05);
    }
</style>
@endsection
