<?php


namespace App\Http\Traits;


use App\Admin;
use App\Helper\GoogleMaps;

trait Location
{
    /**
     * @param int $zoom
     * @param float $lat
     * @param float $long
     * @param bool $draggable
     * @return mixed
     */
    public function createMap($zoom = 6, $lat = 27.511411, $long = 41.720825, $draggable = true)
    {
        //Prepare the Map for the view
        $theMap = new GoogleMaps();
        $config = array();
        $config['zoom'] = $zoom;
        $config['center'] = "{$lat}, {$long}";//'auto';
        $config['onboundschanged'] = '  if (!centreGot) {
                                            var mapCentre = map.getCenter();
                                            marker_0.setOptions({
                                                position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng()) 
                                            });
                                            $("#latitude").val(mapCentre.lat());
                                            $("#longitude").val(mapCentre.lng());
                                           
                                        }
                                        centreGot = true;';
        $config['geocodeCaching'] = TRUE;
        $marker = array();
        $marker['draggable'] = $draggable;
        $marker['ondragend'] = '$("#latitude").val(event.latLng.lat());$("#longitude").val(event.latLng.lng())';
        $marker['title'] = 'أنت هنا .. من فضلك قم بسحب العلامة ووضعها على المكان الصحيح';
        $theMap->initialize($config);
        $theMap->add_marker($marker);
        $data['maps'] = $theMap->create_map();
        return $data;
    }

    /**
     * @param $longitude
     * @param $latitude
     * @return string
     */
    public function get_address_from_lat_long($longitude,$latitude){
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyC4l5QxL27z4w0uuD_5X3g0IRhaUdvb0Q4';
        $json = @file_get_contents($url);
        $data = json_decode($json);
        //  $data=json_encode($data);
        $status = $data->status;
        $location='';
        //if request status is successful
        if($status == "OK"){
            //get address from json data
            $location = $data->results[0]->formatted_address;


        }else{
            $location =  '';
        }
        return $location;
    }//end fun

}//end trait