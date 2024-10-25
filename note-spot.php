<?php
/**
 * Plugin Name: NoteSpot
 * Description: A sticky notes plugin for WordPress to capture quick ideas and reminders.
 * Version: 1.0
 * Author: Hemant Jodhani
 */

register_activation_hook(__FILE__, 'notespot_activate');

function notespot_activate() {
    global $wpdb;
    $default_settings = array(
        'user_roles' => ['administrator', 'editor', 'author', 'contributor', 'subscriber'],
        'note_theme' => 0,
    );

    if (get_option('pr_settings') === false) {
        add_option('pr_settings', $default_settings);
    }

    $table_name = $wpdb->prefix . 'notespot_notes';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        note_id mediumint(9) NOT NULL AUTO_INCREMENT,
        note text NOT NULL,
        time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        user_id bigint(20) UNSIGNED NOT NULL,
        PRIMARY KEY (note_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action('admin_menu', 'notespot_add_settings_page');

function notespot_add_settings_page() {

    $settings = get_option('pr_settings');

    $current_user = wp_get_current_user();
    $user_roles = $current_user->roles;

    if(in_array( $user_roles[0] , $settings['user_roles'] )){
        add_options_page(
            'NoteSpot Settings',       
            'NoteSpot',                
            'manage_options',          
            'notespot-settings',       
            'notespot_render_settings_page' 
        );
    }

    add_menu_page(
        'NoteSpot Archive', 
        'NoteSpot Archive',
        'manage_options',   
        'notespot-archive', 
        'notespot_render_archive_page', 
        'dashicons-sticky'
    );

}

function notespot_render_settings_page() {
    include "setting-form.php";
}

function notespot_render_archive_page() {
    include "notes-archive.php";
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
        'ajaxUrl'   => admin_url('admin-ajax.php'),
        'userId'    => get_current_user_id(),
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

    $settings = get_option('pr_settings');

    $current_user = wp_get_current_user();
    $user_roles = $current_user->roles;

    $wp_admin_bar->add_node(array(
        'id'    => 'notespot-archive',
        'title' => 'NoteSpot Archive',
        'href'  => admin_url('admin.php?page=notespot-archive'),
        'parent'=> 'notespot',
    ));

    if(in_array( $user_roles[0] , $settings['user_roles'] )){
        $wp_admin_bar->add_node(array(
            'id'    => 'notespot-create-note',
            'title' => '<a data-theme="' . esc_attr($settings['note_theme']) . '" class="ps-create-note-nav">Create Note</a>',
            'parent'=> 'notespot',
        ));    

        $wp_admin_bar->add_node(array(
            'id'    => 'notespot-settings',
            'title' => 'Settings',
            'href'  => admin_url('options-general.php?page=notespot-settings'),
            'parent'=> 'notespot',
        ));
    }
}


add_action('wp_ajax_save_note', 'notespot_save_note');

function notespot_save_note() {
    global $wpdb;

    $note_content = isset($_POST['note']);
    $user_id = isset($_POST['user_id']) ;

    if (empty($note_content) || !$user_id) {
        wp_send_json_error('Invalid note content or user ID.');
    }

    $table_name = $wpdb->prefix . 'notespot_notes';

    $result = $wpdb->insert(
        $table_name,
        array(
            'note' => $note_content,
            'user_id' => $user_id,
        )
    );

    if ($result) {
        wp_send_json_success();
    } else {
        wp_send_json_error('Failed to save note.');
    }
}