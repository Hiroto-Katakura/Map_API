<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reverse Geocode(Event:Click!)</title>
<style>html,body{height:80%;}body{padding:0;margin:0;background:#333;}h1{padding:0;margin:0;font-size:50%;color:white;}#address{overflow: auto;height: 100%;}#address div{border-bottom: 1px solid #888;font-size:12px;}#view_area{float:left;color:#fff;width:27%;margin-left: 20px;}</style>
</head>
<body>


<!-- MAP[START] -->
<div id="myMap" style="position:relative;float:left;width:70%;height:98%;"></div>
<div id="view_area">
    <h3>Reverse Geocode</h3>

    <p id="loclng"><p id="address"></p></p>
</div>
<!-- MAP[END] -->


<script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=ApCb7XJpUgCCeC68F2WVamw-skfedkKA4LyRQ6apstbPVHi7ATVFjVqOaRQov0Uq' async defer></script>
<script>
    //Reverse Geocode
    let map, searchManager,loc, i=0;
    function GetMap() {
        map = new Microsoft.Maps.Map('#myMap', {
            center: new Microsoft.Maps.Location(35.710, 139.810),
            zoom: 12
        });
        //Make a request to reverse geocode the center of the map.
        loc = map.getCenter();
        reverseGeocode();

        //Map Change Event add.
        Microsoft.Maps.Events.addHandler(map, 'click', function (e) {
            loc = e.location;
            reverseGeocode();  //Reverse Geocode
        });
    }

    function reverseGeocode() {
        //If search manager is not defined, load the search module.
        if (!searchManager) {
            //Create an instance of the search manager and call the reverseGeocode function again.
            Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
                searchManager = new Microsoft.Maps.Search.SearchManager(map);
                reverseGeocode();
            });
        } else {
            // const loc = loc;
            const searchRequest = {
                location: loc,
                callback: function (r) {
                    //Create custom Pushpin
                    let pin = new Microsoft.Maps.Pushpin(loc,{
                        title: r.name,       //PushPin:title
                        //subTitle: loc,     //PushPin:subtitle
                        text: `${++i}`       //PushPin:text
                    });
                    map.entities.push(pin);  //Add pushPin

                    //data is #address.
                    const div = document.createElement("div");            //create "DIV"
                    div.innerText=`(${i}) ${r.name}  \n緯度: ${loc.latitude}  経度: ${loc.longitude}`; //Create "html or text"
                    document.querySelector("#address").insertBefore(div, document.querySelector("#address").firstElementChild);//prepend
                },
                errorCallback: function (e) {
                    //If there is an error, alert the user about it.
                    alert("Unable to reverse geocode location.");
                }
            };
            //Make the reverse geocode request.
            searchManager.reverseGeocode(searchRequest);
        }
    }

</script>
</body>
</html>