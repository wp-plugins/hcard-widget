<?php
/*
Plugin Name: hCard Widget
Plugin URI: http://lautman.ca/hcard-wordpress-widget/
Description: Outputs contact information in accordance with the hCard microformat and Schema.org standards
Version: 1.5
Author: michaellautman, @michaellautman
Author URI: http://lautman.ca
License: GPLv3
*/
/*Load The Stylesheet*/
// Register Style
function hCard_load_styles() {

	wp_register_style( 'hcard-style', plugins_url('style.css', __FILE__), false, false, 'all' );
	wp_enqueue_style( 'hcard-style' );
	wp_register_style('hcard-foundicons', plugins_url('foundation-icons.css', __FILE__), false, false, 'all');
	wp_enqueue_style('hcard-foundicons');
}

// Hook into the 'wp_enqueue_scripts' action
add_action( 'wp_enqueue_scripts', 'hCard_load_styles' );

/**Code for Individual hCard**/


class  hCard_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function hCard_widget() {
	    parent::WP_Widget(false, $name = 'Individual hCard Widget');	
	    }
    function form_arg(){
		return array('icons','title','main_class' ,'name_class','hc-individual-name','hc-individual-org', 'name_block_class','name_url','given_name','given-name','middle_name','additional-name','family_name',
		'family-name','organization','hc-individual-job','email','hc-individual-email','hc-individual-url','hc-individual-postal','hc-individual-street','address_class','street_address','street_address_class','hc-individual-region',
		'locality_address','hc-individual-city','hc-individual-country','hc-individual-postcode','hc-individual-phone','hc-individual-phone-2','hc-individual-fax','locality_address_class','region_address','region_address_class','postal_address','postal_address_class','country_address',
		'hc-individual-social','country_address_class','tel','tel_2','tel_class','website','website_class','fax','fax_class', 'org_url', 'googleplus','twitter', 'linkedin','facebook','job_title','ind_profile_image'
		,'ind_profile_image_class');
	    }
    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {	
		extract( $args );
		
		$array=$this->form_arg();
	    foreach($array as $val)
		${$val}=$instance[$val];
	    if(!$instance['error']){
	    
	    echo $before_widget;
		if ( $title )  
    echo $before_title . $title . $after_title;  
    ?>

			<div itemscope itemtype="http://schema.org/Person" id="ind-hcard" class="vcard hc-individual">
			<div class="row">
			<div class="row">
			
			<div class="columns small-8">
				    <span itemprop="name" class="fn n hc-individual-name"><br/>
					<span class="given-name" itemprop="givenName"> <?php echo $given_name;?></span><span class="additional-name" itemprop="additionalName"> <?php echo $middle_name;?></span><span class="family-name" itemprop="familyName"> <?php echo $family_name;?></span>
				    </span><br/>
					<?php if($job_title !='') { ?><span itemprop="jobTitle" class="hc-individual-job"><?php echo $job_title;?></span><?php }?><br/>
				    <?php if($org != '') { ?><div class="org hc-individual-org" itemscope itemtype="http://schema.org/Organization"><?php echo $organization;?></div><?php } ?><br/>
				    				    <span class="email hc-individual-email" itemprop="email"><a href="mailto:<?php echo $email;?>"><?php echo $email;?></a></span><br/>
				    <a class="url hc-individual-url" href="<?php echo $website;?>" itemprop="url"><?php echo $website;?></a><br/>
				    <div class="adr hc-individual-postal" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
					<div class="street-address hc-individual-street" itemprop="streetAddress"> <?php echo $street_address;?></div>
					<span class="locality hc-individual-city" itemprop="addressLocality"> <?php echo $locality_address;?></span>, <span class="region hc-individual-region" itemprop="addressRegion"> <?php echo $region_address;?></span><br/>
					<span class="country-name hc-individual-country" itemprop="addressCountry"> <?php echo $country_address;?></span><br/>
					<span class="postal-code hc-individual-postcode" itemprop="postalCode"> <?php echo $postal_address;?></span><br/>
				    </div>
				    <div class="tel hc-individual-phone" itemprop="telephone"><?php if($icons !== 'true') {?><i class="fi-telephone small"></i><?php }?><?php echo $tel;?></div>
					<?php if($tel_2 !==''){?><div class="tel hc-individual-phone-2 itemprop="telephone"><i class="fi-telephone small"></i><?php echo $tel_2;?></div><?php }?>
					<?php if($fax !== '') { ?><div class="tel hc-individual-fax" itemprop="faxNumber">Fax:<?php echo $fax;?></div><?php } ?>
					<div class="hc-individual-social" itemscope itemtype="http://schema.org/Person">
					<?php if($googleplus !== '') { ?><a href="<?php echo $googleplus;?>" itemprop="url" rel="author" title="Google Plus">Find me on Google Plus+</a><br><?php } ?>
					<?php if ($twitter !== '') { ?><a href="http://twitter.com/<?php echo $twitter;?>" itemprop="url" rel="me" title="Twitter">@<?php echo $twitter;?></a><br><?php } ?>
					<?php if($linkedin !== '') { ?><a href="<?php echo $linkedin;?>" itemprop="url" rel="me" title="LinkedIn">Connect on LinkedIn</a><br><?php } ?>
					<?php if($facebook !== '') { ?><a href="<?php echo $facebook;?>" itemprop="url" rel="me" title="Facebook">Follow Me on Facebook</a><br><?php }?>
			</div>	
					</div>
			</div>
			</div>
		</div>
       <?php echo $after_widget;
       }
    }
    //***  Validate function
    function validateEmail($email){
		if (eregi("^([a-z]|[0-9]|\.|-|_)+@([a-z]|[0-9]|\.|-|_)+\.([a-z]|[0-9]){2,3}$", $email, $arr_vars) &&

		    !eregi("(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)", $email, $arr_vars)){
		    return true;
		}else{
		    return false;
		}
	    }
    function isValidURL($url){
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	    }
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		unset($instance['error']);
		$array=$this->form_arg();
        foreach($array as $val)
			
         $instance[$val]=strip_tags($new_instance[$val]);
        //if(in_array('',$new_instance) || !$this->validateEmail($instance['email']) || !$this->isValidURL($instance['website'] || !$this->isValidURL($instance['org_url']) ||  !$this->isValidURL($instance['name_url']) {$instance['error']=true;return $instance;}
		return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {
		$array=$this->form_arg();
		foreach($array as $val)
         ${$val}=esc_attr($instance[$val]);			
        ?>
		<!--<style>
			.error{color: red;float: right; width: 218px;}
		</style>--> 
         <table width="222px" style="border:1px;">
	    <tr>
		<td>
		    <table>
			<tr><label>Widget Title:</label>
			<td><input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title;?>" /></td>
			</tr>
			</table>
		
		</td>
	    </tr>
	    <tr>
		<td>
				</td>
	    </tr>
	    <tr>
		<td><hr/></td>
	    </tr>
	    <tr>
		<td>
		    <table>
			<tr>
			    <td><label>Given Name:</label></td>
			    <td><input type="text" size="13px" name="<?php echo $this->get_field_name('given_name'); ?>"  value="<?php echo $given_name;?>" /></td>
			</tr>
			<tr>
			    
			    <td><label>Middle Name:</label></td>
			    <td><input type="text" size="13px" name="<?php echo $this->get_field_name('middle_name'); ?>"  value="<?php echo $middle_name;?>" /></td>
			</tr>
			
			<tr>
			    <td><label>Family Name:</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('family_name'); ?>"  value="<?php echo $family_name;?>" /></td>
			</tr>
			
		
		
		    </table>
		</td>
	    </tr>
	    <tr>
		<td><hr/></td>
	    </tr>
		
		    <tr>
		<td>
		    <table>
			<tr>
			    <td><label>Organisation:</label></td>
			    <td><input type="text"  size="13px"  name="<?php echo $this->get_field_name('organization'); ?>"  value="<?php echo $organization;?>" /></td>
			</tr>
						    
		</td>
	    </tr>

			<tr><td><label>Job Title</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('job_title'); ?>"  value="<?php echo $job_title;?>" /></td>
			</tr>
			  </table>  
		<tr>
		    <td><hr /></td>
	    </tr>
	    <tr>
		<td>
		    <table>
			<tr>
			    <td><label>Email:</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('email'); ?>"  value="<?php echo $email;?>" /><?php if($instance['error'] && (empty($email)||!$this->validateEmail($email))):?><span class="error">Required valid email</span><?php endif;?></td>
			</tr>
			    </table>
		</td>
	    </tr>
	     <tr>
		    <td><hr /></td>
	    </tr>

	    <tr>
	        <td>
		    <table>
			<tr>
			    <td><label>Website :</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('website'); ?>"  value="<?php echo $website;?>" /></td>
			</tr>
			    </table>
		</td>
		</tr>
		<tr>
		    <td><hr /></td>
		</tr>
					<tr>
		    <td>
			<table>
			    <tr>
				<td><label>Street Address:</label></td>
				<td><input type="text"  size="13px" name="<?php echo $this->get_field_name('street_address'); ?>"  value="<?php echo $street_address;?>" /></td>
			    </tr>
		
		
		<tr>
		    <td>
		
			    <tr>
				<td><label>City:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('locality_address'); ?>"  value="<?php echo $locality_address;?>" /></td>
			    </tr>
					
		    </td>
		</tr>
		
		
			    <tr>
				<td><label>State or Province:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('region_address'); ?>"  value="<?php echo $region_address;?>" /></td>
			    </tr>
				
		
		
			    <tr>
			        <td><label>Zip Or Postalcode:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('postal_address'); ?>"  value="<?php echo $postal_address;?>" /></td>
			    </tr>
		
			
			
			    <tr>
				<td><label>Country Name:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('country_address'); ?>"  value="<?php echo $country_address;?>" /></td>
			    </tr>
		
			</table>
		    </td>
		</tr>
		<tr>
		    <td><hr /></td>
		</tr>
		<tr>
		    <td>
			<table>
			    <tr>
				<td><label>Telephone:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('tel'); ?>"  value="<?php echo $tel;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Other Telephone:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('tel_2'); ?>"  value="<?php echo $tel_2;?>" /></td>
			    </tr>
			</table>
		    </td>
		</tr>
			    <tr>
		<td>
		    <table>
			<tr>
			    <td><label>Fax :</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('fax'); ?>"  value="<?php echo $fax;?>" /><?php if($instance['error'] && empty($fax)):?><span class="error">Required</span><?php endif;?></td>
			</tr>
			    </table>
		</td>
	    </tr>
		<tr><td><hr /></td></tr>
		<tr><td><table>
		<tr><td><label>Google+</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('googleplus'); ?>"  value="<?php echo $googleplus;?>" /></td>
		</tr>
		
		<tr><td><label>Twitter (@)</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('twitter'); ?>"  value="<?php echo $twitter;?>" /></td>
		</tr>
	
		<tr><td><label>Facebook Profile</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('facebook'); ?>"  value="<?php echo $facebook;?>" /></td>
		</tr>
		
		<tr><td><label>LinkedIn</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('linkedin'); ?>"  value="<?php echo $linkedin;?>" /></td>
		</tr>
		</table>
		</td></tr>
           </table>
<?php 
    } 
} // end class example_widget

add_action('widgets_init', create_function('', 'return register_widget("hCard_widget");'));

?>
<?php
class  org_hCard_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function org_hCard_widget() {
	    parent::WP_Widget(false, $name = 'Organization hCard Widget');	
	    }
    function form_arg(){
		return array('title','main_class' ,'name_block_class',' hc-organization-name','hc-organization-email',
		'hc-organization-url','hc-organization-postal','hc-organization-street','hc-organization-city','hc-organization-country','hc-organization-postcode',
		'hc-organization-region','hc-organization-phone','hc-organization-phone-2','hc-organization-fax','hc-organization-social','organization','organization_class','org_email','org_email_class','org_address_class','org_street_address','org_street_address_class',
		'org_locality_address','org_locality_address_class','org_region_address','org_region_address_class','org_postal_address','org_postal_address_class','org_country_address',
		'org_country_address_class','org_tel','org_tel_2','tel_class','org_website','org_website_class','org_fax','fax_class', 'org_url','map_url','org_googleplus','org_twitter','org_linkedin','org_facebook');
	    }
    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {	
		extract( $args );
		
		$array=$this->form_arg();
	    foreach($array as $val)
		${$val}=$instance[$val];
	    if(!$instance['error']){
	    
	    echo $before_widget;
		if ( $title )  
    echo $before_title . $title . $after_title;  
    ?>

			<div itemscope itemtype="http://schema.org/Organization" id="org-hcard" class="vcard hc-organization">
				    
				    <div class="fn org hc-organization-name"><?php echo $organization;?></div>
				    <?php if($email !== '') { ?><span class="email hc-organization-email" itemprop="email"><a href="mailto:<?php echo $org_email;?>"><?php echo $org_email;?></a></span><br><?php } ?>
				    <a class="url hc-organization-url" href="<?php echo $org_website;?>" itemprop="url"><?php echo $org_website;?></a>
				    <div class="adr hc-organization-postal" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
					<div class="street-address hc-organization-street" itemprop="streetAddress"> <?php echo $org_street_address;?></div>
					<span class="locality hc-organization-city" itemprop="addressLocality"> <?php echo $org_locality_address;?></span>, <span class="region hc-organization-region" itemprop="addressRegion"> <?php echo $org_region_address;?></span><br>
					<span class="country-name hc-organization-country" itemprop="addressCountry"> <?php echo $org_country_address;?></span>,
					<span class="postal-code hc-organization-postcode" itemprop="postalCode"> <?php echo $org_postal_address;?></span><br></div>
					<?php if($map_url !== '') {?>		
					<a href="<?php echo $map_url;?>" target="_blank" itemprop="map">MAP</a><?php } ?>
				    <?php if ($org_tel !== '') {?><div class="tel hc-organization-phone" itemprop="telephone">T:<?php echo $org_tel;?></div><?php }?>
					<?php if ($org_tel_2 !== '') {?><div class="tel hc-organization-phone-2" itemprop="telephone">T:<?php echo $org_tel_2;?></div><?php }?>
					<?php if($org_fax !== '') {?><div class="tel hc-organization-fax" itemprop="faxNumber">F:<?php echo $org_fax;?></div><?php } ?>
					<div class="hc-organization-social" itemscope itemtype="http://schema.org/Organization">
					<?php if($org_googleplus !== '') { ?><a href="<?php echo $org_googleplus;?>" itemprop="url" rel="publisher">Find Us on Google Plus+</a><br><?php } ?>
					<?php if($org_twitter !== '') { ?><a href="http://twitter.com/<?php echo $org_twitter;?>" itemprop="url" rel="me">@<?php echo $org_twitter;?></a><br><?php } ?>
					<?php if($org_linkedin !== '') { ?><a href="<?php echo $org_linkedin;?>" itemprop="url" rel="me">Connect on LinkedIn</a><br><?php } ?>
					<?php if($org_facebook !== '') { ?><a href="<?php echo $org_facebook;?>" itemprop="url" rel="me">Follow Us on Facebook</a><br><?php }?>
					</div>
			</div>
			
			
       <?php echo $after_widget;
       }
    }
    //***  Validate function
    function validateEmail($email){
		if (eregi("^([a-z]|[0-9]|\.|-|_)+@([a-z]|[0-9]|\.|-|_)+\.([a-z]|[0-9]){2,3}$", $email, $arr_vars) &&

		    !eregi("(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)", $email, $arr_vars)){
		    return true;
		}else{
		    return false;
		}
	    }
    function isValidURL($url){
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	    }
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		unset($instance['error']);
		$array=$this->form_arg();
        foreach($array as $val)
			
         $instance[$val]=strip_tags($new_instance[$val]);
        //if(in_array('',$new_instance) || !$this->validateEmail($instance['email']) || !$this->isValidURL($instance['website'] || !$this->isValidURL($instance['org_url'] ||  !$this->isValidURL($instance['name_url'] ||  !$this->isValidURL($instance['map_url']) {$instance['error']=true;return $instance;}
		return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {
		$array=$this->form_arg();
		foreach($array as $val)
         ${$val}=esc_attr($instance[$val]);			
        ?>
		<!--<style>
			.error{color: red;float: right; width: 218px;}
		</style>--> 
         <table width="222px" style="border:1px;">
	    <tr>
		<td>
		    <table>
			<tr><label>Widget Title:</label>
			<td><input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title;?>" /></td>
			</tr>
			</table>
			
		</td>
	    </tr>
	     <tr>
		    <td><hr /></td>
	    </tr>
	   
	    <tr>
		<td>
		    <table>
			<tr>
			    <td><label>Organisation:</label></td>
			    <td><input type="text"  size="13px"  name="<?php echo $this->get_field_name('organization'); ?>"  value="<?php echo $organization;?>" /></td>
			</tr>
						
		    </table>
		</td>
	    </tr>
	     <tr>
		    <td><hr /></td>
	    </tr>
	    <tr>
		<td>
		    <table>
			<tr>
			    <td><label>Email:</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_email'); ?>"  value="<?php echo $org_email;?>" /><?php if($instance['error'] && (empty($email)||!$this->validateEmail($email))):?><span class="error">Required valid email</span><?php endif;?></td>
			</tr>
			
		    </table>
		</td>
	    </tr>
	     <tr>
		    <td><hr /></td>
	    </tr>
	    
	    <tr>
		    <td><hr /></td>
	    </tr>
	    <tr>
	        <td>
		    <table>
			<tr>
			    <td><label>Website :</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_website'); ?>"  value="<?php echo $org_website;?>" /></td>
			</tr>
			
		    </table>
		</td>
		</tr>
		<tr>
		    <td><hr /></td>
		</tr>
		
		
		<tr>
		    <td>
			<table>
			    <tr>
				<td><label>Street Address:</label></td>
				<td><input type="text"  size="13px" name="<?php echo $this->get_field_name('org_street_address'); ?>"  value="<?php echo $org_street_address;?>" /></td>
			    </tr>
			    
			    <tr>
				<td><label>City:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_locality_address'); ?>"  value="<?php echo $org_locality_address;?>" /></td>
			    </tr>
			    
			    <tr>
				<td><label>State or Province:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_region_address'); ?>"  value="<?php echo $org_region_address;?>" /></td>
			    </tr>
			    
			    <tr>
			        <td><label>Zip Or Postalcode:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_postal_address'); ?>"  value="<?php echo $org_postal_address;?>" /></td>
			    </tr>
			     <tr>
				<td><label>Country Name:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_country_address'); ?>"  value="<?php echo $org_country_address;?>" /></td>
			    </tr>
			    
			</table>
		    </td>
		</tr>
		<tr>
		    <td><hr /></td>
		</tr>
		<tr>
		<td><table>
		<tr><td><label>Map URL:</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('map_url'); ?>"  value="<?php echo $map_url; ?>" /></td>
		</tr></table></td></tr>
	
		<tr>
		    <td>
			<table>
			    <tr>
				<td><label>Telephone:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_tel'); ?>"  value="<?php echo $org_tel;?>" /></td>
			    </tr>
				<tr>
				<td><label>Other Phone:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_tel_2'); ?>"  value="<?php echo $org_tel_2;?>" /></td>
			    </tr>
			<tr>
			
			    <td><label>Fax :</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_fax'); ?>"  value="<?php echo $org_fax;?>" /><?php if($instance['error'] && empty($org_fax)):?><span class="error">Required</span><?php endif;?></td>
			</tr>

				
			</table>
		    </td>
		</tr>
		<tr><td><hr /></td></tr>
		<tr><td><table>
		<tr><td><label>Google+</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_googleplus'); ?>"  value="<?php echo $org_googleplus;?>" /></td>
		</tr>
		
		<tr><td><label>Twitter </label></td>
		<td>@<input type="text" size="13px"  name="<?php echo $this->get_field_name('org_twitter'); ?>"  value="<?php echo $org_twitter;?>" /></td>
		</tr>
		
		<tr><td><label>Facebook Page</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_facebook'); ?>"  value="<?php echo $org_facebook;?>" /></td>
		</tr>
		
		<tr><td><label>LinkedIn</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_linkedin'); ?>"  value="<?php echo $org_linkedin;?>" /></td>
		</tr>
           </table>
		   </table>
<?php 
    } 
} 
// end class example_widget

add_action('widgets_init', create_function('', 'return register_widget("org_hCard_widget");'));


add_action('wp_enqueue_scripts', 'hcard_add_css');

function hcard_add_css(){
	wp_register_style('hcard-style', plugins_url('hCard_Widget-beta/style.css', _FILE_));
	wp_enqueue_style('hcard-style');
	}
	

	
add_action ('admin_menu', 'register_hcard_options_page');
function register_hcard_options_page(){
	global $hcard_options_page;
	$hcard_options_page = add_options_page('hCard Widget Options' ,'hCard Widget', 'manage_options', 'hcard-widget-options-page', 'hcard_widget_options_output');
	}
	add_action('admin_init','register_hcard_settings');
	
	function register_hcard_settings () {
		register_setting('hcard-settings-group','hCard-settings', 'hCard_settings_validate');
		
		}
		
    /**
     * Add stylesheet to the page
     */
    function hcard_add_admin_style( $hook ) {
		global $hcard_options_page;
        if( $hook != $hcard_options_page)
		
		//'options-general.php?page=hcard-widget-options-page' != $page )
        {
             return;
        }
		
        wp_enqueue_style( 'hcard-foundation', plugins_url('css/foundation.css', __FILE__) );
		wp_enqueue_style('hcard-normalize', plugins_url('css/normalize.css', __FILE__) );
		wp_enqueue_style('hcard-admin-style', plugins_url('css/hcard-admin-style.css', __FILE__) );
	
    }
   add_action( 'admin_enqueue_scripts', 'hcard_add_admin_style' );

 function hcard_widget_options_output () {
	?>
	<div class="wrap">
	<div class=row">
	<div class="small-12 columns">
	<h2>hCard Widget For Wordpress</h2>
	 For details visit the <a href="http://lautman.ca/hcard-wordpress-widget" target="_blank">plugin homepage</a>.
	 </div>
	 </div>
	 <div class="row">
	 <div class="large-7 columns">
	 
	
	<form method="post" action="options.php">
	 <?php settings_fields( 'hcard-settings-group' ); ?>
   	 <?php $options = get_option('hCard-settings'); ?>
	<div class="row">
        <h3>Show Your Appreciation</h3>
		</div>
		<div class="row">
		
      <input id="credit-link" type="checkbox" name="hCard-settings[hCardCreditLink]" value="1" <?php checked('1', $options['hCardCreditLink']); ?> /><label for="credit-link">Display a credit link in your site's footer?(Thanks)</label>
    </div>
	<div class="row">
		<?php submit_button(); ?>
		</div>
		</form>
	
	You can also show your apppreciation by <a href="http://my.e2rm.com/personalPage.aspx?registrationID=1688089" target="_blank">Donating to UNICEF</a>.
	<div class="row">
	<h3>Using the Plugin</h3>
	</div>
	<div class="row">
	<h4>Basic Usage</h4>	
	<p>Now that you've installed the plugin, using it is very simple.<br/>
	<ol>
	<li>Head over to Appearance > Widgets</li>
	<li>You will see two new widgets, "Individual hCard" and "Organization hCard". </li>
	<li>Drag the one you want to the widget area (sidebar) where you want the formatted contact information to appear.</li>
	<li>Fill in the appropriate fields.</li>
	<li>You're done.</li>
	</ol>
	</p>
	</div>
	
	</div>
	<div class="large-5 columns">
	<div class="row">
	<div id="hcard-settings-social">
	<h3>Why Not Share The Love?  Tell Your Friends!</h3>
	<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=388689464532677";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-href="http://lautman.ca/hcard-widget-wordpress/" data-send="true" data-width="450" data-show-faces="true" data-action="recommend" data-font="lucida grande"></div>
	<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://bit.ly/TrZ2Wd" data-text="Using Wordpress? Supercharge your local SEO!" data-via="michaellautman" data-size="large">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	
	</div>
	</div>
	<div class="row">
	<div class="panel callout radius">
	<strong>Help your local rankings even more!</strong><br/>
	Download our FREE Google+ Review Handout Template to get more reviews on your Google+ Local page.<br/><br/>
	<a class="hc-button alert" href="http://lautman.ca/google-review-handout-template/"  target="_blank">Get It Now!</a>
	</div>
	</div>
	
<div id="hcard-social-follow">
<h3>Keep In Touch</h3>
Let me know what you think about the plugin, and stay on top of all the changes and improvements in works for this plugin.<br>
<a href="https://twitter.com/michaellautman" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @michaellautman</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<div class="fb-subscribe" data-href="https://www.facebook.com/thelautmangroup" data-show-faces="true" data-width="450"></div>

	</div>
	</div>
	</div>
	<div class="row">
	<h4>Advanced Usage</h4>
		
	<p>Each element of the hCard widget has its own CSS class that you can use to customize the appearance of the widget.</p>
	<p>You can find extensive documentation on using the classes <a href="http://lautman.ca/hcard-widget-docs">here.</a></p>
	
<script src="http://pastebin.com/embed_js.php?i=BVER8j62"></script>
	  </div> 
	  </div>
		<?php }?>
<?php 
				 function hcard_credit_link() {
     echo '<p><a href="http://lautman.ca/hcard-widget-wordpress" target="_blank">Local SEO Plugin</a> by The Lautman Group</p>';
}
$options = get_option('hCard-settings');
if ($options['hCardCreditLink'] == "1") { 
add_action('wp_footer', 'hcard_credit_link');
}
function hCard_settings_validate($input) {
 $input['hCardCreditLink'] = ( $input['hCardCreditLink'] == 1 ? 1 : 0 );

 return $input;
 }