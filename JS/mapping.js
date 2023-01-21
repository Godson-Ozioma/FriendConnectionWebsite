
console.log("mapping connected");



/**
 * Creates the map
 * Adds the friends location on the map
 * Creates a marker to mark the friends location and adds a clicking effect which allows user see name of friend on a marker
 */

var map = new OpenLayers.Map("Map");//creates a variable map to link to the Map
//adds a layer to the map
map.addLayer(new OpenLayers.Layer.OSM());

//constructs the map and creates the positioning
epsg4326 = new OpenLayers.Projection("EPSG:4326");
projectTo = map.getProjectionObject();


var lonLat = new OpenLayers.LonLat(-0.1279688, 51.5077286).transform(epsg4326, projectTo);

var zoom = 3;
//positions the map at the center
map.setCenter(lonLat, zoom);
//
var vectorLayer = new OpenLayers.Layer.Vector("Overlay");


/**
 * Determines the location of the friends on the map
 * creates markers to show friend position on the map
 * Add layers and features
 */
function liveLocation(){
    let xhr = new XMLHttpRequest();
//creating an empty area that stores the friend locations
    let locations = [];


    xhr.onreadystatechange = function (){
        if (xhr.readyState == 4 && xhr.status == 200)//success and failure coding
        {

            // console.log("res: " + xhr.responseText);
            locations = JSON.parse(xhr.responseText);

            // locations.forEach(function (item){
            //     console.log("l: " + item[2] + ", l1: " + item[1]);
            //     var feature = new OpenLayers.Feature.Vector(
            //
            //         new OpenLayers.Geometry.Point(item[2], item[1]).transform(epsg4326, projectTo),
            //         {description: item[0]},
            //         {
            //             externalGraphic: '../images/marker.png', graphicHeight: 30, graphicWidth: 30,
            //             graphicXOffset: -12, graphicYOffset: -25
            //         }
            //     );
            //     vectorLayer.addFeatures(feature);
            // });

            locations.forEach(createMarkers);

        }
    }

    map.addLayer(vectorLayer); // add the vector layer to the map

    let controls = {
        //controller for the pop up after the marker has been clicked
        selector: new OpenLayers.Control.SelectFeature(vectorLayer, {
            onSelect: createPopup, onUnselect: destroyPopup})
    }

    map.addControl(controls['selector']);
    controls['selector'].activate();



    xhr.open('GET', 'friends.php?live_location=true');
    xhr.send();
}

/**
 * creating the markers
 *
 */
function createMarkers(item){
    console.log("l: " + item[2] + ", l1: " + item[1]);
    var feature = new OpenLayers.Feature.Vector(
        //identifies the users position and places the marker at that spot
        new OpenLayers.Geometry.Point(item[2], item[1]).transform(epsg4326, projectTo),
        {description: item[0]},
        {
            //change the look of the marker
            externalGraphic: '../images/marker.png', graphicHeight: 30, graphicWidth: 30,
            graphicXOffset: -12, graphicYOffset: -25
        }
    );
    //add the new features to the layer
    vectorLayer.addFeatures(feature);
}
// map.addLayer(vectorLayer);


//create the pop up that comes up when the marker is clicked
function createPopup(feature){
    feature.popup = new OpenLayers.Popup.FramedCloud(
        "pop",
        feature.geometry.getBounds().getCenterLonLat(),
        null,
        '<div class="markerContent">' + feature.attributes.description +'</div>',
        null,
        true,
        function(){controls['selector'].unselectAll();}
    );
    //add the pop up to the map
    map.addPopup(feature.popup);

}
//destroy the pop up after it has been clicked
function destroyPopup(feature){
    feature.popup.destroy();
    feature.popup = null;
}



//clear the features on the layers. This function works to remove the features such as the marker and refresh it using the queue method
function clearFeatures(){
    var features = vectorLayer.features;

    // destroy the popup
    vectorLayer.features.forEach(function(feature){
        if(feature.popup != null){ // the popup is displayed
            destroyPopup(feature);  // destroy the popup
        }

    });
    vectorLayer.removeFeatures(features);//removes features


}

//function to hold the method that would be needed for the live location of the friend to be updated
function queue(){
    liveLocation();
    clearFeatures();
    // map.removeLayer(vectorLayer);
}

//this is what gives the map its authomatically refreshes the layer every 2 seconds.
document.addEventListener('DOMContentLoaded', function (){
    const interval = setInterval(queue, 2000);//calls the queue and sets interval to 2000(2 seconds)
});







