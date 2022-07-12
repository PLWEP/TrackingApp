<?php

    class Data extends Controller {
        public function index() {	
            $data['title'] = 'Data List';       
            $data['trackingNumberdata'] = $this->model('ModelData')->view();
            $this->view('home/index',$data);  
        }

        public function addData() {
            $response = $this->model('ModelData')->addData($_POST);
            if ($response == "berhasil") {
                echo 
                "<script type='text/javascript'>
                if(!alert('Adding Tracking Number')) {
                    document.location = '".BASEURL."';
                };
                </script>";
            } else {
                echo 
                "<script type='text/javascript'>
                if(!alert('".$response."')) {
                    document.location = '".BASEURL."';
                };
                </script>";
            }
        }

        public function deleteData($data) {
            echo 
                "<script type='text/javascript'>
                if(confirm('Are you sure you want to delete ".$data."') == true) {
                    "
                    .$this->model('ModelData')->deleteData($data).
                    "
                    document.location = '".BASEURL."';
                } else {
                    document.location = '".BASEURL."';
                }

                </script>";
        }
    }
?>