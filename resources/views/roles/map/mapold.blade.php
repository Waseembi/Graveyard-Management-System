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

const map = L.map('map').setView([24.9368, 66.9415], 19.49);
L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
    { attribution: 'Tiles © Esri', maxZoom: 19.49 }
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
 {{-- success message --}}
 @if(session('success'))
     <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
         position: absolute; top: 20px; left: 50%; transform: translateX(-50%);
         max-width: 400px; z-index: 1050; box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
         border-radius: 6px; font-weight: 500; font-size: 0.95rem; padding: 0.5rem 1rem; line-height: 1.3;
     ">
         {{ session('success') }}
     </div>
 @endif

 {{-- Validation Errors --}}
 @if ($errors->any())
     <div class="alert alert-danger text-center mx-auto mt-5" style="
         position: absolute; top: 20px; left: 50%; transform: translateX(-50%);
         max-width: 400px; z-index: 1050; box-shadow: 0 0.5rem 1rem rgba(128, 0, 0, 0.2);
         border-radius: 6px; font-weight: 500; font-size: 0.95rem; padding: 0.5rem 1rem; line-height: 1.3;
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
         position: absolute; top: 20px; left: 50%; transform: translateX(-50%);
         max-width: 400px; z-index: 1050; box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
         border-radius: 6px; font-weight: 500; font-size: 0.95rem; padding: 0.5rem 1rem; line-height: 1.3;
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
#map { width:100%; height:850px; border-radius:10px; border:2px solid #ddd; }
.leaflet-popup-content { text-align:center; }
.block-label { font-size:16px; font-weight:bold; }
</style>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
const graves = @json($graves);

// Initialize map
const map = L.map('map').setView([24.9368, 66.9415], 19.3);
L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
    { attribution: 'Tiles © Esri', maxZoom: 19.49 }
).addTo(map);

// Plot graves directly from DB
graves.forEach(grave => {
    const status = grave.status.toLowerCase();
    const fillColor = status === 'available' ? '#28a745' : '#dc3545';

    const marker = L.circleMarker([grave.lat, grave.lng], {
        radius: 5,
        color: '#000',
        weight: 1,
        fillColor: fillColor,
        fillOpacity: 0.8
    }).addTo(map);

    let popupHtml = `
        <div>
            <strong>Grave #${grave.id}</strong><br>
            Block: ${grave.block}<br>
            Status: ${status}<br><br>
    `;
    if(status === 'available'){
        popupHtml += `<a href="/grave-book/${grave.id}" class="btn btn-success btn-sm">Book Grave</a>`;
    } else {
        popupHtml += `<button class="btn btn-danger btn-sm" disabled>Booked</button>`;
    }
    popupHtml += `</div>`;
    marker.bindPopup(popupHtml);
});

// Block boundaries (polygons)
const blockBoundaries = {
    A: [
        [24.93667776199227, 66.94093807320208], // top left
        [24.936846796868508, 66.94132833460642], // top right
        [24.9366716815965, 66.94141282418855],   // bottom right
        [24.936520887690858, 66.94103999714241]  // bottom left
    ],
    B: [
        [24.936506294721397, 66.94105609039644],
        [24.936651008248518, 66.94144769290406],
        [24.936429681607247, 66.9415469346362],
        [24.9362861839029, 66.94119288305399]
    ],
    C: [
        [24.936264294405436, 66.94121434072669],
        [24.936394415235096, 66.94156839230892],
        [24.93615849512491, 66.94167970398061],
        [24.93600770059107, 66.94137661436855]
    ],
    D: [
        [24.93686412582197, 66.94137393307061],
        [24.936989380905622, 66.94165958648023],
        [24.93681183464252, 66.94178565123627],
        [24.936685362490714, 66.94147317389287]
    ],
    E: [
        [24.936664689141715, 66.94148390273371],
        [24.93678629700278, 66.94178699234577],
        [24.936567402766425, 66.94191573837567],
        [24.936434849956036, 66.94159387330092]
    ],
    F: [
        [24.936408096156892, 66.94160191992911],
        [24.9365406489956, 66.94194256046657],
        [24.936342427725283, 66.94208471754126],
        [24.936164879568278, 66.9417199371232]
    ]
};

// Draw block polygons and labels
Object.entries(blockBoundaries).forEach(([name, coords]) => {
    L.polygon(coords, { color:'blue', weight:2, fillOpacity:0.05 }).addTo(map);
    const center = L.polygon(coords).getBounds().getCenter();
    L.marker(center, {
        icon: L.divIcon({
            className: 'block-label',
            html: `<b>${name}</b>`,
            iconSize: [30,30]
        })
    }).addTo(map);
});

// Auto-hide alerts
setTimeout(() => {
    const alert = document.querySelector(".alert");
    if (alert) {
        alert.classList.add("fade");
        setTimeout(() => alert.remove(), 500);
    }
}, 4000);

</script>
@endsection --}}
