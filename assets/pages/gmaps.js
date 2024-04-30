var map;
var place = {name:'Helsinki', latitude:60.1699, longitude:24.9384, team:'Team Name', smb:'2535252535', last_seen:'2021-09-12'}
$(document).ready(function(){
  // Markers
  map = new GMaps({
    div: '#gmaps-markers',
    lat: 60.1699,
    lng: 24.9384
  });
  let infowindow = new google.maps.InfoWindow();
  map.addMarker({
    lat: 60.1699,
    lng: 24.9384,
    details: {
      database_id: 42,
      author: 'HPNeo'
    },
    click: function(e){
      
    },
    mouseover: function() {
      infowindow.open(map, this);
      infowindow.setContent("<h4>" + place.name +
      "</h4><p><b>Latitude:</b> " + place.latitude + "</p><p><b>Longitude:</b> " + place.longitude + 
      "</p><p><b>Team:</b> " + place.team + "</p><p><b>SMB Ref. No-:</b> " + place.smb + 
      "</p><p><b>Last Seen:</b> " + place.last_seen + "</p>")
    },
    mouseout: function() {
      infowindow.close();
    }
  });

  // Overlays
  map = new GMaps({
    div: '#gmaps-overlay',
    lat: -12.043333,
    lng: -77.028333
  });
  map.drawOverlay({
    lat: map.getCenter().lat(),
    lng: map.getCenter().lng(),
    content: '<div class="gmaps-overlay">Our Office!<div class="gmaps-overlay_arrow above"></div></div>',
    verticalAlign: 'top',
    horizontalAlign: 'center'
  });

  //panorama
  map = GMaps.createPanorama({
    el: '#panorama',
    lat : 42.3455,
    lng : -71.0983
  });

  //Map type
  map = new GMaps({
    div: '#gmaps-types',
    lat: -12.043333,
    lng: -77.028333,
    mapTypeControlOptions: {
      mapTypeIds : ["hybrid", "roadmap", "satellite", "terrain", "osm"]
    }
  });
  map.addMapType("osm", {
    getTileUrl: function(coord, zoom) {
      return "https://a.tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
    },
    tileSize: new google.maps.Size(256, 256),
    name: "OpenStreetMap",
    maxZoom: 18
  });
  map.setMapTypeId("osm");
});