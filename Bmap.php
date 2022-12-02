<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>api</title>
</head>
<body>
    <div id="myMap" style='position:relative;width:100%;height:600px;;'></div>
    <script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=ApCb7XJpUgCCeC68F2WVamw-skfedkKA4LyRQ6apstbPVHi7ATVFjVqOaRQov0Uq' async defer></script>
    <script>
        function GetMap() {
        let map = new Microsoft.Maps.Map('#myMap', {
            center: new Microsoft.Maps.Location(35, 135), //Location center position
        });

        //Get MAP Infomation
        let center = map.getCenter();

        //Create custom Pushpin
        let pin = new Microsoft.Maps.Pushpin(center, {
            color: 'red',            //Color
            draggable:true,          //MouseDraggable
            enableClickedStyle:true, //Click
            enableHoverStyle:true,   //MouseOver
            visible:true             //show/hide
        });

        //Add the pushpin to the map
        map.entities.push(pin);

    }
    </script>
</body>
</html>