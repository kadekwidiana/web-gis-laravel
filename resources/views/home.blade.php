<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     <style>
        #map { height: 100vh; }

        .label-bidang {
            font-size: 10pt;
            color: black;
            text-align: center;
        }
        .legend{
            background: white;
            padding: 10px;
            width: 150px;
            height: 200px;
            outline: 1px solid black;
        }
     </style>
</head>
<body>
    <div class="">
        <p>Cari lokasi</p>
        <select name="" id="" onchange="cari(this.value)">
            @foreach ($result as $item)
                
            <option value="{{ $item->id }}">{{ $item->nama }}</option>
            @endforeach
        </select>
    </div>
    <br>
    <div id="map"></div>

    <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
 integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
 crossorigin=""></script>
 {{-- leaflet asset --}}
 <script src="assets/leaflet/leaflet.textpath.js"></script>

<script>

const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
	maxZoom: 19,
	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
});

const osmHOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
	maxZoom: 19,
	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Tiles style by <a href="https://www.hotosm.org/" target="_blank">Humanitarian OpenStreetMap Team</a> hosted by <a href="https://openstreetmap.fr/" target="_blank">OpenStreetMap France</a>'
});

const googleHybrid = L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}',{
    maxZoom: 19,
    subdomains:['mt0','mt1','mt2','mt3']
});

const googleSat = L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});

const googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
});

const map = L.map('map', {
	center: [-8.4553335,114.7419131,10],
	zoom: 10,
	layers: [osm]
});


// custom marker
var cornIcon = L.icon({
    iconUrl: 'assets/icons/corn.png',
    iconSize:     [30, 30], // size of the icon
    shadowSize:   [50, 64], // size of the shadow
    iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
    shadowAnchor: [4, 62],  // the same for the shadow
    popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

const baseLayers = {
   'Google streets' : googleStreets,
   'Goggle satelit' : googleSat,
   'Goggle hibrid' : googleHybrid,
	'OpenStreetMap': osm,
	'OpenStreetMap.HOT': osmHOT
};

const crop = L.layerGroup();
const polygon = L.layerGroup();

const overlays = {
	'Crop': crop,
    'Polygon' : polygon
};

const layerControl = L.control.layers(baseLayers, overlays).addTo(map);

$(document).ready(function(){
    $.getJSON('point/json', function(data) {
        $.each(data, function(index) {
            // alert(data[index].name);
            L.marker([parseFloat(data[index].longitude), parseFloat(data[index].latitude)]).addTo(crop).bindPopup(data[index].name);
        });
    });
});

// Geo json
var geoLayer;
$.getJSON('assets/geojson/map.geojson', function(json) {
    geoLayer = L.geoJson(json, {
        style: function(feature){
            return {
                fillOpacity: 0,
                weight: 2,
                opacity: 1,
                color: "green",

                // dashArray: '30 10',
                // lineCap: 'square'
            };
        },

        onEachFeature: function(feature, layer) {
            // alert();
            var iconLabel = L.divIcon({
                    className: "label-bidang",
                    html: '<b>'+feature.properties.name+'</b>',
                    iconSize:[100, 20]
            });

            L.marker(layer.getBounds().getCenter(), {icon:iconLabel}).addTo(map);

            // ketika on click tampilkan popup
            layer.on('click', (e)=>{
                // alert(feature.properties.id);
                // $.getJSON('point/location/'+feature.properties.id, function(detail){
                //     $.each(detail, function(index) {
                //         alert(detail[index].alamat);
                //       });
                // });
                $.getJSON('point/location/' + feature.properties.id, function(detail) {
                    // alert(detail.alamat);

                    var html='<img height="100px" src="assets/img/'+detail.gambar+'">';
                        html+='<h5> Nama lokasi : ' +detail.nama+ '</h5>';
                        html+='<h6>Alamat : '+detail.alamat+'</h6>'

                    L.popup()
                        .setLatLng(layer.getBounds().getCenter())
                        .setContent(html)
                        .openOn(map);
                });
            });

            layer.addTo(polygon);

        }
    })
})

// Geo json
$.getJSON('assets/geojson/sungai.geojson', function(json) {
    geoLayer = L.geoJson(json, {
        style: function(feature){
            return {
                weight: 5,
                opacity: 1,
                color: "blue",

            };
        },

        onEachFeature: function(feature, layer) {
            layer.setText(feature.properties.name,{
                repeate: false, offset: -5, orientation: "angle", attributes: {
                    style: "font-size:7pt", fill: "#05ffod"
                }
            }); 
            
            // ketika on click tampilkan popup
            layer.on('click', (e)=>{
              layer.setStyle(
                {
                    color: 'yellow',
                    fillColor: '#1a7f91',
                    weight:2,
                    lineCap: 'square'
                }
              )
              layer.on('click', (e)=>{
              layer.setStyle(
                {
                    color: 'blue',
                    fillColor: '#1a7f91',
                    weight:2,
                    lineCap: 'square'
                }
              )
            });
            });

            layer.addTo(map);

        }
    })
});

// Pencarian lokasi
function cari(id) { 
    geoLayer.eachLayer(function(layer){

        if (layer.feature.properties.id==id) {
            map.flyTo(layer.getBounds().getCenter(), 19);
            // layer.bindPopup(layer.feature.properties.nama);
        }
    });
    
 }

//  LEGENDA
var legend = L.control({position: 'bottomright'});

 legend.onAdd = function (map){
    var div = L.DomUtil.create('div', 'legend');

    labels = ['<strong>Keterangan : </strong>'],

    categories = ['Padi', 'Jagung', 'Hutan', 'Gunung', 'Gedung', 'Danau'];

    for (var i = 0; i < categories.length; i++){

        if (i==0) {
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/wetlands.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==1){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/corn.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==2){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/forest.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==3){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/gunung.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        
        else if(i==4){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/gedung.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==5){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/waterdrop.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==6){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/gedung.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
    }
    div.innerHTML = labels.join('<br>');
return div;
 };
 
 legend.addTo(map);

</script>
</body>
</html>