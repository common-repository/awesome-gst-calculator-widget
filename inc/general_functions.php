<?php
//list of available countries to calculate GST
function wpgstcal_get_countries(){
	$countries = array(
		"AU"=>array(
			"name"=>"Australia",
			"currency"=>"AUD",
			"perentage"=>array(10)
		),
		"CA"=>array(
			"name"=>"Canada",
			"currency"=>"CAD",
			"perentage"=>array(5)
		),
		"NZ"=>array(
			"name"=>"New Zealand",
			"currency"=>"NZD",
			"perentage"=>array(15)
		),
		"EG"=>array(
			"name"=>"Egypt",
			"currency"=>"EGP",
			"perentage"=>array(10)		
		),
		"JE"=>array(
			"name"=>"Jersey",
			"currency"=>"JEP",
			"perentage"=>array(5)
		),
		"JO"=>array(
			"name"=>"Jordan",
			"currency"=>"JOD",
			"perentage"=>array(16)
		),
		"IN"=>array(
			"name"=>"India",
			"currency"=>"INR",
			"perentage"=>array(28,18,12,5) //multiple GST rates in India
		),
		"MY"=>array(
			"name"=>"Malaysia",
			"currency"=>"MYR",
			"perentage"=>array(6)
		),
		"MV"=>array(
			"name"=>"Maldives",
			"currency"=>"MVR",
			"perentage"=>array(6)
		),
		"SG"=>array(
			"name"=>"Singapore",
			"currency"=>"SGD",
			"perentage"=>array(7)
		)
		
	); 

	return $countries;
}

add_shortcode( 'wpgstcal', 'wpgstcal_shortcode_callback' );
function wpgstcal_shortcode_callback( $atts ) {
	//countries and respective GST percentage
	$countries = wpgstcal_get_countries();
	if(!is_admin()){
		
		$countries_html = '';
		foreach($countries as $key=>$country):
			$countries_html .= '<option value="'.$key.'"> '. esc_html($country["name"]).'</option>';
	    endforeach;

		return '<form class="wpgst-form" role="form">
		<div class="wpgst-header">
		   <h3 id="calcTitle">WP GST Calculator</h3>
		</div>
		<div class="wpgst-form-group">
		   <label for="country" class="wpgst-col-5 wpgst-control-label">Country</label>                    
		   <div class="wpgst-col-5">
			  <select id="country" class="wpgst-form-control">'.$countries_html.'</select>
		   </div>
		</div>
		<div class="wpgst-form-group">
		   <label for="gstrate" class="wpgst-col-5 wpgst-control-label">GST Rate</label>                    
		   <div class="wpgst-col-5">
			  <select id="gstrate" class="wpgst-form-control" disabled="">
				 <option value='.$countries["AU"]["perentage"][0].esc_html($countries["AU"]["perentage"][0]).'% </option>
			  </select>
		   </div>
		</div>
		<!-- GST fields -->                
		<div class="gst">
		   <div class="wpgst-form-group">
			  <label for="GSTinclusive" class="wpgst-col-5 wpgst-control-label">Price including GST</label>                        
			  <div class="wpgst-col-5">
				 <div class="wpgst-input-group">                                
					 <span class="wpgst-input-group-addon currency"></span>                                
					 <input type="text" class="wpgst-form-control decimal padding-left" id="GSTinclusive" placeholder="including GST"  autocomplete="off">                            
				 </div>
			 </div>
		   </div>
		   <div class="wpgst-form-group">
			  <label for="GST" id="GSTLabel" class="wpgst-col-5 wpgst-control-label">GST(%)</label>                        
			  <div class="wpgst-col-5">
				 <div class="wpgst-input-group">                                
					 <span class="wpgst-input-group-addon currency"></span>                                
					 <input readonly type="text" class="wpgst-form-control decimal padding-left" id="GST" placeholder="GST"   autocomplete="off">                            
				 </div>
			  </div>
		   </div>
		   <div class="wpgst-form-group">
			  <label for="GSTexclusive" class="wpgst-col-5 wpgst-control-label">Price excluding GST</label>                        
				 <div class="wpgst-col-5">
					 <div class="wpgst-input-group">                                
						 <span class="wpgst-input-group-addon currency"></span>                                
						 <input type="text" class="wpgst-form-control decimal padding-left" id="GSTexclusive"  placeholder="excluding GST" autocomplete="off">                            
					 </div>
				 </div>
		   </div>
		</div>
		<input type="hidden" id="GSTpercentage" value='.esc_html($countries["AU"]["perentage"][0]).' />
		<!-- /GST fields -->                
		<div class="wpgst-form-group button-form-group">
		   <div class="wpgst-col-6 wpgst-col-offset-2">                       
				<button type="button" onClick="resetFields()" class="wpgst-btn wpgst-btn-info wpgst-btn-block clear wpgst-center-block">Clear</button>                   
		   </div>
		</div>
		<div class="wpgst-footer">
		   
		</div>
	 </form>
	 ';
	}

}

//get all gst data
add_action('wp_ajax_wpgstcal_get_gst', 'wpgstcal_get_gst');
add_action('wp_ajax_nopriv_wpgstcal_get_gst', 'wpgstcal_get_gst');
function wpgstcal_get_gst() {
    $country = sanitize_text_field($_POST['country']);

	$countries = wpgstcal_get_countries(); //get all countries list to match

	foreach($countries as $key=>$con){
	
		if($key == $country){
			wp_send_json($countries[$key]);
			break;
		}
	}
	exit();
}
?>