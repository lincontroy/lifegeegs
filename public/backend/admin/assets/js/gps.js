(function () {
    'use strict';

    
    /*--------------------------------------	
      		Geo Location Active
    	---------------------------------------*/
    window.getLocation = function getLocation(status) {
        var gpsStatus = status == 0 ? false : true;
        if (gpsStatus == false) {
            return;
        }
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(position);
        } else {
            console.log("Geolocation is not supported by this browser.")
        }
    }
    
    getLocation($('#gps').val());
      function position(latlong) {
          var lat = latlong.coords.latitude;
          var long = latlong.coords.longitude;
          gpsStore(lat, long);
    }
    
    /*------------------------------	
      		Geo Location Store 
    	-------------------------------*/
    function gpsStore(lat, long) {
        var project_id = $('#project_id').val();
        var task_id = $('#task_id').val() ?? 0;
        var gpsStoreRoute = $('#gps_store').val();
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            type: 'POST',
            data: {
                latitude: lat,
                longitude: long,
                project_id: project_id,
                task_id: task_id,
            },
            url: gpsStoreRoute,
            dataType: 'json',
            success: function (response) {
                
            }
        })
    }

})();


