<?php

class ModelData {
    private $db;
    private $api;

    public function __construct() {
        $this->db = new Database();
        $this->api = new Api();
    }

    public function addTracker($data) {
        $trackingNumber = $data['tracking_number'];
        $carrier_code = $data['carrier'];
        $title = $data['name'];

        $body = array(
            "tracking_number" => $trackingNumber,
	        "carrier_code" => $carrier_code,
            "title" => $title
        );
        $url = API_URL.'post';
        $result = json_decode($this->api->callAPI('POST', $url, json_encode($body)), true);

        if ($result['meta']['type'] == "Success"){
            $this->db->query('SELECT if(max(id)is null,1,max(id)+1) as maks_id  FROM trackdata');
                $data=$this->db->resultSet();
                foreach ($data as $rec){
                    $id=$rec["maks_id"];
            }
    
            $this->db->query('INSERT INTO trackdata (id,trackingNumber,carrierCode,title) 
                values (:id,:tn,:cc,:title)');
            $this->db->bind('id',$id);
            $this->db->bind('tn',$trackingNumber);
            $this->db->bind('cc',$carrier_code);
            $this->db->bind('title',$title);
            $this->db->execute(); 

            return $result['meta']['type'];
        } else {
            return $result['meta']['type'];
        }
    }

    public function deleteTracker($id) {
        $tracker = $this->getById($id);
        $trackingNumber = $tracker['trackingNumber'];
        $carrier_code = $tracker['carrierCode'];

        $url = API_URL.$carrier_code.'/'.$trackingNumber;
        $result = json_decode($this->api->callAPI('DELETE', $url, false), true);
        if ($result['meta']['type'] == "Success"){
            $sql="delete from trackdata where id='$id'";
            $this->db->query($sql);
            $this->db->execute();
        }

        return $result['meta']['type'];
    }

    public function getTracker() {
        $listdata = [];
        $this->db->query('SELECT * FROM trackdata');
        $listtracker =  $this->db->resultSet();
        for($i=0;$i<count($listtracker);$i++) {
            $tracker['id'] = $listtracker[$i]['id'];
            $tracker['trackingNumber'] = $listtracker[$i]['trackingNumber'];
            $tracker['carrier_code'] = $listtracker[$i]['carrierCode'];
            $tracker['title'] = $listtracker[$i]['title'];
            $url = API_URL.$tracker['carrier_code'].'/'.$tracker['trackingNumber'];
            $result = json_decode($this->api->callAPI('GET', $url, false), true);
            $tracker['status'] = $result['data'][0]['status'];
            $tracker['lastupdate'] = $result['data'][0]['lastUpdateTime'];
            $tracker['lastevent'] = $result['data'][0]['lastEvent'];
            array_push($listdata, $tracker);
        }

        return $listdata;
    }

    public function getById($id) {
        $sql="SELECT * FROM trackdata WHERE id=:id";
        $this->db->query($sql);
        $this->db->bind('id',$id);
        return $this->db->singleResultSet();
    }
}

?>