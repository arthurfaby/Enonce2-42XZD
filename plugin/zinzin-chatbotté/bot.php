<?php /**
* Plugin Name: ZinzinChatBotté
* Plugin URI: http://localhost/
* Description: Test.
* Version: 0.1
* Author: toto
* Author URI: http://localhost/
**/

if (!defined('ABSPATH')) exit; // Exit if accessed directly
add_action('wp_head', 'our_pirabaud');

function our_pirabaud() {

    ?>
    <form>
        <input type="text" placeholder="Parlez à ChatBotté" id="message" name="message">
        <input type="submit" value="Envoyer">
    </form>
    <?php
     global $wpdb;
     $query = $wpdb->prepare("SELECT * FROM chatbot;");
     $rows = $wpdb->get_row( $query );

     print_r($rows);

    if (empty($_GET['message'])) {
        echo "<h2>No message</h2>";
    } else {
        $message = $_GET['message'];
        echo "<h2>$message</h2>";
        $wpdb->insert("chatbot", array("id"=>NULL, "user_input"=>$message, "bot_output"=>"toto"));
    };
}