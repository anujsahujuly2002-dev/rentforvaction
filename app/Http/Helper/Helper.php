<?php 

namespace App\Http\Helper;
use App\Models\SubAmenities;
use App\Models\ThirdLevelAmenities;
use GuzzleHttp\Client;
use App\Models\PropertyAmenites;

class Helper {

    public static function  getICSDates($key, $subKey, $subValue, $icsDates) {
        if ($key != 0 && $subKey == 0) {
            $icsDates [$key] ["BEGIN"] = $subValue;
        } else {
            $subValueArr = explode ( ":", $subValue, 2 );
            if (isset ( $subValueArr [1] )) {
                $icsDates [$key] [$subValueArr [0]] = $subValueArr [1];
            }
        }
        return $icsDates;
    }

    public static function checkDescriptionAmenites($id,$type){
        $description = false;
        if($type=='sub_amenities'):
            $subAmenites = SubAmenities::where('id',$id)->first('description');
            if($subAmenites->description=='1'):
                $description = true;
            endif;
        endif;
        if($type=='child_amenities'):
            $childAmenites = ThirdLevelAmenities::where('id',$id)->first('description');
            if($childAmenites->description=='1'):
                $description = true;
            endif;
        endif;
        return $description;
    }

   public static function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    public static function getCoordinates($address) {
        try {
            $params = [
                'address'=>$address,
                'key'=>env('GOOGLE_MAPS_KEY')
            ];
            $url = "https://maps.googleapis.com/maps/api/geocode/json";
            $url = $url . "?". http_build_query($params);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $info = curl_getinfo($ch);
            $res = curl_exec($ch);  
            curl_close($ch);
            $data=json_decode($res,true);
           if ($data['status'] === 'OK' && isset($data['results'][0]['geometry']['location'])) :
                $location = $data['results'][0]['geometry']['location'];
                $latitude = $location['lat'];
                $longitude = $location['lng'];
                return [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ];
            else :
                return [
                    'error' => 'Invalid address or API key.',
                ];
            endif;


        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        
    }


    public static function getSubAmenites($id,$property_id){
        $subAmenites = PropertyAmenites::where(['amenites_id'=>$id,'property_id'=>$property_id])->groupBy('sub_amenites_id')->get();
        return $subAmenites;
    }

    public static function getChildAmenites($id,$property_id){
        $childAmenites = PropertyAmenites::where(['sub_amenites_id'=>$id,'property_id'=>$property_id])->whereNotNull('child_amenites_id')->get('child_amenites_id');
        return $childAmenites;
    }
}