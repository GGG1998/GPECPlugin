<?php
if ( !class_exists( 'gpec_manager_model' ) ) {
    class gpec_manager_model {
        private $db;
        public $client;
        public $rule;
        public $cost;

        public function __construct($_client,$_rule,$_cost) {
            $this->client=$_client;
            $this->rule=$_rule;
            $this->cost=$_cost;
        }
    }
}
?>