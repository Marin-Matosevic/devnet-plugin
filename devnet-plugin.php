<?php

/**
 * Plugin Name:       Devnet Plugin
 * Plugin URI:
 * Description:       Devnet plugin description.
 * Version:           1.0.0
 * Author:            Devnet
 * Author URI:        https://devnet.hr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       devnet-plugin
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}


if (!class_exists('Devnet_Plugin')) {
    class Devnet_Plugin
    {
        /**
         * Instance handle
         */
        private static $__instance = null;

        /**
         * Constructor, actually contains nothing
         */
        private function __construct()
        {
        }

        /**
         * Instance initiator, runs setup etc.
         */
        public static function instance()
        {
            if (!is_a(self::$__instance, __CLASS__)) {
                self::$__instance = new self;
                self::$__instance->setup();
            }

            return self::$__instance;
        }

        /**
         * Runs things that would normally be in __construct
         */
        private function setup()
        {
            add_action('wp_enqueue_scripts', [$this, 'assets']);
        }

        /**
         * CSS and JS
         */
        public function assets()
        {
            wp_enqueue_style('style-css', plugin_dir_url(__FILE__) . 'assets/css/style.css');
            wp_enqueue_script('script-js', plugin_dir_url(__FILE__) . 'assets/js/script.js', ['jquery'], '', '', true);

            wp_localize_script('script-js', 'ajax', [
                'ajaxurl' => admin_url('admin-ajax.php'),
            ]);
        }
    }

    add_action('plugins_loaded', ['Devnet_Plugin', 'instance']);
}
