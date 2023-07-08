"use strict";

console.log('aaaa') ;

const btnScrollTo = document.querySelector(".btn--scroll-to");
const section1 = document.querySelector("#section--1");

// Button Scrolling
btnScrollTo.addEventListener("click", function (e) {
  console.log("hello world");
  const s1coords = section1.getBoundingClientRect();
  section1.scrollIntoView({ behavior: "smooth" });
});

/////////////////////////////
////////////////////////////
//////////////////////////////
// Map initialization
let latitude = 
  document
    .querySelector(".line3")
    .textContent.split(":")[1]
    .trim() ;

latitude =  Number(latitude.substring(0,latitude.indexOf(",")-1)) ;

let longitude = 
  document
    .querySelector(".line4")
    .textContent.split(":")[1]
    .trim() ; 

longitude = Number(longitude.substring(0,longitude.indexOf(",")-1)) ; 

console.log(latitude);
console.log(longitude);
var map = L.map("map").setView([latitude, longitude], 20);

// OSM Layer
var osm = L.tileLayer(
  "https://{s}.tile.jawg.io/jawg-matrix/{z}/{x}/{y}{r}.png?access-token={accessToken}",
  {
    attribution: "TICKETHIVE",
    minZoom: 0,
    maxZoom: 22,
    subdomains: "abcd",
    accessToken:
      "E77dSVd7j4hyNUxF9j4ox2GtJkWcM2dqEdDK5eNF1SrBFxf9WOiGwBKExUFYO97R",
  }
);
osm.addTo(map);

// var osmDark = L.tileLayer(
//   "https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png",
//   {
//     maxZoom: 20,
//     attribution:
//       '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
//   }
// );

// var nexrad = L.tileLayer.wms(
//   "http://mesonet.agron.iastate.edu/cgi-bin/wms/nexrad/n0r.cgi",
//   {
//     layers: "nexrad-n0r-900913",
//     format: "image/png",
//     transparent: true,
//     attribution: "Weather data © 2012 IEM Nexrad",
//   }
// );

// Marker
// var myIcon = L.icon({
//     iconUrl: "my-icon.png",
//     iconSize: [38, 95],
//     iconAnchor: [22, 94],
//     popupAnchor: [-3, -76],
//     // shadowUrl: "my-icon-shadow.png",
//     shadowSize: [68, 95],
//     shadowAnchor: [22, 94]
// });
// L.marker([50.505, 30.57], { icon: myIcon }).addTo(map);

let singleMarker = L.marker([latitude, longitude], {
  // icon: myIcon,
  draggable: true,
});

let eventName = document
  .querySelector(".home-content h1")
  .textContent.trim()
  .split("\n");

eventName.forEach(function (part, index, theArray) {
  theArray[index] = part.trim();
});

console.log(eventName.join(" "));


let eventLocation = document.querySelector(".localisation h3").textContent;
console.log(eventLocation);

let popup = singleMarker
  .bindPopup(
    "<h4>" +
      ` ${eventName.join(" ")}  ::  ` +
      " \n " +
      singleMarker.getLatLng() +
      "</h4>"
  )
  .openPopup();
popup.addTo(map);

// var secondMarker = L.marker([37.806389, 9.181667], { draggable: true });s

// console.log(singleMarker.toGeoJSON());

/////////////// GEOJSON
// var pointData = L.geoJSON(pointJson).addTo(map);
// var polygonData = L.geoJSON(polygonJson, {
//     onEachFeature: function (feature, layer) {
//         layer.bindPopup("<b>Name : </b>" + feature.properties.name);
//     },
//     style: {
//         fillColor: "red",
//         opacity: 1,
//         color: "#c0c0c0"
//     }
// }).addTo(map);

// Layer controller

var baseMaps = {
  // OSM: osm,
  // "OSM DARK": osmDark
};

var overlayMaps = {
  // "first Marker": singleMarker
  // "Second Marker": secondMarker,
  // "point Data": pointData,
  // "polygon Data": polygonData,
  // nexrad: nexrad
};

// var layerControl = L.control
//     .layers(baseMaps, overlayMaps, { collapsed: false })
//     .addTo(map);

////// Leaflet Events

// map.on("mousemove", function (e) {
//   document.getElementsByClassName("coordinate")[0].innerHTML =
//     "lat :" + e.latlng.lat + "  lng :" + e.latlng.lng;
//   // console.log("lat :" + e.latlng.lat, "lng :" + e.latlng.lng);
// });

// handling clicks on map
// map.on("click", function (e) {
//   map.removeLayer(singleMarker);
//   singleMarker = new L.marker([e.latlng.lat, e.latlng.lng], {
//     draggable: true,
//   });
//   map.addLayer(singleMarker);
//   popup = singleMarker
//     .bindPopup(
//       "Your event will be here , take these coordinates for further personal use : " +
//         singleMarker.getLatLng()
//     )
//     .openPopup();
//   popup.addTo(this);
//   // console.log("lat :" + e.latlng.lat, "lng :" + e.latlng.lng);

//   document.querySelector("#latitude").value = e.latlng.lat;
//   document.querySelector("#longitude").value = e.latlng.lng;
// });

// Search engine
// var geocoder = L.Control.geocoder({
//   defaultMarkGeocode: false,
// })
//   // .on("markgeocode", function (e) {
//   //     var bbox = e.geocode.bbox;
//   //     var poly = L.polygon([
//   //         bbox.getSouthEast(),
//   //         bbox.getNorthEast(),
//   //         bbox.getNorthWest(),
//   //         bbox.getSouthWest()
//   //     ]).addTo(map);
//   //     map.fitBounds(poly.getBounds());
//   // })
//   // .addTo(map);

//   .on("markgeocode", function (e) {
//     var bbox = e.geocode.bbox;
//     var latlng = e.geocode.center;
//     map.removeLayer(singleMarker);
//     singleMarker = new L.marker(latlng, { draggable: true })
//       .bindPopup(
//         "Your event will be here , take these coordinates for further personal use : " +
//           singleMarker.getLatLng()
//       )
//       .openPopup()
//       .addTo(map);
//     map.addLayer(singleMarker);
//     map.fitBounds(bbox);

//     // singleMarker = L.marker([e.latlng.lat, e.latlng.lng], {
//     //     draggable: true
//     // });
//     // popup = singleMarker
//     //     .bindPopup("This is a popup" + singleMarker.getLatLng())
//     //     .openPopup();
//     // popup.addTo(this);

//     document.querySelector("#latitude").value = latlng.lat;
//     document.querySelector("#longitude").value = latlng.lng;
//   })
//   .addTo(map);










/***ADD TO CART***/
let addToCartBtn = document.querySelector(".add-to-cart");
//open cart model from cart controller method
addToCartBtn.addEventListener("click", function () {
    let eventId = addToCartBtn.getAttribute("event-id");
     //<a href="/cart/add/${id}" class="btn add-to-cart" event-id="${event._id}">Add to cart</a> IN DESCRIPTION TWIG
    //change href of add to cart button
    addToCartBtn.setAttribute("href", `/cart/add/${eventId}`);

}
);



// var geocodeService = L.esri.Geocoding.geocodeService() ; 
// geocodeService.reverse().latlng([latitude,longitude]).run(function(error,result){
//   if(error){
//     return ; 
//   }

//   console.log(result.address.Match_addr) ; 

//   document.querySelector(".line2").textContent = result.address.Match_addr ; 
//   document.querySelector(".home-content").textContent = result.address.Match_addr ; 
// })

var geocodeService = L.esri.Geocoding.geocodeService();

geocodeService
    .reverse()
    .latlng([latitude,longitude])
    .run(function (error, result) {
        if (error) {
            return;
        }

        document.querySelector(".line2").textContent = result.address.Match_addr ; 
        document.querySelector(".hellohello").textContent = result.address.Match_addr ;
    });