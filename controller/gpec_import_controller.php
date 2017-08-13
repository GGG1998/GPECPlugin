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
                'Import bazy danych',
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

            }else {
                $error=$this->error;
                require_once(dirname(__DIR__).'/templates/error.php');
                $this->_clear_error();
            }

        }

        private function _check_format($format) {
            return $format=="csv" ? true : false;
        }

        private function _push_error($err) { array_push($this->error,$err); }
        private function _clear_error() { $this->error=array(); }

        private function _validateField($file,$key,$name) {
            if(isset($file[$key])) {
                if(empty($file[$key]['name']))
                    $this->_push_error("Nie wybrałeś pliku dla ".$name);
                if($this->_check_format($file[$key]['type'])==false)
                    $this->_push_error("Nieprawidłowy format pliku");
            }else
                $this->_push_error("Nie wybrałeś pliku dla ".$name);
        }
    }
}
?>