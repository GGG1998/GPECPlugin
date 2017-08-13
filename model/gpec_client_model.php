<?php
if ( !class_exists( 'gpec_client_model' ) ) {
    class gpec_client_model {
        private $db;
        private $id;
        private $city;
        private $street;
        private $number_flat;
        private $number_home;
        private $group_client;
        private $company;

        public function __construct() {
            global $wpdb;
            $this->db=$wpdb;

            $query="
                CREATE TABLE IF NOT EXISTS gpec_client (
                    client_id  INT NOT NULL AUTO_INCREMENT, 
                    city VARCHAR(255),
                    street VARCHAR(255),
                    number_flat VARCHAR(5),
                    number_home INT(11),
                    group_client VARCHAR(255),
                    company VARCHAR(255),
                    PRIMARY KEY(client_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
            ";
            $this->db->query($query);
        }

        public function getCities() {
            $query="SELECT DISTINCT city FROM gpec_client";
            return $this->db->get_results($query,OBJECT);
        }

        public function getStreets() {
            $query='SELECT DISTINCT street,city FROM gpec_client';
            return $this->db->get_results($query, OBJECT);
        }

        public function getClient($city,$street,$house,$number) {
            $query='SELECT * FROM gpec_client WHERE city="'.$city.'" AND street="'.$street.'" AND number_flat="'.$house.'" AND number_home="'.$number.'"';
            return $this->db->get_results($query, OBJECT);
        }

        public function getStreetsByCity($city_name) {
            $query='SELECT DISTINCT street FROM gpec_client WHERE city="'.$city_name.'"';
            return $this->db->get_results($query, OBJECT);
        }
    }
}
?>