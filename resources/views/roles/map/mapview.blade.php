@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4">Select a Grave from Map</h4>

    <div class="grave-map">
        @foreach($graves as $grave)
            <a href="{{ $grave->status === 'available' ? route('grave.book', $grave->id) : '#' }}"
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



















{{-- @extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

<h4 class="mb-3">Graveyard Map (Zoom + Pan)</h4>

<div class="map-container">

    <div class="controls mb-2">
        <button onclick="zoomIn()">➕ Zoom In</button>
        <button onclick="zoomOut()">➖ Zoom Out</button>
        <button onclick="resetView()">🔄 Reset</button>
    </div>

    <div class="map-wrapper">
        <svg id="graveSvg" viewBox="0 0 1400 800">

            <!-- Background -->
            <rect x="0" y="0" width="1400" height="800" fill="#e9f5e9"/>

            <!-- Roads -->
            <rect x="0" y="250" width="1400" height="40" fill="#ccc"/>
            <rect x="0" y="500" width="1400" height="40" fill="#ccc"/>

            @php $i = 0; @endphp

            @foreach($graves as $grave)

                @php
                    if($i < 100){
                        $baseY = 80;
                    } elseif($i < 200){
                        $baseY = 330;
                    } else {
                        $baseY = 580;
                    }

                    $col = $i % 20;
                    $row = floor(($i % 100) / 20);

                    $x = 100 + ($col * 50);
                    $y = $baseY + ($row * 40);

                    $color = $grave->status === 'available' ? '#28a745' : '#dc3545';
                @endphp

                <a xlink:href="{{ $grave->status === 'available' ? route('grave.book', $grave->id) : '#' }}">
    <rect 
        x="{{ $x }}" 
        y="{{ $y }}" 
        width="35" 
        height="25" 
        fill="{{ $color }}" 
        rx="3"
        class="grave"
    />
    <text 
        x="{{ $x + 17 }}" 
        y="{{ $y + 17 }}" 
        font-size="10" 
        text-anchor="middle" 
        fill="white">
        {{ $grave->id }}
    </text>
</a>


                @php $i++; @endphp

            @endforeach

        </svg>
    </div>

</div>
</div>


<script>
let svg = document.getElementById("graveSvg");

let scale = 1;
let panX = 0;
let panY = 0;
let isDragging = false;
let startX, startY;

// Apply transform
function updateTransform() {
    svg.style.transform = `translate(${panX}px, ${panY}px) scale(${scale})`;
    svg.style.transformOrigin = "0 0";
}

// Zoom In
function zoomIn() {
    scale += 0.1;
    updateTransform();
}

// Zoom Out
function zoomOut() {
    scale = Math.max(0.3, scale - 0.1);
    updateTransform();
}

// Reset View
function resetView() {
    scale = 1;
    panX = 0;
    panY = 0;
    updateTransform();
}

// Mouse drag (PAN)
svg.addEventListener("mousedown", (e) => {
    isDragging = true;
    startX = e.clientX - panX;
    startY = e.clientY - panY;
    svg.style.cursor = "grabbing";
});

window.addEventListener("mouseup", () => {
    isDragging = false;
    svg.style.cursor = "grab";
});

window.addEventListener("mousemove", (e) => {
    if (!isDragging) return;

    panX = e.clientX - startX;
    panY = e.clientY - startY;

    updateTransform();
});

// Mouse wheel zoom
svg.addEventListener("wheel", (e) => {
    e.preventDefault();

    if (e.deltaY < 0) {
        scale += 0.1;
    } else {
        scale -= 0.1;
    }

    scale = Math.min(Math.max(0.3, scale), 3);
    updateTransform();
});
</script>

<style>
.map-wrapper {
    width: 100%;
    height: 600px;
    overflow: hidden;
    border: 1px solid #ccc;
    background: #f8f9fa;
    cursor: grab;
}

.grave {
    transition: 0.2s;
}

.grave:hover {
    stroke: black;
    stroke-width: 1;
}

.controls button {
    margin-right: 5px;
    padding: 6px 10px;
    border: none;
    background: #007bff;
    color: white;
    border-radius: 4px;
}

.controls button:hover {
    background: #0056b3;
}
</style>

@endsection --}}