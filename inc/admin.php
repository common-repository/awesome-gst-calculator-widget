<?php
///////////////SAVE DATA ON SUBMIT///////////////////
add_action('init', 'wpgstcal_save_settings');

function wpgstcal_save_settings(){
	if(!empty($_POST['submitcSettingsForm']) && isset($_POST['submitcSettingsForm'])){

		//check for nonce
		$retrieved_nonce = $_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($retrieved_nonce, 'wpgstcal_settings__security_nonce' ) ) die( 'Failed security check' );
	
		//save settings
		if(@$_POST['wpgstcal_enabled']){
			update_option('wpgstcal_enabled',1);
		}else{
			delete_option('wpgstcal_enabled');
		}
	
		
	}
}

//display admin menu
add_action('admin_menu', 'wpgstcal_admin_menu');
function wpgstcal_admin_menu(){
    add_menu_page('WP GST Calculator', 'WP GST Calculator', 'manage_options', 'wpgstcal-settings', 'wpgstcal_settings',WPGSTCAL_PLUGIN_URL."/assets/icon-20x20.png");
}
function wpgstcal_settings(){
	//get all settings
	$wpgstcal_enabled = get_option('wpgstcal_enabled');
	
	?>

	<div class="fsc_container">
		<div class="fsc_container_inner">
			<div class="fsc_title">
				<div class="caption">
					<h1 class="caption-subject font-green-sharp "><?php _e('WP GST Calculator Settings', 'cqpim'); ?> </h1>
				</div>
			</div>
			<hr/>	
			<table class="settingsTable">
				<form method="post" action="" id="settingsForm">	
				<?php wp_nonce_field('wpgstcal_settings__security_nonce'); ?>
				<tr>
					<td>Enable GST Calculator</td>
					<td><input type="checkbox" name="wpgstcal_enabled" id="wpgstcal_enabled" value="1" <?php if($wpgstcal_enabled==1) { echo "checked"; } ?>></td>
				</tr>
				<tr>
					<td style="height:20px"></td>
				</tr>
				<tr>
					<td></td><input type="hidden"  name="submitcSettingsForm" value="submitcSettingsForm" />
					<td><button type="submit" class="button button-primary">Save Settings</button></td>
				</tr>
				</form>		
				
			</table>
		</div>
	</div>
	<style>
		.fsc_container{
			background:#fff;
			width:100%;
			margin-top:20px;
		}
		.fsc_container_inner{
			padding:20px;
		}
	</style>		
<?php				
}