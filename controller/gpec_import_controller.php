<?php
if(!class_exists('gpec_import_controller')) {
    class gpec_import_controller {
        private $manager;
        private $error=array();
        private $option;
        public function __construct($_models) {
            $this->manager=$_models;
        }

        public function init() {
            add_action( 'admin_menu', array( $this, 'add_import_page' ) );
            add_action( 'admin_init', array( $this, 'page_init' ) );
        }

        public function add_import_page() {
            add_options_page(
                'Ustawienia GPEC',
                'Import GPEC',
                'manage_options',
                'import-db-gpec',
                array($this, 'create_import_page')
            );
        }

        public function create_import_page() {
            if(isset($_POST['send'])) {
                $this->save_file($_FILES);
            }
            require_once(dirname(__DIR__).'/templates/import.php');
        }

        public function page_init() {}

        public function save_file($file) {
            $this->_validateField($file,"list_clients","listy klientów");
            $this->_validateField($file,"list_rules","listy reguł spinających");
            $this->_validateField($file,"list_costs","listy ceny taryf");
            if(count($this->error)==0) {
                $this->importClient($file['list_clients']);
                $this->importRules($file['list_rules']);
                $this->importCosts($file['list_costs']);
            }else {
                $error=$this->error;
                require_once(dirname(__DIR__).'/templates/error.php');
                $this->_clear_error();
            }

        }

        public function importClient($file) {
            if(empty($file['name'])) return;
            $required_field=array('city','street','number_flat','number_home','group_client','company');

            $clients=fopen($file['tmp_name'],"r") or die("Nie mogę otworzyć pliku");
            while (($data = fgetcsv($clients, 0, ";")) !== FALSE) {
                $num = count($data);
                $row++;
                if($row==1) {
                    if($this->_checkRequairment($required_field,$data,$num)==false)
                        break;
                }else {
                    $client_model=$this->manager->client;
                    $client_model->setCity($data[0]);
                    $client_model->setStreet($data[1]);
                    $client_model->setNumberFlat($data[2]);
                    $client_model->setNumberHome($data[3]);
                    $client_model->setGroupClient($data[4]);
                    $client_model->setCompany($data[5]);
                    $client_model->save();
                    echo '<p style="color:green;">Dodałem bazę klientów do bazy</p>';
                }
            }
            fclose($clients);
        }

        public function importRules($file) {
            if(empty($file['name'])) return;
            $required_field=array('value','group_client');
            $rule=fopen($file['tmp_name'],"r") or die("Nie mogę otworzyć pliku");
            while (($data = fgetcsv($rule, 0, ";")) !== FALSE) {
                $num = count($data);
                $row++;
                if($row==1) {
                    if($this->_checkRequairment($required_field,$data,$num)==false)
                        break;
                }else {

                    $rule_model=$this->manager->rule;
                    $rule_model->setValue($data[0]);
                    $rule_model->setClientFkByGroupCode($data[1]);
                    $rule_model->save();
                    echo '<p style="color:green;">Dodałem bazę reguł do bazy</p>';
                }
            }
            fclose($rule);
        }

        public function importCosts($file) {
            if(empty($file['name'])) return;
            $required_field=array('value','sum_brutto_year','sum_vat_year','sum_netto_year','sum_brutto_gj','sum_vat_gj','sum_netto_gj');
            $costs=fopen($file['tmp_name'],"r") or die("Nie mogę otworzyć pliku");
            while (($data = fgetcsv($costs, 0, ";")) !== FALSE) {
                $num = count($data);
                $row++;
                if($row==1) {
                    if($this->_checkRequairment($required_field,$data,$num)==false)
                        break;
                }else {
                    $cost_model=$this->manager->cost;
                    $cost_model->setValue($data[0]);
                    $cost_model->setSumBruttoYear($data[1]);
                    $cost_model->setSumVatYear($data[2]);
                    $cost_model->setSumNettoYear($data[3]);
                    $cost_model->setBruttoGj($data[4]);
                    $cost_model->setVatGj($data[5]);
                    $cost_model->setNettoGj($data[6]);
                    $cost_model->save();
                    echo '<p style="color:green;">Dodałem bazę kosztów do bazy</p>';
                }
            }
            fclose($costs);
        }

        private function _check_format($format) {
            $format_list = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
            return in_array($format,$format_list) ? true : false;
        }

        private function _push_error($err) { array_push($this->error,$err); }
        
        private function _clear_error() { $this->error=array(); }

        private function _validateField($file,$key,$name) {
            if(isset($file[$key])) {
                if(!empty($file[$key]['name'])) {
                    if($this->_check_format($file[$key]['type'])==false)
                        $this->_push_error("Nieprawidłowy format pliku");
                }
            }else
                $this->_push_error("Nie wybrałeś pliku dla ".$name);
        }

        private function _checkRequairment($req, $data, $nr) {
            for($i=0; $i<$nr; $i++) {
                if(!empty($data[$i]))
                    if(!in_array($data[$i],$req)) return false; 
            }
            return true;
        }

    }
}
?>