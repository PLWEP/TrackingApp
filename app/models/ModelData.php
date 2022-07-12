<?php

class ModelData {
    private $APIURL = API_URL;
    private $db;
    private $trackingNumber;
    private $cookieName = "Track";
    private $cookieNameData = "TrackData";

    public function __construct() {
        $this->db = new Database();
    }

    public function view() {
        if(isset($_COOKIE[$this->cookieNameData])) {
            $datenow = date("Y/m/d");
            $Cookie = json_decode($_COOKIE[$this->cookieNameData],true);
            if($Cookie['tgl'] == $datenow) {
                return $Cookie['data'];
            } else {
                $this->getAll();
                return $Cookie['data'];;
            }
        }
    }

    public function getAll() {
        $listdata = [];
        if (isset($_COOKIE[$this->cookieName])) {
            foreach (json_decode($_COOKIE[$this->cookieName]) as $data) {
                $url = $this->APIURL."trackingNumber=".$data;
                $result = json_decode($this->db->callAPI('GET', $url, false), true);
                foreach ($result as $data) {
                    $listdata['id'] = $data[0]['id'];
                    $listdata['service'] = $data[0]['service'];
                    $listdata['status'] = $data[0]['status']['statusCode'];
                    $listdata['timestamp'] = $data[0]['status']['timestamp'];
                    $listdata['address'] = $data[0]['status']['location']['address']['addressLocality'];
                    $listdata['description'] = $data[0]['status']['description'];
                    $this->db->addCookieData($listdata);
                }
            }
        }
    }

    public function getOne($data) {
        $listdata = [];
        $url = $this->APIURL."trackingNumber=".$data;
        $result = json_decode($this->db->callAPI('GET', $url, false), true);
        try {
            foreach ($result as $data) {
                $listdata['id'] = $data[0]['id'];
                $listdata['service'] = $data[0]['service'];
                $listdata['status'] = $data[0]['status']['statusCode'];
                $listdata['timestamp'] = $data[0]['status']['timestamp'];
                $listdata['address'] = $data[0]['status']['location']['address']['addressLocality'];
                $listdata['description'] = $data[0]['status']['description'];
                $this->db->addCookieData($listdata);
            }
            return true;
        } catch (Error) {
            return false;
        }
    }

    public function addData($data) {
        $this->trackingNumber = $data['iresi'];
        $name = $data['name'];
        $listdata = [];
        $url = $this->APIURL."trackingNumber=".$this->trackingNumber;
        $result = json_decode($this->db->callAPI('GET', $url, false), true);
        if(isset($result['title'])) {
            return $result['title'];
        } else {
            foreach ($result['shipments'] as $data) {
                $listdata['trackingNumber'] = $data['id'];
                $listdata['name'] = $name;
                $listdata['service'] = $data['service'];
                $listdata['status'] = $data['status']['statusCode'];
                $listdata['timestamp'] = $data['status']['timestamp'];
                $listdata['address'] = $data['status']['location']['address']['addressLocality'];
                $listdata['description'] = $data['status']['description'];
                $this->db->addCookieData($listdata);
            }
            $this->db->addCookie($this->trackingNumber);
            return "berhasil";
        }
    }

    public function deleteData($data) {
        $this->db->deleteCookie($data);
    }
}

?>