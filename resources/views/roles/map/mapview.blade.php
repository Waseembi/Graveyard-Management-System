@extends('layouts.app')

@section('content')
 {{-- success message --}}
        @if(session('success'))
            <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
                position: absolute;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                max-width: 400px;
                z-index: 1050;
                box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
                border-radius: 6px;
                font-weight: 500;
                font-size: 0.95rem;
                padding: 0.5rem 1rem;
                line-height: 1.3;
            ">      
                 {{ session('success') }}
        </div>
        @endif
        {{-- Validation Errors --}}
        @if ($errors->any())
        <div class="alert alert-danger text-center mx-auto mt-5" style="
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            max-width: 400px;
            z-index: 1050;
            box-shadow: 0 0.5rem 1rem rgba(128, 0, 0, 0.2);
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            line-height: 1.3;
        ">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li style="list-style-type: none">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
            {{-- Error message --}}
        @if(session('error'))
            <div id="success-alert" class="alert alert-danger text-center mx-auto mt-5" style="
                position: absolute;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                max-width: 400px;
                z-index: 1050;
                box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
                border-radius: 6px;
                font-weight: 500;
                font-size: 0.95rem;
                padding: 0.5rem 1rem;
                line-height: 1.3;
            ">      
                 {{ session('error') }}
        </div>
        @endif

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

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
.block-label{font-size:16px;font-weight:bold;color:#fff;text-shadow:1px 1px 2px #000;}
</style>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
const graves = @json($graves);

// Master layout boundary
const graveyardBoundary = [
    [24.937069180177446, 66.94162743458993],
    [24.936704357071687, 66.94090860264023],
    [24.93598930065126, 66.94138067138331],
    [24.936334668556064, 66.94210486775054]
];

// Specific boundaries arranged as [TopLeft, TopRight, BottomLeft, BottomRight]
const blockBoundaries = {
    'A': [[24.93667776199227, 66.94093807320208], [24.936846796868508, 66.94132833460642], [24.936520887690858, 66.94103999714241], [24.9366716815965, 66.94141282418855]],
    'B': [[24.936506294721397, 66.94105609039644], [24.936651008248518, 66.94144769290406], [24.9362861839029, 66.94119288305399], [24.936429681607247, 66.9415469346362]],
    'C': [[24.936264294405436, 66.94121434072669], [24.936394415235096, 66.94156839230892], [24.93600770059107, 66.94137661436855], [24.93615849512491, 66.94167970398061]],
    'D': [[24.93686412582197, 66.94137393307061], [24.936989380905622, 66.94165958648023], [24.936685362490714, 66.94147317389287], [24.93681183464252, 66.94178565123627]],
    'E': [[24.936664689141715, 66.94148390273371], [24.93678629700278, 66.94178699234577], [24.936434849956036, 66.94159387330092], [24.936567402766425, 66.94191573837567]],
    'F': [[24.936408096156892, 66.94160191992911], [24.9365406489956, 66.94194256046657], [24.936164879568278, 66.9417199371232], [24.936342427725283, 66.94208471754126]]
};

const map = L.map('map').setView([24.9368, 66.9415], 19.49);
L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
    { attribution: 'Tiles © Esri', maxZoom: 19.49 }
).addTo(map);

L.polygon(graveyardBoundary, { color:'blue', weight:2, fillOpacity:0.05 }).addTo(map);
map.fitBounds(L.polygon(graveyardBoundary).getBounds());

function generateSubGrid(boundary, subRows, subCols) {
    const subPlots = [];
    const [TL, TR, BL, BR] = boundary; 

    for (let r = 0; r < subRows; r++) {
        for (let c = 0; c < subCols; c++) {
            const latTop = TL[0] + (TR[0] - TL[0]) * (c / subCols);
            const lngTop = TL[1] + (TR[1] - TL[1]) * (c / subCols);
            const latTopNext = TL[0] + (TR[0] - TL[0]) * ((c+1) / subCols);
            const lngTopNext = TL[1] + (TR[1] - TL[1]) * ((c+1) / subCols);

            const latBottom = BL[0] + (BR[0] - BL[0]) * (c / subCols);
            const lngBottom = BL[1] + (BR[1] - BL[1]) * (c / subCols);
            const latBottomNext = BL[0] + (BR[0] - BL[0]) * ((c+1) / subCols);
            const lngBottomNext = BL[1] + (BR[1] - BL[1]) * ((c+1) / subCols);

            const lat1 = latTop + (latBottom - latTop) * (r / subRows);
            const lng1 = lngTop + (lngBottom - lngTop) * (r / subRows);
            const lat2 = latTopNext + (latBottomNext - latTopNext) * (r / subRows);
            const lng2 = lngTopNext + (lngBottomNext - lngTopNext) * (r / subRows);
            const lat3 = latTopNext + (latBottomNext - latTopNext) * ((r+1) / subRows);
            const lng3 = lngTopNext + (lngBottomNext - lngTopNext) * ((r+1) / subRows);
            const lat4 = latTop + (latBottom - latTop) * ((r+1) / subRows);
            const lng4 = lngTop + (lngBottom - lngTop) * ((r+1) / subRows);

            subPlots.push([[lat1,lng1],[lat2,lng2],[lat3,lng3],[lat4,lng4]]);
        }
    }
    return subPlots;
}

const plots = [];
const blocksOrder = ['A', 'B', 'C', 'D', 'E', 'F'];

// FIXED: Adjusting subRows and subCols so each block outputs exactly 200 plots (10 * 20 = 200)
// This guarantees Block A contains exactly ID #1 to #200, Block B contains #201 to #400, etc.
blocksOrder.forEach(blockKey => {
    const subRows = 10; 
    const subCols = 20; 
    const subGridPlots = generateSubGrid(blockBoundaries[blockKey], subRows, subCols);
    
    subGridPlots.forEach(coords => {
        plots.push({
            coords: coords,
            blockName: blockKey
        });
    });
});

plots.forEach((plotData, index) => {
    const coords = plotData.coords;
    const blockName = plotData.blockName; 
    
    const grave = graves.find(g => g.id === (index+1));
    const status = grave ? grave.status.toLowerCase() : 'available';
    const fillColor = status === 'available' ? '#28a745' : '#dc3545';

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

// Generates block labels exactly centered inside each individual block's boundary
['A','B','C','D','E','F'].forEach(name => {
    const boundary = blockBoundaries[name];
    if (boundary) {
        const center = L.polygon(boundary).getBounds().getCenter();
        L.marker(center, {
            icon: L.divIcon({
                className: 'block-label',
                html: `<b>${name}</b>`,
                iconSize: [30,30]
            })
        }).addTo(map);
    }
});

setTimeout(() => {
    const alert = document.querySelector(".alert");
    if (alert) {
        alert.classList.add("fade");
        setTimeout(() => alert.remove(), 500);
    }
}, 4000);
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