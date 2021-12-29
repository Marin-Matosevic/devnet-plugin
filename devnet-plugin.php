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

namespace Devnet;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}



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
        add_action('init', [$this, 'load_plugin_textdomain']);
        add_action('wp_enqueue_scripts', [$this, 'assets']);
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain('devnet-plugin', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * CSS and JS
     */
    public function assets()
    {
        $slug = dirname(plugin_basename(__FILE__));
        $ajax_slug = str_replace('-', '_', $slug) . '_' . 'ajax';

        wp_enqueue_style($slug . 'style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
        wp_enqueue_script($slug . 'script', plugin_dir_url(__FILE__) . 'assets/js/script.js', ['jquery'], '', '', true);

        wp_localize_script($slug . 'script', $ajax_slug, [
            'ajaxurl' => admin_url('admin-ajax.php'),
        ]);
    }
}

add_action('plugins_loaded', ['Devnet\Devnet_Plugin', 'instance']);