<?php
/**
 * Plugin Name: NoteSpot
 * Description: A sticky notes plugin for WordPress to capture quick ideas and reminders.
 * Version: 1.0
 * Author: Hemant Jodhani
 */

add_action('admin_menu', 'notespot_add_settings_page');

function notespot_add_settings_page() {
    add_options_page(
        'NoteSpot Settings',       
        'NoteSpot',                
        'manage_options',          
        'notespot-settings',       
        'notespot_render_settings_page' 
    );
}

function notespot_render_settings_page() {
    include "setting-form.php";
}


add_action('init', 'notespot_enqueue_scripts');

function notespot_enqueue_scripts() {
    wp_enqueue_script('jquery'); 
    wp_enqueue_script('note-spot-js', plugins_url('js/script.js', __FILE__) , array('jquery'), null, true);
    wp_enqueue_script('jquery-ui-js', plugins_url('js/jquery-ui.min.js', __FILE__) , array('jquery'), null, true);
    wp_enqueue_style('note-spot-css', plugins_url('css/style.css', __FILE__) );
    wp_enqueue_style('jquery-ui-css', plugins_url('css/jquery-ui.css', __FILE__) );

    wp_localize_script('note-spot-js', 'wp_info', array(
        'pluginDir' => plugin_dir_url(__FILE__),
    ));


}


add_action('admin_bar_menu', 'notespot_add_admin_bar_items', 100);

function notespot_add_admin_bar_items($wp_admin_bar) {
    $wp_admin_bar->add_node(array(
        'id'    => 'notespot',
        'title' => 'NoteSpot',
        'href'  => '#',
        'meta'  => array(
            'title' => 'NoteSpot',
        ),
    ));

    $wp_admin_bar->add_node(array(
        'id'    => 'notespot-settings',
        'title' => 'Settings',
        'href'  => admin_url('options-general.php?page=notespot-settings'),
        'parent'=> 'notespot',
    ));

    $wp_admin_bar->add_node(array(
        'id'    => 'notespot-create-note',
        'title' => '<a class="ps-create-note-nav">Create Note</a>',
        'parent'=> 'notespot',
    ));
}
