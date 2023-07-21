<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GIS</title>
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
        .legend {
            background: white;
            padding: 10px;
            width: 150px;
            max-height: 250px;
            outline: 1px solid black;
            overflow: auto;
            overflow-x: hidden;
        }

     </style>
</head>
<body>
        
    <div id="map"></div>

    <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
 integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
 crossorigin=""></script>

<script>

const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
	maxZoom: 19,
	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
});

const usgs = L.tileLayer('https://basemap.nationalmap.gov/arcgis/rest/services/USGSImageryOnly/MapServer/tile/{z}/{y}/{x}', {
	maxZoom: 19,
	attribution: 'Usgs'
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

const transitions = new L.tileLayer("https://storage.googleapis.com/global-surface-water/tiles2021/transitions/{z}/{x}/{y}.png",
    { format: "image/png",
      maxZoom: 20,
      errorTileUrl : "https://storage.googleapis.com/global-surface-water/downloads_ancillary/blank.png",
      attribution: "2016 EC JRC/Google" });
    // map.addLayer(transitions);

const map = L.map('map', {
	center: [13.0834577,102.6641367,5.52],
	zoom: 7,
	layers: [osm]
});


// custom marker Baresoil
var baresoilIcon = L.icon({
    iconUrl: 'assets/icons/baresoil.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker Cassava
var cassavaIcon = L.icon({
    iconUrl: 'assets/icons/cassava.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker Crop
var cropIcon = L.icon({
    iconUrl: 'assets/icons/corn.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker Euscalyptus
var eucalyptusIcon = L.icon({
    iconUrl: 'assets/icons/leaf.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker Forest
var forestIcon = L.icon({
    iconUrl: 'assets/icons/forest.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker Grassland
var grasslandIcon = L.icon({
    iconUrl: 'assets/icons/grass.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker Paddy
var paddyIcon = L.icon({
    iconUrl: 'assets/icons/wetlands.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker Palm
var palmIcon = L.icon({
    iconUrl: 'assets/icons/palm.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker Rubber
var rubberIcon = L.icon({
    iconUrl: 'assets/icons/rubber.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker Settlement
var settlementIcon = L.icon({
    iconUrl: 'assets/icons/gedung.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker Sugarcane
var sugarcaneIcon = L.icon({
    iconUrl: 'assets/icons/sugarcan.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker Water
var waterIcon = L.icon({
    iconUrl: 'assets/icons/water.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});
// custom marker
var cornIcon = L.icon({
    iconUrl: 'assets/icons/corn.png',
    iconSize:     [38, 65],
			shadowSize:   [50, 64],
			iconAnchor:   [22, 94],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
});

const baseLayers = {
    'USGS' : usgs,
   'Google streets' : googleStreets,
   'Goggle satelit' : googleSat,
   'Goggle hibrid' : googleHybrid,
	'OpenStreetMap': osm,
	'OpenStreetMap.HOT': osmHOT,
    'Google Earth' : transitions
};

const baresoil = L.layerGroup();
const cassava = L.layerGroup();
const crop = L.layerGroup();
const eucalyptus = L.layerGroup();
const forest = L.layerGroup();
const grassland = L.layerGroup();
const paddy = L.layerGroup();
const palm = L.layerGroup();
const rubber = L.layerGroup();
const settlement = L.layerGroup();
const sugarcane = L.layerGroup();
const water = L.layerGroup();
const polygon = L.layerGroup();

const overlays = {
	'Baresoil' : baresoil,
    'Cassava' : cassava,
    'Corn' : crop,
    'Eucalyptus' : eucalyptus,
    'Forest' : forest,
    'Grassland' : grassland,
    'Paddy' : paddy,
    'Palm' : palm,
    'Rubber' : rubber,
    'Settlement' : settlement,
    'Sugarcane' : sugarcane,
    'Water' : water,
    'Water area' : polygon
};

const layerControl = L.control.layers(baseLayers, overlays).addTo(map);

$(document).ready(function(){
    $.getJSON('/pointCrop/json', function(data) {
        // loop class Baresoil
        $.each(data, function(index) {
            if (data[index].class === 'Baresoil') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:baresoilIcon}).addTo(baresoil).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            } 
            
        });
        // loop class Cassava
        $.each(data, function(index) {
            if (data[index].class === 'Cassava') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:cassavaIcon}).addTo(cassava).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            } 
            
        });
        // loop class Crop
        $.each(data, function(index) {
            if (data[index].class === 'Crop') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:cropIcon}).addTo(crop).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            } 
            
        });
        // loop class Eucalyptus 	
        $.each(data, function(index) {
            if (data[index].class === 'Eucalyptus') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:eucalyptusIcon}).addTo(eucalyptus).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            } 
            
        });
        // loop class Forest	
        $.each(data, function(index) {
            if (data[index].class === 'Forest') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:forestIcon}).addTo(forest).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            }
        });
        // loop class Grassland	
        $.each(data, function(index) {
            if (data[index].class === 'Grassland') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:grasslandIcon}).addTo(grassland).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            }
        });
        // loop class Paddy	
        $.each(data, function(index) {
            if (data[index].class === 'Paddy') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:paddyIcon}).addTo(paddy).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            }
        });
        // loop class Palm	
        $.each(data, function(index) {
            if (data[index].class === 'Palm') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:palmIcon}).addTo(palm).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            }
        });
        // loop class Rubber	
        $.each(data, function(index) {
            if (data[index].class === 'Rubber') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:rubberIcon}).addTo(rubber).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            }
        });
        // loop class Settlement 		
        $.each(data, function(index) {
            if (data[index].class === 'Settlement') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:settlementIcon}).addTo(settlement).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            }
        });
        // loop class Sugarcane 		
        $.each(data, function(index) {
            if (data[index].class === 'Sugarcane') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:sugarcaneIcon}).addTo(sugarcane).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            }
        });
        // loop class Water 		
        $.each(data, function(index) {
            if (data[index].class === 'Water') {
                L.marker([ parseFloat(data[index].latitude), parseFloat(data[index].longitude)], {icon:waterIcon}).addTo(water).bindPopup('Class : ' + data[index].class + '<br>  Coordinat : ' + data[index].latitude +','+ data[index].longitude);
            }
        });
        

    });
});

// Geo json
var geoLayer;
$.getJSON('assets/geojson/map2.geojson', function(json) {
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
                    // html: '<b>'+feature.properties.name+'</b>',
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

//  LEGENDA
var legend = L.control({position: 'bottomright'});

 legend.onAdd = function (map){
    var div = L.DomUtil.create('div', 'legend');

    labels = ['<strong>Information : </strong>'],

    categories = ['Baresoil', 'Cassava', 'Corn', 'Eucalyptus', 'Forest', 'Grassland', 'Paddy', 'Palm', 'Rubber', 'Settlement', 'Sugarcane', 'Water'];

    for (var i = 0; i < categories.length; i++){

        if (i==0) {
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/baresoil.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==1){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/cassava.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==2){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/corn.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==3){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/leaf.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        
        else if(i==4){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/forest.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==5){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/grass.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==6){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/wetlands.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==7){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/palm.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==8){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/rubber.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==9){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/gedung.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==10){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/sugarcan.png"><i class="circle" style:"background:#00000"></i> ' +
                            (categories[i] ? categories[i] : '+'));
                        
        }
        else if(i==11){
            div.innerHTML +=
                        labels.push(
                            '<img width="20" height="23" src="assets/icons/water.png"><i class="circle" style:"background:#00000"></i> ' +
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