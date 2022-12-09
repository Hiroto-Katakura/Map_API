<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reverse Geocode(Event:Click!)</title>
<style>html,body{height:80%;}body{padding:0;margin:0;background:#333;}h1{padding:0;margin:0;font-size:50%;color:white;}#address{overflow: auto;height: 100%;}#address div{border-bottom: 1px solid #888;font-size:12px;}#view_area{float:left;color:#fff;width:27%;margin-left: 20px;}</style>
</head>
<body>
<p>キーワード検索</p>
<p><input type="text" id="from" value=""> <button id="get">検索</button></p>

<!-- MAP[START] -->
<div id="myMap" style="position:relative;float:left;width:70%;height:98%;"></div>
<div id="view_area">
    <h3>出力結果一覧</h3>

    <p id="loclng"><p id="address"></p></p>
</div>
<!-- MAP[END] -->


<script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=ApCb7XJpUgCCeC68F2WVamw-skfedkKA4LyRQ6apstbPVHi7ATVFjVqOaRQov0Uq' async defer></script>
<script>
    //Reverse Geocode
    let map, searchManager,loc, i=0;
    function GetMap() {
        map = new Microsoft.Maps.Map('#myMap', {
            center: new Microsoft.Maps.Location(35.681236, 139.767125),
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

    /**
     * 検索ボタン[Click:Event]
     */
    document.getElementById("get").onclick = function(){
        //4.Geocode:住所から検索
        geocodeQuery(document.getElementById("from").value);
    };

    /**
     * 住所から緯度経度を取得
     * @param query [住所文字列]
     */
    function geocodeQuery(query) {
        if(searchManager) {
            //住所から緯度経度を検索
            searchManager.geocode({
                where: query,       //検索文字列
                callback: function (r) { //検索結果を"( r )" の変数で取得
                    //最初の検索取得結果をMAPに表示
                    if (r && r.results && r.results.length > 0) {
                        //Pushpinを立てる
                        const pin = new Microsoft.Maps.Pushpin(r.results[0].location);
                        map.entities.push(pin);
                        //map表示位置を再設定
                        map.setView({ bounds: r.results[0].bestView});
                        //取得た緯度経度をh1要素にJSON文字列にして表示
                        console.log(r.results[0].location);
                        document.getElementById("h1").innerText = JSON.stringify(r.results[0].location);
                    }
                },
                errorCallback: function (e) {
                    alert("見つかりません");
                }
            });
        }
    }
</script>
</body>
</html>