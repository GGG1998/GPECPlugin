<?php
/**
 * @package GPEC
 * @version 2.0
 */
/*
Plugin Name: GPEC Calculator
Description: Dedicated plugin for GPEC Oxmedia. Just use shortcode [gpec_calc]
Author: Gabriel Domanowski
Version: 2.0
Author URI: http://fireart.pl/
*/

define("WP_UNINSTALL_PLUGIN",TRUE);

if ( !class_exists( 'WP_gpec' ) ) {

    class WP_gpec {
        private $gpec_manager_model;
        private $gpec_client_model;
        private $gpec_rule_model;
        private $gpec_cost_model;
        private $gpec_controller;
        private $gpec_import_controller;

        public function __construct() {
            include_once(dirname(__DIR__).'/gpec-calc/controller/gpec_controller.php');
            include_once(dirname(__DIR__).'/gpec-calc/controller/gpec_import_controller.php');
            include_once(dirname(__DIR__).'/gpec-calc/model/gpec_client_model.php');
            include_once(dirname(__DIR__).'/gpec-calc/model/gpec_rule_model.php');
            include_once(dirname(__DIR__).'/gpec-calc/model/gpec_cost_model.php');
            include_once(dirname(__DIR__).'/gpec-calc/model/gpec_manager_model.php');
            
            $this->gpec_client_model=new gpec_client_model();
            $this->gpec_rule_model=new gpec_rule_model();
            $this->gpec_cost_model=new gpec_cost_model();
            $this->gpec_manager_model=new gpec_manager_model(
                $this->gpec_client_model,
                $this->gpec_rule_model,
                $this->gpec_manager_model
            );

            $this->gpec_controller=new gpec_controller($this->gpec_manager_model);
            $this->gpec_import_controller=new gpec_import_controller($this->gpec_manager_model);

            $this->_hooks_load();
        }

        public function gpec_calc_views() {
            $cities=$this->gpec_manager_model->client->getCities();
            $streets=$this->gpec_manager_model->client->getStreets();

            $result=$this->gpec_controller->save();

            require_once(dirname(__DIR__).'/gpec-calc/templates/form.php');
        }

        private function _hooks_load() {
            //Hooks of controller
            $this->gpec_controller->init();

            if(is_admin())
                $this->gpec_import_controller->init();

            //Enqueue scripts and styles
            wp_enqueue_script( 'custom-script', get_option('siteurl').'/wp-content/plugins/gpec-calc/assets/js/gpec.js', array( 'jquery' ) );
            wp_enqueue_style( 'custom-style', get_option('siteurl').'/wp-content/plugins/gpec-calc/assets/css/style.css');
            
            //Shortcode
            add_shortcode('gpec_calc',array($this,'gpec_calc_views'));


        }
    }
    
    new WP_gpec();
}

?>
