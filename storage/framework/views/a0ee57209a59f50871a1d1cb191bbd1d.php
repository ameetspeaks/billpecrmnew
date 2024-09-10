<?php $__env->startComponent('admin.component'); ?>
<?php $__env->slot('title'); ?> Edit Zone <?php $__env->endSlot(); ?>

<?php $__env->slot('subTitle'); ?> edit Zone detail <?php $__env->endSlot(); ?>
<?php $__env->slot('content'); ?>
<form class="row forms-sample w-full" action="<?php echo e(route('admin.zone.update')); ?>" name="moduleData" method="POST">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="zone_id" value="<?php echo e($zone->id); ?>">
    <div class="form-group col-6 err_name">
        <label>Zone Name</label>
        <input type="text" name="name" class="form-control" placeholder="Zone Name" value="<?php echo e($zone->name); ?>">
        <span class="text-xs text-red-500 mt-2 errmsg_name"></span>
    </div>

    <input type="hidden" name="mapDetails" class="mapDetails">
    <div class="col-12 form-group err_mapDetails">
        <div class="map-warper rounded mt-0">
            <input id="pac-input" class="controls rounded h-10 w-52" title="Search your location here" type="text" placeholder="Search here"/>
            <div id="map-canvas" name="map_detail" class="rounded"></div>
        </div>
        <span class="text-xs text-red-500 mt-2 errmsg_mapDetails"></span>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary mr-2 bg-red-600 hover:bg-red-700" id="submitData">Submit</button>
        <a href="<?php echo e(route('admin.zone.index')); ?>"><div class="btn btn-light">Cancel</div></a>
    </div>
</form>
<?php $__env->endSlot(); ?>
<?php $__env->slot('script'); ?>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(\App\Models\Setting::where('type','map_api_key')->first()->value); ?>&callback=initialize&libraries=drawing,places&v=3.49"></script>


<script>

    var map; // Global declaration of the map
    var drawingManager;
    var lastpolygon = null;
    var polygons = [];

    function resetMap(controlDiv) {
        // Set CSS for the control border.
        const controlUI = document.createElement("div");
        controlUI.style.backgroundColor = "#fff";
        controlUI.style.border = "2px solid #fff";
        controlUI.style.borderRadius = "3px";
        controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
        controlUI.style.cursor = "pointer";
        controlUI.style.marginTop = "8px";
        controlUI.style.marginBottom = "22px";
        controlUI.style.textAlign = "center";
        controlUI.title = "Reset map";
        controlDiv.appendChild(controlUI);
        // Set CSS for the control interior.
        const controlText = document.createElement("div");
        controlText.style.color = "rgb(25,25,25)";
        controlText.style.fontFamily = "Roboto,Arial,sans-serif";
        controlText.style.fontSize = "10px";
        controlText.style.lineHeight = "16px";
        controlText.style.paddingLeft = "2px";
        controlText.style.paddingRight = "2px";
        controlText.innerHTML = "X";
        controlUI.appendChild(controlText);
        // Setup the click event listeners: simply set the map to Chicago.
        controlUI.addEventListener("click", () => {
            lastpolygon.setMap(null);
            $('#coordinates').val('');
        });
    }

    function initialize() {
        var myLatlng = { lat: 25.7464145, lng: 82.68370329999999 };
        var myOptions = {
            zoom: 13,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        }

        map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: true,
            drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [google.maps.drawing.OverlayType.POLYGON]
            },
            polygonOptions: {
            editable: true
            }
        });
        drawingManager.setMap(map);

        //get current location block
        // infoWindow = new google.maps.InfoWindow();
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                map.setCenter(pos);
            });
        }

        drawingManager.addListener("overlaycomplete", function(event) {
            if(lastpolygon)
            {
                lastpolygon.setMap(null);
            }
            $('#coordinates').val(event.overlay.getPath().getArray());
            lastpolygon = event.overlay;
            var latandlong = event.overlay.getPath().getArray()
            var lonandlongArray = [];
            latandlong.forEach(element => {
                var arr = {
                    'lat' : element.lat(),
                    'lng' : element.lng(),
                };
                lonandlongArray.push(arr);
            });
            console.log(JSON.stringify(lonandlongArray));

            $('.mapDetails').val(JSON.stringify(lonandlongArray));
            // auto_grow();
        });

        const resetDiv = document.createElement("div");
        resetMap(resetDiv, lastpolygon);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(resetDiv);

        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });
        let markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
            return;
            }
            // Clear out the old markers.
            markers.forEach((marker) => {
            marker.setMap(null);
            });
            markers = [];
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
                console.log("Returned place contains no geometry");
                return;
            }
            const icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25),
            };
            // Create a marker for each place.
            markers.push(
                new google.maps.Marker({
                map,
                icon,
                title: place.name,
                position: place.geometry.location,
                })
            );

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
            });
            map.fitBounds(bounds);
        });
    }
</script>

<?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php /**PATH /home4/billp5kj/public_html/resources/views/admin/zone/edit.blade.php ENDPATH**/ ?>