<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}


?>

<!DOCTYPE HTML>

<html>
	<head>
		<title>Your Points</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.2.1/css/ol.css" type="text/css">
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	
		<script src="ol.js"></script>
		<script src="ol-ext.js"></script>
		<link rel="stylesheet" href="ol-ext.css" />


    
  </head>
	<body class="subpage">

		<!-- Header -->
			<header id="header">
				<nav class="left">
					<a href="#menu"><span>Menu</span></a>
				</nav>
				<a href="index.php" class="logo">maplay</a>
				<nav class="right">
					<a href="phplogin/logout.php" class="button alt">Log out</a>
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

		<!-- Main -->

        <script>
        	//VYHLEDAVANI UZIVATELU
				$(document).ready(function(){
				    $('.user-search input[type="text"]').on("keyup input", function(){
				        /* Get input value on change */
				        var inputVal = $(this).val();
				        var resultDropdown = $(this).siblings(".result");
				        if(inputVal.length){
				            $.get("search-user.php", {term: inputVal}).done(function(data){
				                // Display the returned data in browser
												
				                resultDropdown.html(data);
				            });
				        } else{
				            resultDropdown.empty();
				        }
				    });
				    
				    // Set search input value on click of result item
				    $(document).on("click", ".result p", function(){
				        $(this).parents(".user-search").find('input[type="text"]').val($(this).text());
				        $(this).parent(".result").empty();
				    });

						$("html").on("click", ".show-user-collections", function() {

							const id = $(this).data("id");
							const name = $(this).data("name");

							$(".selected-user").html(name + "'s public collections:");

							

							$.when($.ajax({    //create an ajax request to display php
								type: "GET",
								url: "getUserCollectionById.php?id="+id,             
								dataType: "json",   //expect json to be returned                
								success: function(response){      
									// Potřebujeme dictionary rozšířit aby se zobrazily všechny vybrané kolekce   
									lines = response
									
								}

							})).done(function(){

								var table = $(".collection-search-list");

								var collections = '<thead><tr><td>Name</td><td>Add to map</td></tr></thead><tbody class="collection-search-tbody">'

								$.each(lines, function(key, val) {

									collections += '<tr data-id="'+val["id"]+'"></tr>';

									collections += '<td>'+val["collNAME"]+'</td>';

									collections += '<td><input data-id="'+val["id"]+'" class="display-collection" type="checkbox" id="display" value="Yes" style="opacity:1; -webkit-appearance: checkbox; appearance: checkbox;"> </td>'

									collections += "</tr>";

								})

								collections += "</tbody>";

								// Pomocí této funkce vložíme vytvořený formulář do těla tabulky/formuláře
								table.html(collections);
							});

							// $(".user-collection__result").html()
						})

				    $('.collection-search input[type="text"]').on("keyup input", function(){
				        /* Get input value on change */
				        var inputVal = $(this).val();
				        var resultDropdown = $(this).siblings(".result-coll");
				        if(inputVal.length){
				            $.get("search-collection.php", {term: inputVal}).done(function(data){
				                // Display the returned data in browser
				                resultDropdown.html(data);
				            });
				        } else{
				            resultDropdown.empty();
				        }
				    });
				    
				    // Set search input value on click of result item
				    $(document).on("click", ".result-coll p", function(){
				        $(this).parents(".collection-search").find('input[type="text"]').val($(this).text());
				        $(this).parent(".result-coll").empty();
				    });
				});

				$(document).ready(function() {

					// $(".collection-search__form").on("submit", function(e) {
					// 	e.preventDefault();
					// 	$.when($.ajax({    //create an ajax request to display.php
					// 		type: "GET",
					// 		url: "pointquery3.php",             
					// 		dataType: "json",   //expect html to be returned                
					// 		success: function(response){           
					// 			points = response;  
					// 		}

					// 	})).done(function(){

					// 	})

					// })
				})
		</script>

			<div class="inner">
					<header class="align-center">
						<h1>Let's play? </h1>
						<h3> Display just your own collections <br> or all your added points ever. <br><br> And feel free to compare your journeys with someone else!  </h3>
						
					</header>
					
				<section id="main" class="wrapper">

					<div class="user-search">
					  <input type="text" autocomplete="off" placeholder="Search user..." />
						<div class="result"></div> 
						<div class="user-collection__result">
							<h3 class="selected-user"></h3>
						<table class="collection-search-list">
								<!-- <thead>
										<tr>
												<td>Name</td>
												<td>Add to map</td>
										</tr>
								</thead>
								<tbody class="collection-search-tbody">

								</tbody> -->
							</table>
						</div>
					</div>
				</section>

<!-- 
						<form class="collection-search__form" name="form" method="GET" >
							<div class="form">
								<div class="collection-search">
					        <input type="text" placeholder="Seach for collection..." />
				        	<div class="result-coll"> </div>
				        	<button type="submit" class="submit"> Submit </button>
								</div>
							</div>
						</form> -->

					<div class="collection-list">
					<?php


										
					include("db-config.php");

					$conn = new mysqli($servername, $username, $password, $dbname);

					$myquery = "
					SELECT * FROM collections WHERE `userID` = '".$_SESSION['id']."' ORDER BY id
					";
					$query = mysqli_query($conn,$myquery);

					if ( ! $query ) {
							echo mysql_error();
							die;
					}

					$collections = array();


					while($row = mysqli_fetch_assoc($query)){
							$collections[] = $row;
					}
					?>


					<h2>Collections</h2>
					<h4>Choose up to 3 collections you want to display.</h4>
					<table class="collection-list">
						<thead>
								<tr>
										<td>Name</td>
										<td>Add to map</td>
										<td>Delete</td>
								</tr>
						</thead>
						<tbody class="collection-tbody">
								<?php foreach ($collections as $collection): ?>
								<tr data-id="<?=$collection['id']?>">
										<td><?=$collection['collNAME']?></td>
										<td><input data-id="<?=$collection['id']?>" class="display-collection" type="checkbox" value="Yes" style="opacity:1; -webkit-appearance: checkbox; appearance: checkbox;"> </td>	
										<td>
											<button class="delete-collection" data-id="<?=$collection['id']?>">Delete</button>
										</td>
								</tr>
								<?php endforeach; ?>
						</tbody>
					</table>
				</div>

						<div class ="filter-buttons" align="center">
							<button class="display-selected"> Display selected collections </button>
							<button id="display-all"> Display all your points </button>
						</div>
					
			        	<h3 align="center"> <br> Ready?</h3>

			        	<div class="play-buttons" align="center">

							<button id="tour"> Take a tour </button>
							<button id="draw"> Draw a line </button>
							<button id="move-next"><&lt;Move back  </button>
							<button id="move-back">  Move next&gt;></button>

						</div>

</div>
			<div class="timeline-wrapper">
				<div id="map" class="map"></div>
				<div class="timeline">

					<table class="location-table">
						<thead class="timeline-head">
							<tr>
								<td colspan="3"> Timeline </td>
							</tr>
						</thead>
						<tbody class="location-wrapper">
							<tr class="month">
								<td colspan="3"> No points to display </td>
							</tr>
							
						</tbody>
					</table>

				</div>
			</div>

			<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.2.1/build/ol.js"></script>


		    <script>


				
				$(document).ready(function() {

					var polePrvku = [];
					var pointDates = [];
					var pointNames = [];
					var flyToIndex = -1;
					var parcoll_A = [];
					var parcoll_B = [];
					var lineLayers = [];

					var view = new ol.View({
						center: ol.proj.fromLonLat([17.50, 49.25]),
						zoom: 4
						});
					
					var map = new ol.Map({
						target: 'map',
						layers: [
						new ol.layer.Tile({
							source: new ol.source.OSM()
						})
						],
						view: view
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


					var markersArray = [];
					// Pole jmen míst mi bude držet inofrmace o nazvech míst
					var place_names = [];

					// Pole, které drží řádky formuláře
					var timlineLines = [];
					markers.getSource().clear();
					markers.getSource().addFeatures(markersArray);
				
					$("#display-all").on("click", function(e) {
						e.preventDefault();
						$.when($.ajax({    //create an ajax request to display.php
							type: "GET",
							url: "pointquery2.php",             
							dataType: "json",   //expect json to be returned                
							success: function(response){            
								points = response;  
							}

						})).done(function(){

							if (points.length == 0) {
								
							} else {

								$.each(lineLayers, function(i, layer) {
									layer.getSource().clear();
								})
								
								rerenderMap(points);

							}
						});
					});


				function rerenderMap(points, novy_parcoll_A = '') {
					polePrvku = [];
					markersArray = [];
					place_names = [];
					timlineLines = [];
					collection_points = [];
					parcoll_B = [];

					if(novy_parcoll_A !== '') {
						$.each(novy_parcoll_A, function(index,points) {
							var temp = [];

							$.each(points,function(index, item) {

								var coordinate = [item["lon"], item["lat"]];
								
								temp.unshift(coordinate);

							})

							parcoll_B.push(temp)
						})
					}

					$.each(points,function(index, item) {

						var coordinate = [item["lat"], item["lon"]];
						var datum = [item["datum"]];
						var name = [item["name"]]


						polePrvku.unshift(coordinate);

						var newMarker = new ol.Feature({
							geometry: new ol.geom.Point(coordinate.reverse()).transform('EPSG:4326', projection),
							name: place_names.length
						});

						var markerStyle = new ol.style.Style({
							image: new ol.style.Icon({
							anchor: [0.5, 1],
							src: 'images/marker.png'
							})
						})
						if(name[0] == undefined || datum[0] == undefined) {

							place_names.unshift({"name": "Výlet to byl pěkný"+place_names.length, "date":new Date().toJSON().split('T')[0]});
						} else {
							place_names.unshift({"name": name[0], "date":datum[0]});
						}


						newMarker.setStyle(markerStyle);

						markersArray.unshift(newMarker);

						markers.getSource().clear();
						markers.getSource().addFeatures(markersArray);

						updateForm(place_names);

						
					});

				// Bounding box spatial extent

					boundingBox();
				}


					// Collection search form
					$(".collection-search__form").on("submit", function(e) {
						e.preventDefault();
						$.when($.ajax({    //create an ajax request to display.php
							type: "GET",
							url: "pointquery3.php",             
							dataType: "json",   //expect html to be returned                
							success: function(response){           
								points = response;  
							}

						})).done(function(){
								if (points.length == 0) {
								
							} else {
							
								rerenderMap(points);

							}
						})

					})

					function boundingBox() {
						// Bounding box spatial extent
						var ext = ol.extent.boundingExtent(polePrvku);
						ext = ol.proj.transformExtent(ext, ol.proj.get('EPSG:4326'), ol.proj.get('EPSG:3857'));
						map.getView().fit(ext,map.getSize());
						map.getView().setZoom(map.getView().getZoom() - 1);

					}


					// Fuknce, upraví timeline pro daný počet markerů
					function updateForm(lines) {

						// Uložíme si instanci těla tabulky, kde je formulář
						var tbody = $(".location-wrapper");

						// Pomocná proměnná kde budeme formovat obsah timeline
						var timeline = "";

						var month = 3000;
						var year = 13;

						const monthNames = ["January", "February", "March", "April", "May", "June",
						"July", "August", "September", "October", "November", "December"
						];


						$.each(lines, function(key, val) {

							var d = new Date(val["date"]);
							var line_year = d.getFullYear();
							var line_month = d.getMonth() + 1; // Since getMonth() returns month from 0-11 not 1-12.

							if(line_year< year || line_month < month) {
								timeline += '<tr class="month">';
										timeline += '<td colspan="3">'+monthNames[line_month-1]+' '+line_year+'</td>';
								timeline += "</tr>";

								month = line_month;
								year = line_year
							}

							timeline += '<tr data-id="'+key+'" class="point">';

							// visit date
							timeline += '<td>'+val["date"]+'</td>';

							// place name
							timeline += '<td>'+val["name"]+'</td>';
							// Show button
							timeline += '<td><button style="padding: 0px 5px;" class="show-btn" data-id="'+key+'">Show</button></td>';
						
							// konec řádku tabulky
							timeline += "</tr>";

						})
					
						// Pomocí této funkce vložíme vytvořený formulář do těla tabulky/formuláře
						tbody.html(timeline);

					}

					$("html").on("click", ".show-btn", function(e) {
						e.preventDefault();

						// Sežeň id řádeku údaje, který chceme smazat.
						// Při vytváření formuláře jsme přidali data-id attribute každému cancel tlačítku
						// Tohle id odpovídá id řádku v poli formLines a tak můžeme snadno tento údaj vymazat
						var id = getIdOfLine($(this));
						flyTo(ol.proj.fromLonLat(polePrvku[id]), function(){})

					})

					// Při najetí na řádek ve formuláři se zvýrazní daný bod v mapě
					$("html").on("mouseenter", "tr.point", function(e) {
						
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
					$("html").on("mouseleave", "tr.point", function(e) {
						
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

					// POPUP
					//var popup = new ol.Overlay({
					//	 position: ol.proj.fromLonLat(polePrvku),
					//	 element: pointNames
					//});
					//map.addOverlay(popup);


					// Select  interaction
					var select = new ol.interaction.Select({
						hitTolerance: 5,
						multi: false,
						condition: ol.events.condition.singleClick
					});
					map.addInteraction(select);

					
					// var linesLayer = new ol.layer.Vector({
					// 	source: new ol.source.Vector({
					// 		features: []
					// 	})
					// });
					// map.addLayer(linesLayer);
					

					$("#draw").on("click", function(){

						// časový rozestup mezi kroky animace
						var delay = 400;
						var routeLines = [];
						$.each(lineLayers, function(i, layer) {
							layer.getSource().clear();
						})

						// po delku počtu prvku udelej animaci
						$.each(parcoll_B, function(index,novy_parcoll_B){

							var linesLayer = new ol.layer.Vector({
								source: new ol.source.Vector({
									features: []
								})
							});
							map.addLayer(linesLayer);
							lineLayers.push(linesLayer)

							drawLine(novy_parcoll_B, linesLayer)


						})
					})

					const drawLine = (line, linesLayer) => {
						var delay = 550;
						var routeLines = [];
						linesLayer.getSource().clear();
						
						for (let i = 0; i < line.length; i++) {

								// Mezi každy krok dej interval 
								setTimeout(function(){

									var lineArray = [];
										
									line.map((val) => {
										lineArray.unshift(val);
									});
									

									var route = new ol.geom.LineString(lineArray.slice(0,i+1)).transform('EPSG:4326', map.getView().getProjection());//transform(lonlat, 'EPSG:4326', map.getView().getProjection())

									var routeCoords = route.getCoordinates();
									var routeLength = routeCoords.length;

									var routeFeature = new ol.Feature({
											type: 'route',
											geometry: route
										});
									var routeStyle = new ol.style.Style({
											stroke: new ol.style.Stroke({
											width: 6,
											color: [123, 145, 199, 0.3+(0.3*(i/line.length))]
											})
										})

									routeFeature.setStyle(routeStyle);

									routeLines.push(routeFeature);

									linesLayer.getSource().clear();
									linesLayer.getSource().addFeatures(routeLines);

								}, delay * i)

								}
					}
						

				//PULSE ANIMATION OVER POINTS

					var bounce = 5;
						var a = (2*bounce+1) * Math.PI/2;
						var b = -0.01;
						var c = -Math.cos(a) * Math.pow(2, b);
						ol.easing.bounce = function(t) {
						t = 1-Math.cos(t*Math.PI/2);
						return (1 + Math.abs( Math.cos(a*t) ) * Math.pow(2, b*t) + c*t)/2;
						}

					function pulseFeature(polePrvku){
						var f = new ol.Feature (new ol.geom.Point(polePrvku));
						f.setStyle (new ol.style.Style({
							image: new ol.style[$("#form").val()] ({
							radius: 30, 
							points: 4,
							src: "../data/smile.png",
							stroke: new ol.style.Stroke ({ color: $("#color").val(), width:2 })
							})
						}));
						map.animateFeature (f, new ol.featureAnimation.Zoom({
							fade: ol.easing.easeOut, 
							duration: 3000, 
							easing: ol.easing[$("#easing").val()] 
						}));
					}
					
					function pulse(lonlat) {
						var nb = $("#easing").val()=='bounce' ? 1:3;
						for (var i=0; i<nb; i++) {
							setTimeout (function() {
							pulseFeature (ol.proj.transform(lonlat, 'EPSG:4326', map.getView().getProjection()));
							}, i*500);
						};
					}


					let selectedCollections = [];
					// Smazani kolekce

					$("html").on("click", ".delete-collection", function(e) {
						e.preventDefault();
						const id = $(this).data("id");

						$.when($.ajax({    //create an ajax request to display.php
							type: "GET",
							url: "deleteCollection.php?id="+id,             
							// dataType: "json",   //expect json to be returned                
							success: function(response){      
								
							}

						})).done(function(){
							getNewCollectionList();
						});

					})

					// Selecting collections, up to 3
					$("html").on("click", ".display-collection", function(e) {
						const id = $(this).data("id");
						const checked = $(this).prop('checked');

						if (checked) {
							if (selectedCollections.length == 3) {
								e.preventDefault();
								e.stopPropagation();
								alert("You already chose 3 collections. That is a limit.")
							} else {
								selectedCollections.push(id);
								
							}
						} else {
							// Remove the id from list
							selectedCollections = selectedCollections.filter(c => c !== id)
						}
		
					})


					// Display the selected collection
					$(".display-selected").on("click", function(e) {
						e.preventDefault();

						if (selectedCollections.length !== 0) {
							polePrvku = [];
							markersArray = [];
							place_names = [];
							timlineLines = [];
							points = {};
							collection_points = [];
							parcoll_A = [];
							parcoll_B = [];

						
							$.each(selectedCollections, function(key, id) {

								

								$.when($.ajax({    //create an ajax request to display.php
									type: "GET",
									url: "getCollectionById.php?id="+id,             
									dataType: "json",   //expect json to be returned                
									success: function(response){      
									
										// Potřebujeme dictionary rozšířit aby se zobrazily všechny vybrané kolekce   
										points = extendObj(points,response)//{...points, ...response};  
										
										parcoll_A.push(response)

									}

								})).done(function(){

									if (points.length == 0) {
									
									} else {
										
										rerenderMap(points,parcoll_A);


									}
								});


							})

						} else {
							alert("You have not chosen any collection to display on map.")
						}


					})


					function extendObj(obj1, obj2){
						const l = Object.keys(obj1).length
						for (var key in obj2){
								// if(obj2.hasOwnProperty(key)){
										obj1[l+parseInt(key)] = obj2[key];
								// }
						}

						return obj1;
				}

					// Load new collection list
					function getNewCollectionList() {
				
						$.when($.ajax({    //create an ajax request to display.php
							type: "GET",
							url: "getCollections.php",             
							dataType: "json",   //expect json to be returned                
							success: function(response){            
								lines = response;  
							
							}

							})).done(function(){

								var tbody = $(".collection-tbody");

								var collections = "";

								$.each(lines, function(key, val) {

									collections += '<tr data-id="'+val["id"]+'"></tr>';

									collections += '<td>'+val["collNAME"]+'</td>';

									collections += '<td><input data-id="'+val["id"]+'" class="display-collection" type="checkbox" id="display" value="Yes" style="opacity:1; -webkit-appearance: checkbox; appearance: checkbox;"> </td>'

									collections += '<td><button class="delete-collection" data-id="'+val["id"]+'">Delete</button></td>';

									collections += "</tr>";

								})

								// Pomocí této funkce vložíme vytvořený formulář do těla tabulky/formuláře
								tbody.html(collections);
						});

					}



					// var vectorLayer = new ol.layer.Vector({
					// 	source: vectorSource
					// });
					// map.addLayer(vectorLayer);






					
					function onClick(id, callback) {
						document.getElementById(id).addEventListener('click', callback);
					}

					function flyTo(location, done) {
						var duration = 2000;
						var zoom = view.getZoom();
						var parts = 2;
						var called = false;

						view.animate({
							center: location,
							duration: duration
							}, callback);
						view.animate({
							zoom: zoom - 1,
							duration: duration / 2
						}, {
							zoom: zoom,
							duration: duration / 2
						}, callback);
						function callback(complete) {
							--parts;
							if (called) {
								return;
							}
							if (parts === 0 || !complete) {
								called = true;
								done(complete);
							}
						}
					}

					function tour() {

						var locations = [];
							
						polePrvku.map((val) => {
							locations.unshift(val);
						});

						var index = -1;

						function next(more) {
							if (more) {
							++index;
							if (index < locations.length) {
								var delay = index === 0 ? 0 : 750;
								setTimeout(function() {
									flyTo(ol.proj.fromLonLat(locations[index]), next);
								}, delay);
							} else {
								 alert('Tour complete');
							}
							} else {
							alert('Tour cancelled');
							}
						}
						next(true);
					}

					onClick('tour', tour);
						// Forward in the list
					$("#move-next").on('click', function(evt){

						if(flyToIndex == polePrvku.length - 1) {
							flyToIndex = 0;
						} else {
							flyToIndex++;
						}

						flyTo(ol.proj.fromLonLat(polePrvku[flyToIndex]), function(){});
					});

					// Back in the list
					$("#move-back").on('click', function(evt){

						if(flyToIndex == -1 || flyToIndex == 0) {
							flyToIndex = polePrvku.length - 1;
						} else {
							flyToIndex--;
						}

						flyTo(ol.proj.fromLonLat(polePrvku[flyToIndex]), function(){});
					});

					//GEOCODING


					//Instantiate with some options and add the Control
					// var geocoder = new Geocoder('nominatim', {
					//   provider: 'osm',
					//   lang: 'en',
					//   placeholder: 'Search for ...',
					//   limit: 4,
					//   debug: false,
					//   autoComplete: true,
					//   keepOpen: true
					// });
					// map.addControl(geocoder);
					
					// //Listen when an address is chosen
					// geocoder.on('addresschosen', function (evt) {
					// 	console.info(evt);
					//   window.setTimeout(function () {
					//     popup.show(evt.coordinate, evt.address.formatted);
					//   }, 3000);
					// });
			



			})


		    </script>



		<!-- Footer -->
			<footer id="footer">
				<div class="inner">
					<h2>Problem? Let me know.</h2>
					<ul class="actions">
						<li><span class="icon fa-envelope"></span> <a href="mailto:dominik.vit01@upol.cz?subject=Maplay issue">dominik.vit01@upol.cz</a></li>
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
			<!-- <script type="text/javascript" src="index.js"></script> -->
			

	</body>
</html>