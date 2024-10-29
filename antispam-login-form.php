<?php
/**
 * Plugin Name: Antispam Login Form
 * Plugin URI: https://www.seosthemes.com/antispam-login-form/
 * Contributors: seosbg
 * Author: seosbg
 * Description: Antispam Login Form WordPress plugin add sum field.
 * Version: 1.0
 * License: GPL2
 */

add_action('admin_menu', 'antispam_login_form_menu');
function antispam_login_form_menu() {
    add_menu_page('Antispam Login Form', 'Antispam Login Form', 'administrator', 'antispam-login-form', 'antispam_login_form_settings_page', plugins_url('antispam-login-form/images/icon.png')
    );

    add_action('admin_init', 'antispam_login_form_register_settings');
}


	function antispam_login_form_admin_styles() {
	
		wp_register_style( 'antispam_login_form_admin_style', plugin_dir_url(__FILE__) . 'css/antispam-login-form.css' );
		wp_enqueue_style( 'antispam_login_form_admin_style');
	}
	
	add_action( 'admin_enqueue_scripts', 'antispam_login_form_admin_styles' );
	
	
	
function antispam_login_form_register_settings() {
    register_setting('antispam-login-form', 'antispam_login_form_activate_admin_login');
    register_setting('antispam-login-form', 'antispam_login_form_activate_user_login');
}
				
//---------------------------------------- Login form field Sum --------------------------------------------

add_action('login_form','antispam_login_form_add_login_fields');
add_filter( 'wp_authenticate_user', 'antispam_login_form_validate_captcha_field' , 10, 2 );

function antispam_login_form_add_login_fields() {
    ?>
    <p>
         <input class="noselect" type="text" name="rand" value="<?php echo rand(1,100)+4 . " +10 = ";?>" readonly="readonly" />
         <label><?php _e('Enter the SUM below', 'antispam-login-form'); ?></label>
         <input type="text" name="text" value="" />
    </p>
    <?php
}


		function antispam_login_form_validate_captcha_field($user, $password) {if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$rand = $_POST['rand'];
	$text = htmlspecialchars($_POST['text']);	
	$numb = 10;
	$sum = ($numb + $rand);   	
}	
			if ( ! isset( $_POST['text'] ) || empty( $_POST['text'] )  ) {
			return new WP_Error( 'invalid_captcha', 'Sum should not be empty');
		}
		if( isset( $_POST['text'] ) && ($sum != $text) ) {
			return new WP_Error( 'invalid_captcha', 'Sum was incorrect');
		}
		return $user;
	}
	
//---------------------------------------- Register user field Sum --------------------------------------------


add_action( 'register_form', 'antispam_login_form_add_registration_fields' );
add_filter('registration_errors', 'antispam_login_form_validate_captcha_field', 10, 3);

function antispam_login_form_add_registration_fields() {

    //Get and set any values already sent
    $user_extra = ( isset( $_POST['user_extra'] ) ) ? $_POST['user_extra'] : '';
       ?>
    <p>
         <input class="noselect" type="text" name="rand" value="<?php echo rand(1,100)+4 . " +10 = ";?>" readonly="readonly" />
         <label><?php _e('Enter the SUM below', 'antispam-login-form'); ?></label>
         <input type="text" name="text" value="" />
    </p>
    <?php
}
			
function antispam_login_form_settings_page() {
?>

    <div class="wrap antispam-login-form">
		<h1><?php _e('Antispam Login Form', 'antispam-login-form'); ?></h1>
        <form action="options.php" method="post" role="form" name="antispam-login-form">
		
			<?php settings_fields( 'antispam-login-form' ); ?>
			<?php do_settings_sections( 'antispam-login-form' ); ?>
		
			<div>
				<a target="_blank" href="http://seosthemes.com/">
					<div class="btn s-red">
						 <?php _e('SEOS', 'antispam-login-form'); echo ' <img class="ss-logo" src="' . plugins_url( 'images/logo.png' , __FILE__ ) . '" alt="logo" />';  _e(' THEMES', 'antispam-login-form'); ?>
					</div>
				</a>
			</div>
			

			
		</form>	
	</div>
	
	<?php } 
	
	function antispam_login_form_language_load() {
		load_plugin_textdomain('antispam_login_form_language_load', FALSE, basename(dirname(__FILE__)) . '/languages');
	}
	add_action('init', 'antispam_login_form_language_load');

	
