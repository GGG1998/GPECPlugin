<?php
if ( !class_exists( 'gpec_model' ) ) {
    class gpec_model {
        private $db;
        public function __construct() {
            global $wpdb;
            $this->db=$wpdb;
        }

        public function getCities() {
            $query="SELECT DISTINCT city FROM gpec_client";
            return $this->db->get_results($query,OBJECT);
        }

        public function getStreets() {
            $query='SELECT DISTINCT street,city FROM gpec_client';
            return $this->db->get_results($query, OBJECT);
        }

        public function getStreetsByCity($city_name) {
            $query='SELECT DISTINCT street FROM gpec_client WHERE city="'.$city_name.'"';
            return $this->db->get_results($query, OBJECT);
        }
    }
}
?>