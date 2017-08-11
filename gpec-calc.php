<?php
/**
 * @package GPEC
 * @version 1.0
 */
/*
Plugin Name: GPEC Calculator
Description: Dedicated plugin for GPEC Oxmedia. Just use shortcode [gpec_calc]
Author: Gabriel Domanowski
Version: 1.0
Author URI: http://fireart.pl/
*/

if ( !class_exists( 'WP_gpec' ) ) {

    class WP_gpec {
        private $gpec_model;

        public function __construct() {
            include_once(dirname(__DIR__).'/gpec-calc/controller/gpec_controller.php');
            include_once(dirname(__DIR__).'/gpec-calc/model/gpec_model.php');
            
            $this->_hooks_load();
        }

        public function gpec_calc_views() {
            ob_start();
            require_once(dirname(__DIR__).'/gpec-calc/templates/form.html');
            $view=ob_get_clean();
            
            return $view;
        }

        private function _hooks_load() {
            add_shortcode('gpec_calc',array($this,'gpec_calc_views'));
        }
    }
    
    new WP_gpec();
}

?>
