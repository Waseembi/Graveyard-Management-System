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
#map{
    width:100%;
    height:850px;
    border-radius:10px;
    border:2px solid #ddd;
}
.leaflet-popup-content{
    text-align:center;
}
.block-label {
    font-size: 16px;
    font-weight: bold;
}
</style>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

// DB graves
const graves = @json($graves);

// Graveyard boundary
const graveyardBoundary = [
    [24.937069180177446, 66.94162743458993], // front right
    [24.936704357071687, 66.94090860264023], // front left
    [24.93598930065126, 66.94138067138331],  // back left
    [24.936334668556064, 66.94210486775054]  // back right
];

// Create map
const map = L.map('map').setView([24.9368, 66.9415], 19.45);
L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
    { attribution: 'Tiles © Esri', maxZoom: 19.45 }
).addTo(map);

// Draw boundary
L.polygon(graveyardBoundary, { color:'blue', weight:2, fillOpacity:0.05 }).addTo(map);
map.fitBounds(L.polygon(graveyardBoundary).getBounds());

// Grid generator with row + column spacing
function generateGridWithSpacing(boundary, rows, cols, rowGapCount, colGapCount) {
    const plots = [];
    const [FR, FL, BL, BR] = boundary;

    const totalRows = rows + rowGapCount; 
    const totalCols = cols + colGapCount; 

    for (let r = 0; r < totalRows; r++) {
        // skip horizontal gap rows
        if (r === Math.floor(totalRows/3) || r === Math.floor(2*totalRows/3)) continue;

        for (let c = 0; c < totalCols; c++) {
            // skip vertical gap columns (middle walkway)
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

// Generate 500 graves with spacing (20 rows, 25 cols, 2 gap rows, 1 gap col)
const plots = generateGridWithSpacing(graveyardBoundary, 20, 25, 2, 1);

// Block definitions: left side A,B,C; right side D,E,F
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

// Draw graves
plots.forEach((coords, index) => {
    const grave = graves[index];
    const status = grave ? grave.status : 'available';
    const fillColor = status === 'available' ? '#28a745' : '#dc3545';

    const row = Math.floor(index / 25);
    const col = index % 25;
    const blockName = getBlockName(row, col, 20, 25);

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
        case 'A': index = 2*25 + 2; break;
        case 'B': index = 8*25 + 2; break;
        case 'C': index = 15*25 + 2; break;
        case 'D': index = 2*25 + 20; break;
        case 'E': index = 8*25 + 20; break;
        case 'F': index = 15*25 + 20; break;
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
