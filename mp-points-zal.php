<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    
} else {
	header('Location: index.php');
	exit;
}
?>



<!DOCTYPE HTML>

<html>
	<head>
		<title>Add your locations</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.2.1/css/ol.css" type="text/css">

		<script src="ol.js"></script>
		<script type="text/javascript" src="ol-ext.js"></script>

		<script type="text/javascript" src="ol-geocoder/ol-geocoder.js"></script>
		<link rel="stylesheet" type="text/css" href="ol-geocoder/ol-geocoder.css">


		<style>
		.ol-popup {
			position: absolute;
			background-color: white;
			box-shadow: 0 1px 4px rgba(0,0,0,0.2);
			padding: 15px;
			border-radius: 10px;
			border: 1px solid #cccccc;
			bottom: 12px;
			left: -50px;
			min-width: 280px;
		}
		.ol-popup:after, .ol-popup:before {
			top: 100%;
			border: solid transparent;
			content: " ";
			height: 0;
			width: 0;
			position: absolute;
			pointer-events: none;
		}
		.ol-popup:after {
			border-top-color: white;
			border-width: 10px;
			left: 48px;
			margin-left: -10px;
		}
		.ol-popup:before {
			border-top-color: #cccccc;
			border-width: 11px;
			left: 48px;
			margin-left: -11px;
		}
		.ol-popup-closer {
			text-decoration: none;
			position: absolute;
			top: 2px;
			right: 8px;
		}
		.ol-popup-closer:after {
			content: "✖";
		}
		.h-display-none {
			display: none;
		}
		</style>


	</head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<nav class="left">
					<a href="#menu"><span>Menu</span></a>
				</nav>
				<a href="index.php" class="logo">maplay</a>
				<nav class="right">
				<?php

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	echo '<a href="phplogin/logout.php" class="button alt">Log out</a>';
} else {
	echo '<a href="acc-index.php" class="button alt">Log in</a><a href="acc-register.html" class="button alt">Sign up</a>';
}

?>

				</nav>


			</header>


		<!-- Menu -->
			<nav id="menu">
				<ul class="links">
					<li><a href="index.php">Home</a></li>
					<li><a href="mp-points.php">Add locations</a></li>
					<li><a href="mp-visual.php">Visualize</a></li>
					<li><a href="mp-read.php">Edit</a></li>
					<li><a href="acc-profile.php">Profile</a></li>
				</ul>
				<ul class="actions vertical">
					<li><a href="#" class="button fit">Login</a></li>
				</ul>
			</nav>

		<div class="inner">

			<div class="heading-cont" align="center">
				<h2>Select a point</h2>
				<h3>or upload a geoJSON file (only with point features) </h3>
							<input type="file" id="selectFiles" value="" accept=".geojson">
							<button id="import" class="button"> Upload </button>
			</div>



		<!-- Main -->
			<section id="main" class="wrapper">
						<div id="map" style="width: 100%; height: 600px"></div>
						<div id="popup" class="ol-popup">
								<a href="#" id="popup-closer" class="ol-popup-closer"></a>
								<div id="popup-content"></div>
							  </div>
		  	</section>
		<script>


			// Tohle je Jquery funkce, ktera se spustí, když jsou načteny všechny data
			// pro uživatele a tak je dobré mít věechen kód obalený touto funkcí
			$(document).ready(function() {

				
				var container = document.getElementById('popup');
				var content = document.getElementById('popup-content');
				var closer = document.getElementById('popup-closer');

				var popupOverlay = new ol.Overlay({
					element: document.getElementById('popup'),
					autoPan: true,
					autoPanAnimation: {
						duration: 250
					}
				});

				var r
				document.getElementById('import').onclick = function() {
					var files = document.getElementById('selectFiles').files;
					console.log(files);
					if (files.length <= 0) {
						return false;
					}
					var items=[];
						
					var fr = new FileReader()
					fr.onload = function(e){
						result = JSON.parse(e.target.result);
						var formatted = JSON.stringify(result, null, 2);
				

						// pro kazdou feature vytvoř marker
						$.each(result.features, function (key, val) {

							addMarker(null, val.geometry.coordinates);
             
						});

					}
				  fr.readAsText(files.item(0));
			

				};

			



				/**
				 * Add a click handler to hide the popup.
				 * @return {boolean} Don't follow the href.
				 */
				closer.onclick = function() {
					popupOverlay.setPosition(undefined);
					closer.blur();
					return false;
				};

				var view = new ol.View({
					center: ol.proj.fromLonLat([17.50, 49.25]),
					zoom: 4
					});
				
				var map = new ol.Map({
					title: 'OSM',
					target: 'map',
					overlays: [popupOverlay],
					layers: [
					new ol.layer.Tile({
						source: new ol.source.OSM()
					})
					],
					view: view
				});


					//GEOCODING


					//Instantiate with some options and add the Control
					var geocoder = new Geocoder('nominatim', {
					   provider: 'osm',
					   lang: 'en',
					   placeholder: 'Search for ...',
					   limit: 4,
					   debug: false,
					   autoComplete: true,
					   keepOpen: true
					 });
					 map.addControl(geocoder);
					
					 //Listen when an address is chosen
					 geocoder.on('addresschosen', function (evt) {
					 	console.info(evt);
					   window.setTimeout(function () {
					     popup.show(evt.coordinate, evt.address.formatted);
					   }, 3000);
					 });
			


				var vectorSource = new ol.source.Vector({});
				var projection = map.getView().getProjection();
				var map_source = new ol.source.Vector({});


				var markers = new ol.layer.Vector({
					source: map_source,
					format: new ol.format.GeoJSON({
						defaultDataProjection: 'EPSG:3857' // added line
					}),
					style: function(feature) {
						return new ol.style.Style({
							image: new ol.style.Icon({
							anchor: [0.5, 1],
							src: 'images/marker.png'
							})
						})
					}
				});
			
				markers.setZIndex( 1001 ); 

				map.addLayer(markers);

				// Pole, které drží všechny instance Marker class
				var markersArray = [];
				// Pole jmen míst mi bude držet inofrmace o nazvech míst
				var place_names = [];

				// Pole, které drží řádky formuláře
				var formLines = [];

				// var marker = new ol.Feature(new ol.geom.Point(ol.proj.fromLonLat([17.17150877229, 49.4001321324])));
				// markersArray.push(marker);

				markers.getSource().addFeatures(markersArray);
				map.on('click', function(evt){


					// Pokud jsme klikli na nejakou feature tedy marker, tak tahle funkce jej zachytí
					var clickedMarker = map.forEachFeatureAtPixel(evt.pixel, function(marker)	{ 
							return marker; 
						}
					);
					// pokud jsme klikli na marker, tak nechceme přidat další ale chceme zobrazit popus
					if(clickedMarker != undefined) {

						// V markeru jsme uložili id v poli názvu míst
						name_id = clickedMarker.get("name");
						// vytvoř html obsah do popupu
						content.innerHTML = '<p>'+place_names[name_id]+'</p>';
						// pridej posizici popupu
						popupOverlay.setPosition(evt.coordinate);

						// nedělej zbytek funkce
						return;
					}

					addMarker(evt, null);

				});

				function addMarker(evt, coor) {

					// Kdyz nahravam body z importu evt parametr je null a musim coordinates nahrat jinak
					if(evt != null) {
						var mouseCoords = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
					} else {
						var mouseCoords = coor;//ol.proj.transform(coor, 'EPSG:3857', 'EPSG:4326');
					}

					// Tady jsme kazdemu markeru pridali atribut name, ktery drzi index v poli place_names
					var newMarker = new ol.Feature({
						geometry: new ol.geom.Point(ol.proj.fromLonLat(mouseCoords)),
						name: place_names.length
					});

					var markerStyle = new ol.style.Style({
						image: new ol.style.Icon({
						anchor: [0.5, 1],
						src: 'images/marker.png'
						})
					})

					newMarker.setStyle(markerStyle);
					
					markersArray.unshift(newMarker);
					// Přidej do pole jmen prázdný string
					place_names.push("");

					markers.getSource().clear();
					markers.getSource().addFeatures(markersArray);


					var templateLon = '{x}';
					var templateLat = '{y}';
					var lon = ol.coordinate.format(mouseCoords, templateLon, 8);
					var lat = ol.coordinate.format(mouseCoords, templateLat, 8);

					// Vytvoř dictionary, které drží informace o řádku
					// uid nam pomuze s vazbou na jmena bodu do popupu
					var formLine = {
						"lat": lat,
						"lon": lon,
						"place_name": "",
						"date": "",
						"public": false,
						"uid": place_names.length-1
					}

					// unshift přidá novy řádek na první místo v poli, mohli bychom použít push
					// ale pro další ukony nám bude lepší když bude nejnovější udaj na prvním
					// místě pole
					formLines.unshift(formLine);

					// zavolje funkci, která upraví formulář
					updateForm(formLines);
				}

				// Fuknce, upraví formulář pro daný počet markerů
				function updateForm(lines) {

					// Uložíme si instanci těla tabulky, kde je formulář
					var tbody = $(".location-wrapper");

					// Pomocná proměnná kde budeme formovat obsah formuláře
					var form = "";

					// Tohle je JQuery funkce, kteraa funguje jako foreach smyčka
					// vezme to kazdy zaznam v dictionary lines a ve funkci můžeme
					// dělat co chceme s kazdym řádkém

					// My vytvoříme string pro každý řádek formuláře a přidáme ho do 
					// pomocné proměnné
					// Kazdemu bodu pridame i uid pro ucely popupu

					$.each(lines, function(key, val) {

						// začátek řádku tabulky
						if (key == 0) {
							form += '<tr class="selected" data-id="'+key+'" data-uid="'+val["uid"]+'">';
						} else {
							form += '<tr data-id="'+key+'" data-uid="'+val["uid"]+'">';
						}

						form +=	'<td><input class="lat" type="text" value="'+val["lat"]+'" name="lat'+key+'" id="latInput'+key+'" disabled/></td>';
						form +=	'<td><input class="lon" type="text" value="'+val["lon"]+'" name="lon'+key+'" id="lngInput'+key+'" disabled/></td>';
						form +=	'<td><input class="place_name" type="text" name="name'+key+'" value="'+val["place_name"]+'" id="name'+key+'" placeholder="Place name" required></td>';
						form +=	'<td><input class="date" type="date" value="'+val["date"]+'" name="date'+key+'" id="dateinput'+key+'"></td>';
						if(val["public"]) {
							form +=	'<td><input checked class="visibility" type="checkbox" id="visibility'+key+'" name="visibility'+key+'" value="Yes" style="opacity:1; -webkit-appearance: checkbox; appearance: checkbox;"></td>';
						} else {
							form +=	'<td><input class="visibility" type="checkbox" id="visibility'+key+'" name="visibility'+key+'" value="Yes" style="opacity:1; -webkit-appearance: checkbox; appearance: checkbox;"></td>';
						}
						form +=	'<td><button type="button" class="delete-btn" >delete</button></td>';
	
						// konec řádku tabulky
						form += "</tr>";

					})

					// Pomocí této funkce vložíme vytvořený formulář do těla tabulky/formuláře
					tbody.html(form);

					// Pro všechny input pole typu datum umožni maximalní vstup dnešní datum
					$('[type="date"]').prop('max', function(){
						return new Date().toJSON().split('T')[0];
					});
				}

				// Tahle funkce navazuje event listener na naše delete tlačítka. 
				// Řádky a celý formuklář je přidávám dynamicky a to znamená, že aby se na tyto
				// elementy navázalo nejakou událost/event listener, tak musííme použít funcki a jeji
				// konstrukci jakou vidíme tady. Začínááme elemntem který je stálý, nemění se.
				// Což je v otmto případě html, ale můžeme použít třeba i body nebo nějaky parent element
				// formuláře. 
				$("html").on("click", ".delete-btn", function(e) {
					e.preventDefault();

					// Sežeň id řádeku údaje, který chceme smazat.
					// Při vytváření formuláře jsme přidali data-id attribute každému cancel tlačítku
					// Tohle id odpovídá id řádku v poli formLines a tak můžeme snadno tento údaj vymazat
					var id = getIdOfLine($(this));

					// Vymaž údaj v poli na pozici daného id. Funkce splice vezme id 
					// elementu k vymazání a počet elementů za ním k vymazání, takže v našem případě 1
					formLines.splice(id,1);

					// Uprav formulář podle nových záznamů bez vymyzaného řádku
					updateForm(formLines);

					// Stejně tak musímě v poli markerů vymazat odpovídající marker k dané pozici
					markersArray.splice(id,1);

					// A následně znovu vyrenderovat nové pole markerů na mapu
					markers.getSource().clear();
					markers.getSource().addFeatures(markersArray);

				})

				// Při jakékoliv změné názvu místa se upraví naše formLines pole,
				// abychom při znovu renderovaní polí formuláře mohli vložit hodnoty,
				// které uživatel vložil již předtím
				$("html").on("change paste keyup", ".place_name", function(e) {
					
					// Sežeň id řádku stejně jako v předchozí funkci
					var id = getIdOfLine($(this));
					var uid = getUidOfLine($(this));

					// Uprav hodnotu řádku v formLines novou hodnotou place name inputu
					formLines[id]["place_name"] = $(this).val();

					// Nahrad take udaj na danem uid v poli jmen pro popup
					place_names.splice(uid,1,$(this).val())

				})

				// Při jakékoliv změné data návštěvy místa se upraví naše formLines pole,
				// abychom při znovu renderovaní polí formuláře mohli vložit hodnoty,
				// které uživatel vložil již předtím
				$("html").on("change paste keyup", ".date", function(e) {
					
					// Sežeň id řádku stejně jako v předchozí funkci
					var id = getIdOfLine($(this));

					// Uprav hodnotu řádku v formLines novou hodnotou place name inputu
					formLines[id]["date"] = $(this).val();

				})

				// Při jakékoliv změné viditelnosti bodu se upraví naše formLines pole,
				// abychom při znovu renderovaní polí formuláře mohli vložit hodnoty,
				// které uživatel vložil již předtím
				$("html").on("change paste keyup", ".visibility", function(e) {
					
					// Sežeň id řádku stejně jako v předchozí funkci
					var id = getIdOfLine($(this));

					// Uprav hodnotu řádku v formLines novou hodnotou place name inputu
					formLines[id]["public"] = $(this).prop('checked');


				})

				// Při najetí na řádek ve formuláři se zvýrazní daný bod v mapě
				$("html").on("mouseenter", "tbody tr", function(e) {
					
					// Sežeň id řádku stejně jako v předchozí funkci
					var id = $(this).data("id");

					var feature = markersArray[id];

					var markerStyle = new ol.style.Style({
						image: new ol.style.Icon({
						anchor: [0.5, 1],
						src: 'images/marker2.png'
						})
					})

					feature.setStyle(markerStyle)


				})

				// Když kurzor opusti řádek formuláře a marker se vrátí do defaultní podoby
				$("html").on("mouseleave", "tbody tr", function(e) {
					
					// Sežeň id řádku stejně jako v předchozí funkci
					var id = $(this).data("id");

					var feature = markersArray[id];

					var markerStyle = new ol.style.Style({
						image: new ol.style.Icon({
						anchor: [0.5, 1],
						src: 'images/marker.png'
						})
					})

					feature.setStyle(markerStyle)

				})

				// Pomocná funkce, která vezme element v parametru a pomoci funkce closest najde
				// nejbližší tr element a vrátí hodnotu jeho data-id parametru
				function getIdOfLine(el) {
					return el.closest("tr").data("id");
				}

				// Pomocná funkce, která vezme element v parametru a pomoci funkce closest najde
				// nejbližší tr element a vrátí hodnotu jeho data-uid parametru
				function getUidOfLine(el) {
					return el.closest("tr").data("uid");
				}

				// Tady pošleme formuláč pomocí ajaxu a post methody
				// tím že máme ten kumulativní způsob více bodu je tohle mnohem lepší 
				// cesta než jako čiste pres fomr submit
				$(".form-inline").on("submit", function(e) {

					// Zabran defaultnimu poslani formulaře, to by bylo peklo řesit na php straně
					e.preventDefault();

					var collection_data = []

					var isCollection = $(".collection-radio:checked").val();

					if (isCollection == "Yes") {
						var collection_name = $("#collection-name").val()
						var collection_visibility = $("#collection-visibility").prop('checked');

						formLines.map(function(val, i) {
							val["public"] = collection_visibility;
						})
						collection_data.unshift({"name": collection_name,"public": collection_visibility});

					}

					var data = {"collection": collection_data, "points":formLines}

					// Ajax funkce, methoda post protože posíláme data ze frontendu do databaze
					// data posilame jako Json, takze vezmeme pole formLine s pomoci
					// JSON.stringify funkce z toho udelame validní json format
					$.ajax({
						type: "POST",
						url: "./save.php",
						data: {
							'data': JSON.stringify(data)
						},
						success: function(response) {
							// Tadyhle budeme nakládat z odpovědí, kterou nám pošle php script
							// udelal jsem to tak, že je odpověd také v json a má dva klíče
							// status a message. Status bude true/false podle toho jestli se data uložila
							// správně. a v message budeš mít informaci bud ze vsechno dobre dopadlo
							// a nebo ze je nejaka chyba. 

							console.log(response);
							var res = JSON.parse(response);
							alert(res["message"]);
						
						}
					});

				})


			});

		</script>
				

		<div class="form">  

			<form class="form-inline" action="save.php" method="post" target="hiddenFrame" enctype="multipart/form-data" > 
				<div class="collection-wrapper">
					<div class="collection-line" style="margin: 20px 0px;">

						<span style="padding:0px 10px 0px 0px;">Do you want these points to be a collection?</span>
						<input class="collection-radio" type="radio" id="isCollectionYes"  name="isCollection" value="Yes">
						<label for="isCollectionYes">Yes</label>
						<input class="collection-radio" type="radio" id="isCollectionNo" name="isCollection" value="No" checked>
						<label for="isCollectionNo">No</label>
					</div>

					<div class="collection-line collection-name__line h-display-none" style="margin: 20px 0px;">

						<input class="collection-name" type="text" id="collection-name"  name="collection-name" placeholder="Collection name">
						<input class="collection-visibility" type="checkbox" id="collection-visibility" name="collection-visibility" value="Yes">
						<label for="collection-visibility" style="margin: 10px 0px;">Public</label>
					</div>
				</div>

				<script>
					$(document).ready(function() {

						$("html").on("change paste keyup", ".collection-radio", function(e) {
							

							var isCollection = $(this).val();

							$(".collection-name__line").toggleClass("h-display-none");
							// if(isCollection == "Yes") {
							// }
							// Sežeň id řádku stejně jako v předchozí funkci
							// var id = getIdOfLine($(this));

							// Uprav hodnotu řádku v formLines novou hodnotou place name inputu
							// formLines[id]["public"] = $(this).prop('checked');


						})

					})
				</script>

				<table class="location-table">
					<thead>
						<tr>
							<td>Latitude</td>
							<td>Longitude</td>
							<td>Place name</td>
							<td>Date of visit</td>
							<td>Public</td>
							<td></td>
						</tr>
					</thead>
					<tbody class="location-wrapper">
						<!-- <tr>
							<td><input class="lat" type="text" name="lat1" id="latInput1" disabled/></td>
							<td><input class="lon" type="text" name="lon1" id="lngInput1" disabled/></td>
							<td><input class="place_name" type="text" name="name1" value="" id="name1" placeholder="Place name" required></td>
							<td><input class="date" type="date" name="date1" id="dateinput1"></td>
							<td><input type="checkbox" id="visibility1" name="visibility1" value="Yes"></td>
							<td><button class="delete-btn" data-id="1">delete</button></td>
						</tr> -->
					</tbody>
				</table>
				<!-- <label for="latInput">Latitude</label> 
				<input type="text" name="lat" id="latInput"/>
				<label for="lngInput">Longitude</label> 
				<input type="text" name="lon" id="lngInput" />

				<label for="name">Place name</label> 
				<input type="text" name="name" value="" id="name" placeholder="enter name" required="">

				<label for="dateinput"> Date of visit </label>
				<input type="date" name="date" id="dateinput">


				<input type="checkbox" id="visibility" name="visibility" value="Yes">
				<label for="visibility"> Public point? </label> <br> -->
					<br>

					<!--Description <textarea name="textarea" cols="17" rows="3"> </textarea>  -->

					<input type="submit" value="Submit">
					<input type="reset" value="Clear">
				
					
			</form> 



		</div>	
	</div>





		<!-- Footer -->
			<footer id="footer">
				<div class="inner">
					<h2>Problem? Let me know.</h2>
					<ul class="actions">
						<li><span class="icon fa-envelope"></span> <a href="mailto:dominik.vit01@upol.cz?subject=Maplay_issue">dominik.vit01@upol.cz</a></li>
						<li><span class="icon fa-map-marker"></span> Olomouc, Czechia</li>
					</ul>
				</div>
				<div class="copyright">
					&copy; 2020 | Dominik Vít | <a href="http://www.geoinformatics.upol.cz/">Dept. of Geinformatics of Palacky university.</a> <br>
					This app was made as a bachelor thesis project.
					 Design made with <a href="https://templated.co">TEMPLATED</a>.
				</div>
			</footer>
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>