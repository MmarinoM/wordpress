<?php
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

function add_normalize_CSS()
{
    wp_enqueue_style('normalize-styles', "https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css");
}

add_action( 'init', 'custom_proccess_order_form' );

function custom_proccess_order_form() {
    $wp_error = true;   // report errors or not
    $nonce = $_POST['_wpnonce'];

    if($_REQUEST['table-reserv'] == 'Reserve Now' && wp_verify_nonce($nonce, 'order_table_nonce')) {
        if (isset($_POST['name']) && is_email($_POST['email']) && isset($_POST['phone']) && isset($_POST['table']) && isset($_POST['place']) && isset($_POST['time'])
        && isset($_POST['date'])) { 
            global $wpdb;
            
            $tablename=$wpdb->prefix.'reservation';
            
            $data=array(
                'name'=> $_POST['name'],
                'email'=> $_POST['email'],
                'phone'=> $_POST['phone'],
                'table_for'=> $_POST['table'],
                'place'=> $_POST['place'],
                'time'=> $_POST['time'],
                'date'=> $_POST['date'],
                'message'=> $_POST['message']
            );
            // Codex says $wpdb->insert() already sanitize field for you, so it seems I don't need to do it.
                
            $wpdb->insert($tablename, $data);
            
            // echo "Order submitted";
            $wpdb->close();

            if ($_POST['place']== "chefscafetaria"){
                wp_safe_redirect('/?restaurant=the-chefs-cafetaria');
                exit;

            }

            elseif ($_POST['place']== "honkytonk"){
                wp_safe_redirect('/?restaurant=the-honkytonk');
                exit;

            }

            elseif ($_POST['place']== "becentral"){
                wp_safe_redirect('/?restaurant=the-becentral-resto');
                exit;

            }

            else {
                wp_safe_redirect('/?page_id=147');
                exit;
            }
            
        }
        
    }
}
function additional_custom_styles()
{
    /*Enqueue The Styles*/
    wp_enqueue_style( 'recette-style', get_stylesheet_directory_uri() . '/recette-style.css' ); 
}
add_action( 'wp_enqueue_scripts', 'additional_custom_styles' );
