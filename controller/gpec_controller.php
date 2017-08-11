<?php
if ( !class_exists( 'gpec_controller' ) ) {
    class gpec_controller {
        private $gpec_model;

        public function __construct($_model) {
            $this->gpec_model=$model;
        }
        public function init() {
            add_action( 'rest_api_init', function () {
                register_rest_route( 'gpec/v1', '/street/(?P<city_name>\w+)/', array(
                    'methods' => 'GET',
                    'callback' => array($this,'getStreets'),
                ) );
            } );
        }
        public function getStreets($data) {
            $streets=$this->gpec_model->getStreetsByCity($data['city_name']);
            $arr=array();
            foreach($streets as $street)
                array_push($arr, $street->{'street'});
            return json_encode($arr);
        }
    }
}
?>