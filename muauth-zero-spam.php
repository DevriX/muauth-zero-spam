<?php
/*
Plugin Name: Multisite Auth Zero-Spam
Plugin URI: https://samelh.com/
Description: Zero-Spam addon for Multisite Auth plugin
Author: Samuel Elh
Version: 0.1
Author URI: https://samelh.com
*/

// prevent direct access
defined('ABSPATH') || exit('Direct access not allowed.' . PHP_EOL);

class ZeroSpam_Muauth_Init
{
    public function __construct()
    {
        return $this->init();
    }
    public function init()
    {
        add_action('plugins_loaded', array($this, 'loadComponent'));

        return $this;
    }

    public function loadComponent()
    {
        if ( !class_exists('\MUAUTH\MUAUTH') )
            return $this->muauthMissing();

        if ( !class_exists('\ZeroSpam_Plugin') )
            return $this->ZeroSpamMissing();

        $this
            ->loadClass()
            ->initZS()
            ->loadScripts();
    }

    public function notice($message, $success=false)
    {
        global $ZeroSpam_Muauth_Notices;

        if ( !isset($ZeroSpam_Muauth_Notices) ) {
            $ZeroSpam_Muauth_Notices = array();
        }

        $ZeroSpam_Muauth_Notices[] = sprintf(
            '<div class="%s"><p>%s</p></div>',
            $success ? 'updated' : 'error',
            $message
        );
        
        if ( is_multisite() && is_network_admin() ) {
            $tag = 'network_admin_notices';
        } else {
            $tag = 'admin_notices';
        }

        add_action($tag, array($this, 'notices'));

        return $this;
    }

    public function notices()
    {
        global $ZeroSpam_Muauth_Notices;

        if ( isset($ZeroSpam_Muauth_Notices) ) {
            if ( is_array($ZeroSpam_Muauth_Notices) ) {
                print ( implode('<br/>', $ZeroSpam_Muauth_Notices) );
            } else {
                print ( $ZeroSpam_Muauth_Notices );
            }
        }

        return $this;
    }

    public function muauthMissing()
    {
        $this->notice('Multisite Auth Zero-Spam Notice: <a href="https://github.com/elhardoum/multisite-auth">Multisite Auth</a> parent plugin is missing.');

        return $this;
    }

    public function ZeroSpamMissing()
    {
        $this->notice('Multisite Auth Zero-Spam Notice: <a href="https://wordpress.org/plugins/zero-spam/">WordPress Zero Spam</a> plugin is missing.');

        return $this;
    }

    public function loadClass()
    {
        $class_file = plugin_dir_path(__FILE__) . (
            'ZeroSpam_Muauth.php'
        );

        if ( file_exists($class_file) ) {
            include $class_file;
        }

        return $this;
    }

    public function initZS()
    {
        if ( !class_exists('ZeroSpam_Muauth') )
            return $this;

        $ZeroSpam_Plugin = new \ZeroSpam_Plugin();
        $ZeroSpam_Plugin['muauth'] = new \ZeroSpam_Muauth();
        $ZeroSpam_Plugin->run();

        return $this;
    }

    public function loadScripts()
    {
        add_action('wp', array($this, 'loadJS'));

        return $this;
    }

    public function loadJS()
    {
        if ( !function_exists('muauth_get_current_component') )
            return $this;

        if ( 'register' !== muauth_get_current_component() )
            return $this;

        wp_enqueue_script( 'muauth-zero-spam', plugin_dir_url(__FILE__) . (
            'ZeroSpam.js'
        ), array('jquery'));

        return $this;
    }
}

new ZeroSpam_Muauth_Init;