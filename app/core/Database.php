<?php 

class Database {
    private $APIKEY = API_Key;
    private $APISECRET = API_Secret;
    private $CookieName = "Track";
    private $CookieDataName = "TrackData";

    public function callAPI($method, $url, $data){
        $curl = curl_init();
        switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'DHL-API-Key: '.$this->APIKEY,
            'DHL-API-Secret: '.$this->APISECRET,
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        
        return $result;
    }

    public function addCookie($data) {
        $listdata = [];
        if(!isset($_COOKIE[$this->CookieName])) {
            array_push($listdata, $data);
            setcookie($this->CookieName, json_encode($listdata), time() + (10 * 365 * 24 * 60 * 60), '/');
        } else {
            $listdata = json_decode($_COOKIE[$this->CookieName], true);
            array_push($listdata, $data);
            setcookie($this->CookieName, json_encode($listdata), time() + (10 * 365 * 24 * 60 * 60), '/');
        }
    }

    public function addCookieData($data) {
        $listdata['tgl'] = date("Y/m/d");
        $listdata['data'] = [];
        if(!isset($_COOKIE[$this->CookieDataName])) {
            array_push($listdata['data'], $data);
            setcookie($this->CookieDataName, json_encode($listdata), time() + (10 * 365 * 24 * 60 * 60), '/');
        } else {
            $listdata = json_decode($_COOKIE[$this->CookieDataName], true);
            array_push($listdata['data'], $data);
            setcookie($this->CookieDataName, json_encode($listdata), time() + (10 * 365 * 24 * 60 * 60), '/');
        }
    }

    public function deleteCookie($data) {
        $listdata = [];
        if(isset($_COOKIE[$this->CookieName])) {
            $listdata = json_decode($_COOKIE[$this->CookieName], true);
            for($i = 0; $i <= count($listdata); $i++) {
                if($listdata[$i] == $data) {
                    array_splice($listdata, $i, 1);
                }
            }
            setcookie($this->CookieName, json_encode($listdata), time() + (10 * 365 * 24 * 60 * 60), '/');
        }

        if(isset($_COOKIE[$this->CookieDataName])) {
            $listdata = json_decode($_COOKIE[$this->CookieDataName], true);
            for($i = 0; $i < count($listdata['data']); $i++) {
                if($listdata['data'][$i]['trackingNumber'] == $data) {
                    array_splice($listdata['data'], $i, 1);
                }
            }
            setcookie($this->CookieDataName, json_encode($listdata), time() + (10 * 365 * 24 * 60 * 60), '/');
        }
    }
}
?>
