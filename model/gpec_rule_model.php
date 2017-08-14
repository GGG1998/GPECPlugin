<?php
if ( !class_exists( 'gpec_rule_model' ) ) {
    class gpec_rule_model {
        private $db;
        private $id;
        private $client_fk;
        private $value;

        public function __construct() {
            global $wpdb;
            $this->db=$wpdb;

            $query="
                CREATE TABLE IF NOT EXISTS gpec_rule (
                    rule_id  INT NOT NULL AUTO_INCREMENT, 
                    client_fk INT NOT NULL,
                    value VARCHAR(255),
                    PRIMARY KEY(rule_id),
                    FOREIGN KEY(client_fk) REFERENCES gpec_client(client_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
            ";
            $this->db->query($query);
        }

        public function getRulesByClientId($client_id) {
            $query='SELECT * FROM gpec_rule WHERE client_fk='.$client_id.'';
            return $this->db->get_results($query, OBJECT);
        }

        public function setValue($val) { $this->value=$val; }

        public function setClientFkByGroupCode($val) {
            $group_client=$val;
            $query="SELECT client_id FROM gpec_client WHERE group_client='".$group_client."';";
            $result=$this->db->get_results($query,OBJECT);
            $this->client_fk=$result[0]->{'client_id'};
            
        }

        public function save() {
            global $wpdb;
            $wpdb->show_errors(); 
            $this->db->insert(
                'gpec_rule',
                array(
                    'value'=>$this->value,
                    "client_fk"=>$this->client_fk,
                )
            );

        }
    }
}
?>