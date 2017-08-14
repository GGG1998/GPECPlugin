<?php
if ( !class_exists( 'gpec_cost_model' ) ) {
    class gpec_cost_model {
        private $db;
        private $id;
        private $rule_fk;
        private $sum_brutto_year;
        private $sum_vat_year;
        private $sum_netto_year;
        private $sum_brutto_gj;
        private $sum_vat_gj;
        private $sum_netto_gj;

        public function __construct() {
            global $wpdb;
            $wpdb->show_errors();
            $this->db=$wpdb;
            $query="
                CREATE TABLE IF NOT EXISTS gpec_cost (
                    cost_id INT NOT NULL AUTO_INCREMENT, 
                    rule_fk INT NOT NULL,
                    sum_brutto_year DOUBLE,
                    sum_vat_year DOUBLE,
                    sum_netto_year DOUBLE,
                    sum_brutto_gj DOUBLE,
                    sum_vat_gj DOUBLE,
                    sum_netto_gj DOUBLE,
                    PRIMARY KEY(cost_id),
                    FOREIGN KEY(rule_fk) REFERENCES gpec_rule(rule_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
            ";
            $this->db->query($query);
        }

        public function getPrice($rule_id) {
            $query='SELECT * FROM gpec_cost WHERE rule_fk='.$rule_id.'';
            $result=$this->db->get_results($query, OBJECT);
            return empty($result) ? NULL : $result;
        }

        public function setValue($val) {
            $group_client=$val;
            $query="SELECT rule_id FROM gpec_rule WHERE value='".$group_client."';";
            $result=$this->db->get_results($query,OBJECT);
           
            $this->rule_fk=$result[0]->{'rule_id'};
        }
        public function setSumBruttoYear($val) { $this->sum_brutto_year=$val; }
        public function setSumVatYear($val) { $this->sum_vat_year=$val; }
        public function setSumNettoYear($val) { $this->sum_netto_year=$val; }
        public function setBruttoGj($val) { $this->sum_brutto_gj=$val; }
        public function setVatGj($val) { $this->sum_vat_gj=$val; }
        public function setNettoGj($val) { $this->sum_netto_gj=$val; }
        public function save() {  
            global $wpdb;
            $wpdb->show_errors(); 
            $this->db->insert(
                'gpec_cost',
                array(
                    "rule_fk"=>$this->rule_fk,
                    "sum_brutto_year"=>$this->sum_brutto_year,
                    "sum_vat_year"=>$this->sum_vat_year,
                    "sum_netto_year"=>$this->sum_netto_year,
                    "sum_brutto_gj"=>$this->sum_brutto_gj,
                    "sum_vat_gj"=>$this->sum_vat_gj,
                    "sum_netto_gj"=>$this->sum_netto_gj
                )
            );
        }
    }
}
?>