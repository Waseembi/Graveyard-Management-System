@extends('layouts.app')

@section('content')

<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Shamspura Graveyard Map</h3>
        <div>
            <span class="badge bg-success">Available</span>
            <span class="badge bg-danger">Booked</span>
        </div>
    </div>
    <div id="map"></div>
</div>

<style>
#map{width:100%;height:850px;border-radius:10px;border:2px solid #ddd;}
.leaflet-popup-content{text-align:center;}
.block-label{font-size:16px;font-weight:bold;}
</style>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
const graves = @json($graves);

const graveyardBoundary = [
    [24.937069180177446, 66.94162743458993],
    [24.936704357071687, 66.94090860264023],
    [24.93598930065126, 66.94138067138331],
    [24.936334668556064, 66.94210486775054]
];

const map = L.map('map').setView([24.9368, 66.9415], 19.45);
L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
    { attribution: 'Tiles © Esri', maxZoom: 19.45 }
).addTo(map);

L.polygon(graveyardBoundary, { color:'blue', weight:2, fillOpacity:0.05 }).addTo(map);
map.fitBounds(L.polygon(graveyardBoundary).getBounds());

function generateGridWithSpacing(boundary, rows, cols, rowGapCount, colGapCount) {
    const plots = [];
    const [FR, FL, BL, BR] = boundary;
    const totalRows = rows + rowGapCount; 
    const totalCols = cols + colGapCount; 

    for (let r = 0; r < totalRows; r++) {
        if (r === Math.floor(totalRows/3) || r === Math.floor(2*totalRows/3)) continue;
        for (let c = 0; c < totalCols; c++) {
            if (c === Math.floor(totalCols/2)) continue;

            const latTop = FL[0] + (FR[0] - FL[0]) * (c / totalCols);
            const lngTop = FL[1] + (FR[1] - FL[1]) * (c / totalCols);
            const latTopNext = FL[0] + (FR[0] - FL[0]) * ((c+1) / totalCols);
            const lngTopNext = FL[1] + (FR[1] - FL[1]) * ((c+1) / totalCols);

            const latBottom = BL[0] + (BR[0] - BL[0]) * (c / totalCols);
            const lngBottom = BL[1] + (BR[1] - BL[1]) * (c / totalCols);
            const latBottomNext = BL[0] + (BR[0] - BL[0]) * ((c+1) / totalCols);
            const lngBottomNext = BL[1] + (BR[1] - BL[1]) * ((c+1) / totalCols);

            const lat1 = latTop + (latBottom - latTop) * (r / totalRows);
            const lng1 = lngTop + (lngBottom - lngTop) * (r / totalRows);
            const lat2 = latTopNext + (latBottomNext - latTopNext) * (r / totalRows);
            const lng2 = lngTopNext + (lngBottomNext - lngTopNext) * (r / totalRows);
            const lat3 = latTopNext + (latBottomNext - latTopNext) * ((r+1) / totalRows);
            const lng3 = lngTopNext + (lngBottomNext - lngTopNext) * ((r+1) / totalRows);
            const lat4 = latTop + (latBottom - latTop) * ((r+1) / totalRows);
            const lng4 = lngTop + (lngBottom - lngTop) * ((r+1) / totalRows);

            plots.push([[lat1,lng1],[lat2,lng2],[lat3,lng3],[lat4,lng4]]);
        }
    }
    return plots;
}

const plots = generateGridWithSpacing(graveyardBoundary, 20, 60, 2, 1);

function getBlockName(row, col, rows, cols) {
    const halfCols = cols / 2;
    const thirdRows = rows / 3;
    if(col < halfCols) {
        if(row < thirdRows) return 'A';
        else if(row < 2*thirdRows) return 'B';
        else return 'C';
    } else {
        if(row < thirdRows) return 'D';
        else if(row < 2*thirdRows) return 'E';
        else return 'F';
    }
}

plots.forEach((coords, index) => {
    const grave = graves.find(g => g.id === (index+1));
    const status = grave ? grave.status.toLowerCase() : 'available';
    const fillColor = status === 'available' ? '#28a745' : '#dc3545';

    const row = Math.floor(index / 60);
    const col = index % 60;
    const blockName = getBlockName(row, col, 20, 60);

    const plot = L.polygon(coords, {
        color: '#000',
        weight: 1,
        fillColor: fillColor,
        fillOpacity: 0.7
    }).addTo(map);

    let popupHtml = `
        <div>
            <strong>Grave #${grave ? grave.id : index+1}</strong><br>
            Block: ${blockName}<br>
            Status: ${status}<br><br>
    `;
    if(status === 'available'){
        popupHtml += `<a href="/grave-book/${grave ? grave.id : index+1}" class="btn btn-success btn-sm">Book Grave</a>`;
    } else {
        popupHtml += `<button class="btn btn-danger btn-sm" disabled>Booked</button>`;
    }
    popupHtml += `</div>`;
    plot.bindPopup(popupHtml);
});


// Add block labels
['A','B','C','D','E','F'].forEach(name => {
    let index;
    switch(name){
        case 'A': index = 2*60 + 2; break;
        case 'B': index = 8*60 + 2; break;
        case 'C': index = 15*60 + 2; break;
        case 'D': index = 2*60 + 50; break;
        case 'E': index = 8*60 + 50; break;
        case 'F': index = 15*60 + 50; break;
    }
    const coords = plots[index];
    if(coords){
        const center = L.polygon(coords).getBounds().getCenter();
        L.marker(center, {
            icon: L.divIcon({
                className: 'block-label',
                html: `<b>${name}</b>`,
                iconSize: [30,30]
            })
        }).addTo(map);
    }
});
</script>

@endsection








{{-- @extends('layouts.app')

@section('content')

<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<div class="container-fluid py-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Shamspura Graveyard Map</h3>

        <div>
            <span class="badge bg-success">Available</span>
            <span class="badge bg-danger">Booked</span>
        </div>
    </div>

    <div id="map"></div>

</div>

<style>

#map{
    width:100%;
    height:850px;
    border-radius:10px;
    border:1px solid #ddd;
}

.leaflet-popup-content{
    text-align:center;
}

</style>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

const graves = @json($graves);


// CREATE MAP

const map = L.map('map', {
    zoomControl: true,
    minZoom: 16,
    maxZoom: 19.45
});


// SATELLITE LAYER

const satellite = L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
    {
        attribution: 'Tiles © Esri',
        maxZoom: 20
    }
);


// STREET LAYER

const street = L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 22
    }
);


// DEFAULT LAYER

satellite.addTo(map);


// SWITCHER

L.control.layers({
    "Street Map": street,
    "Satellite": satellite
}).addTo(map);


// SHAMSPURA CENTER

map.setView(
    [24.9367693, 66.9415111],
    19
);


// OPTIONAL CEMETERY BOUNDARY

const cemeteryBoundary = [
    [24.937150,66.940900],
    [24.937150,66.942100],
    [24.936250,66.942100],
    [24.936250,66.940900]
];

L.polygon(
    cemeteryBoundary,
    {
        color:'blue',
        weight:2,
        fillOpacity:0.03
    }
).addTo(map);


// STORE ALL GRAVE PLOTS

let allPlots = [];


// DRAW GRAVES

graves.forEach(function(grave){

    if(!grave.lat || !grave.lng){
        return;
    }

    const lat = parseFloat(grave.lat);
    const lng = parseFloat(grave.lng);

    const color =
        grave.status === 'available'
        ? '#28a745'
        : '#dc3545';

    const plot = L.rectangle(
        [
            [
                lat - 0.000004,
                lng - 0.000004
            ],
            [
                lat + 0.000004,
                lng + 0.000004
            ]
        ],
        {
            color: color,
            fillColor: color,
            fillOpacity: 0.75,
            weight: 1
        }
    ).addTo(map);

    allPlots.push(plot);

    let popupHtml = `
        <div>
            <strong>Grave #${grave.id}</strong>
            <br>
            Status:
            ${grave.status}
            <br><br>
    `;

    if(grave.status === 'available')
    {
        popupHtml += `
            <a href="/grave-book/${grave.id}"
               class="btn btn-success btn-sm">
               Book Grave
            </a>
        `;
    }
    else
    {
        popupHtml += `
            <button
                class="btn btn-danger btn-sm"
                disabled>
                Booked
            </button>
        `;
    }

    popupHtml += `</div>`;

    plot.bindPopup(popupHtml);

});


// AUTO FIT TO ALL GRAVES

if(allPlots.length > 0)
{
    const group = L.featureGroup(allPlots);

    map.fitBounds(
        group.getBounds().pad(0.2)
    );
}

</script>

@endsection



 --}}




 {{-- @extends('layouts.app')

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
 --}}


















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