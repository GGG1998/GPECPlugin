<?php
if ( !class_exists( 'gpec_controller' ) ) {
    class gpec_controller {
        private $manager;

        public function __construct($_model) {
            $this->manager=$_model;
        }
        public function init() {
            add_action( 'rest_api_init', function () {
                register_rest_route( 'gpec/v1', '/street/(?P<city_name>\w+)/', array(
                    'methods' => 'GET',
                    'callback' => array($this,'getStreets'),
                ) );
                // register_rest_route( 'gpec/v1', '/price/(?P<city_name>\w+)/', array(
                //     'methods' => 'GET',
                //     'callback' => array($this,'getStreets'),
                // ) );
            } );
        }
        public function getStreets($data) {
            $streets=$this->manager->client->getStreetsByCity($data['city_name']);
            $arr=array();
            foreach($streets as $street)
                array_push($arr, $street->{'street'});
            return json_encode($arr);
        }
        public function save() {
            $result=array("result"=>"empty","data"=>array());
            if( isset($_POST['city']) ||
                isset($_POST['street']) ||
                isset($_POST['number']) ||
                isset($_POST['number_local'])) {

                $client=$this->manager->client->getClient($_POST['city'], $_POST['street'], $_POST['number'], $_POST['number_local']);
                $client_id=$client[0]->{'id'};
                $rule=$this->manager->rule->getRulesByClientId($client_id);
                $rule_id=$rule[0]->{'id'};
                $price=$this->manager->cost->getPrice($rule_id); 
                $result["result"]=$price == NULL ? "error" : "OK";
                array_push( $result['data'], array(
                    "group"=>$client[0]->{'group_clients'},
                    "cost_brutto_year"=>$price[0]->{'sum_brutto_year'},
                    "cost_vat_year"=>$price[0]->{'sum_brutto_year'},
                    "cost_neto_year"=>$price[0]->{'sum_brutto_year'},
                ));
                return $result;
            }
            else
                return $result['result'];
        }
    }
}
?>