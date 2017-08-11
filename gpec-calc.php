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
        private $gpec_controller;

        public function __construct() {
            include_once(dirname(__DIR__).'/gpec-calc/controller/gpec_controller.php');
            include_once(dirname(__DIR__).'/gpec-calc/model/gpec_model.php');
            
            $this->gpec_model=new gpec_model();
            $this->gpec_controller=new gpec_controller($this->gpec_model);

            $this->_hooks_load();
        }

        public function gpec_calc_views() {
            $cities=$this->gpec_model->getCities();
            $streets=$this->gpec_model->getStreets();

            require_once(dirname(__DIR__).'/gpec-calc/templates/form.php');
        }

        private function _hooks_load() {
            $this->gpec_controller->init();

            wp_enqueue_script( 'custom-script', get_option('siteurl').'/wp-content/plugins/gpec-calc/assets/js/gpec.js', array( 'jquery' ) );

            add_shortcode('gpec_calc',array($this,'gpec_calc_views'));
        }
    }
    
    new WP_gpec();
}

?>
