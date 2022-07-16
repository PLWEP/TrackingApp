<?php

    class Data extends Controller {
        public function index() {	
            $data['title'] = 'Data List';       
            $data['trackingNumberdata'] = $this->model('ModelData')->getTracker();
            $this->view('home/index',$data);  
        }

        public function addData() {
            $response = $this->model('ModelData')->addTracker($_POST);
            if ($response == "Success") {
                header("Location: ".BASEURL);
            } else {
                echo 
                "<script type='text/javascript'>
                if(!alert('Error ".$response."') { 
                    document.location = '".BASEURL."';
                };
                </script>";
            }
        }

        public function deleteData($data) {
            $this->model('ModelData')->deleteTracker($data);
            header("Location: ".BASEURL);
        }
    }
?>