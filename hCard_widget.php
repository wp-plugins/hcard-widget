<?php
/*
Plugin Name: hCard Widget
Plugin URI: http://lautman.ca/hcard-wordpress-widget/
Description: Outputs contact information in accordance with the hCard microformat standard (http://microformats.org
Version: 1.4.0
Author: Michael Lautman, @michaellautman
Author URI: http://lautman.ca
License: GPLv3
*/
/**Code for Individual hCard**/
class  hCard_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function hCard_widget() {
	    parent::WP_Widget(false, $name = 'Individual hCard Widget');	
	    }
    function form_arg(){
		return array('title','main_class' ,'name_class', 'name_block_clxass','name_url','given_name','middle_name','family_name'
		,'organization','organization_class','email','email_class','address_class','street_address','street_address_class',
		'locality_address','locality_address_class','region_address','region_address_class','postal_address','postal_address_class','country_address',
		'country_address_class','tel','tel_class','website','website_class','fax','fax_class', 'org_url', 'googleplus','twitter', 'linkedin','facebook');
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

			<div itemscope itemtype="http://schema.org/Person" id="ind-hcard" class="vcard <?php echo $main_class;?>">
				    <span itemprop="name" class="fn n <?php echo $name_class;?>">
					<span class="given-name" itemprop="givenName"> <?php echo $given_name;?></span>
					<span class="additional-name" itemprop="additionalName"> <?php echo $middle_name;?></span>
					<span class="family-name" itemprop="familyName"> <?php echo $family_name;?></span>
				    </span>
				    <?php if($org != '') { ?><div class="org <?php echo $organization_class;?>" itemscope itemtype="http://schema.org/Organization"><?php echo $organization;?></div><?php } ?>
				    
				    <span class="email <?php echo $email_class;?>" itemprop="email"><a href="mailto:<?php echo $email;?>"><?php echo $email;?></a></span><br>
				    <a class="url <?php echo $website_class;?>" href="<?php echo $website;?>" itemprop="url"><?php echo $website;?></a>
				    <div class="adr <?php echo $address_class;?>" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
					<div class="street-address <?php echo $street_address_class;?>" itemprop="streetAddress"> <?php echo $street_address;?></div>
					<span class="locality <?php echo $locality_address_class;?>" itemprop="addressLocality"> <?php echo $locality_address;?></span>
					, 
					<span class="region <?php echo $region_address_class;?>" itemprop="addressRegion"> <?php echo $region_address;?></span>
					, 
					<span class="postal-code <?php echo $postal_address_class;?>" itemprop="postalCode"> <?php echo $postal_address;?></span><br>

					<span class="country-name <?php echo $country_address_class;?>" itemprop="addressCountry"> <?php echo $country_address;?></span>
				    </div>
				    <div class="tel <?php echo $tel_class;?>" itemprop="telephone">T:<?php echo $tel;?></div>
					<?php if($fax !== '') { ?><div class="tel <?php echo $fax_class;?>" itemprop="faxNumber">F:<?php echo $fax;?></div><?php } ?>
					<div class="hCard-social-links" itemscope itemtype="http://schema.org/Person">
					<?php if($googleplus !== '') { ?><a href="<?php echo $googleplus;?>" itemprop="url" rel="author" title="Google Plus">Find me on Google Plus+</a><br><?php } ?>
					<?php if ($twitter !== '') { ?><a href="http://twitter.com/<?php echo $twitter;?>" itemprop="url" rel="me" title="Twitter">@<?php echo $twitter;?></a><br><?php } ?>
					<?php if($linkedin !== '') { ?><a href="<?php echo $linkedin;?>" itemprop="url" rel="me" title="LinkedIn">Connect on LinkedIn</a><br><?php } ?>
					<?php if($facebook !== '') { ?><a href="<?php echo $facebook;?>" itemprop="url" rel="me" title="Facebook">Follow Me on Facebook</a><br><?php }?>
				
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
			<table>
			<tr>
			    <label>Main Class:</label>
			    <td><input type="text" name="<?php echo $this->get_field_name('main_class'); ?>"  value="<?php echo $main_class;?>" /></td>
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
			    <label>Name Block Class:</label>
			    <td><input type="text" name="<?php echo $this->get_field_name('name_block_class'); ?>"  value="<?php echo $name_class;?>" /></td>
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
			<tr>
			    <td><label>Class:</label></td>
			    <td><input type="text"  size="13px"  name="<?php echo $this->get_field_name('organization_class'); ?>"  value="<?php echo $organization_class;?>" /></td>
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
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('email'); ?>"  value="<?php echo $email;?>" /><?php if($instance['error'] && (empty($email)||!$this->validateEmail($email))):?><span class="error">Required valid email</span><?php endif;?></td>
			</tr>
			<tr>
			    <td><label>Class: </label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('email_class'); ?>"  value="<?php echo $email_class;?>" /><?php if($instance['error'] && empty($email_class)):?><span class="error">Required</span><?php endif;?></td>
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
			    <td><label>Fax :</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('fax'); ?>"  value="<?php echo $fax;?>" /><?php if($instance['error'] && empty($fax)):?><span class="error">Required</span><?php endif;?></td>
			</tr>
			<tr>
			    <td><label>Class: </label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('fax_class'); ?>"  value="<?php echo $fax_class;?>" /><?php if($instance['error'] && empty($fax_class)):?><span class="error">Required</span><?php endif;?></td>
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
			<tr>
			    <td><label>Class:</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('website_class'); ?>"  value="<?php echo $website_class;?>" /></td>
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
			        <td><label>Address Class:</label></td>
				<td><input type="text" size="13px" name="<?php echo $this->get_field_name('address_class'); ?>"  value="<?php echo $address_class;?>" /></td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td ><hr /></td>
		</tr>
		<tr>
		    <td>
			<table>
			    <tr>
				<td><label>Street Address:</label></td>
				<td><input type="text"  size="13px" name="<?php echo $this->get_field_name('street_address'); ?>"  value="<?php echo $street_address;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('street_address_class'); ?>"  value="<?php echo $street_address_class;?>" /></td>
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
				<td><label>City:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('locality_address'); ?>"  value="<?php echo $locality_address;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('locality_address_class'); ?>"  value="<?php echo $locality_address_class;?>" /></td>
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
				<td><label>State or Province:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('region_address'); ?>"  value="<?php echo $region_address;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('region_address_class'); ?>"  value="<?php echo $region_address_class;?>" /></td>
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
			        <td><label>Zip Or Postalcode:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('postal_address'); ?>"  value="<?php echo $postal_address;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('postal_address_class'); ?>"  value="<?php echo $postal_address_class;?>" /></td>
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
				<td><label>Country Name:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('country_address'); ?>"  value="<?php echo $country_address;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('country_address_class'); ?>"  value="<?php echo $country_address_class;?>" /></td>
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
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('tel_class'); ?>"  value="<?php echo $tel_class;?>" /></td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr><td><hr /></td></tr>
		<tr><td><table>
		<tr><td><label>Google+</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('googleplus'); ?>"  value="<?php echo $googleplus;?>" /></td>
		</tr>
		<tr><td><hr></td></tr>
		<tr><td><label>Twitter Username</label></td>
		<td>@<input type="text" size="13px"  name="<?php echo $this->get_field_name('twitter'); ?>"  value="<?php echo $twitter;?>" /></td>
		</tr>
		<tr><td><hr></td></tr>
		<tr><td><label>Facebook Profile</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('facebook'); ?>"  value="<?php echo $facebook;?>" /></td>
		</tr>
		<tr><td><hr></td></tr>
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
		return array('title','main_class' ,'name_block_class','organization','organization_class','org_email','org_email_class','org_address_class','org_street_address','org_street_address_class',
		'org_locality_address','org_locality_address_class','org_region_address','org_region_address_class','org_postal_address','org_postal_address_class','org_country_address',
		'org_country_address_class','org_tel','tel_class','org_website','org_website_class','org_fax','fax_class', 'org_url','map_url','org_googleplus','org_twitter','org_linkedin','org_facebook');
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

			<div itemscope itemtype="http://schema.org/Organization" id="org-hcard" class="vcard <?php echo $main_class;?>">
				    
				    <div class="fn org <?php echo $organization_class;?>"><?php echo $organization;?></div>
				    
				    <?php if($email !== '') { ?><span class="email <?php echo $org_email_class;?>" itemprop="email"><a href="mailto:<?php echo $org_email;?>"><?php echo $org_email;?></a></span><br><?php } ?>
				    <a class="url <?php echo $org_website_class;?>" href="<?php echo $org_website;?>" itemprop="url"><?php echo $org_website;?></a>
				    <div class="adr <?php echo $org_address_class;?>" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
					<div class="street-address <?php echo $org_street_address_class;?>" itemprop="streetAddress"> <?php echo $org_street_address;?></div>
					<span class="locality <?php echo $org_locality_address_class;?>" itemprop="addressLocality"> <?php echo $org_locality_address;?></span>
					, 
					<span class="region <?php echo $org_region_address_class;?>" itemprop="addressRegion"> <?php echo $org_region_address;?></span><br>
					<span class="country-name <?php echo $org_country_address_class;?>" itemprop="addressCountry"> <?php echo $org_country_address;?></span>,
					<span class="postal-code <?php echo $org_postal_address_class;?>" itemprop="postalCode"> <?php echo $org_postal_address;?></span><br></div>
					<?php if($map_url !== '') {?>		
					<a href="<?php echo $map_url;?>" target="_blank" itemprop="map">MAP</a><?php } ?>
				    <?php if ($org_tel !== '') {?><div class="tel <?php echo $org_tel_class;?>" itemprop="telephone">T:<?php echo $org_tel;?></div><?php }?>
					<?php if($org_fax !== '') {?><div class="tel <?php echo $org_fax_class;?>" itemprop="faxNumber">F:<?php echo $org_fax;?></div><?php } ?>
					<div class="hCard-social-links" itemscope itemtype="http://schema.org/Person">
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
			<table>
			<tr>
			    <label>Main Class:</label>
			    <td><input type="text" name="<?php echo $this->get_field_name('main_class'); ?>"  value="<?php echo $main_class;?>" /></td>
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
			    <label>Name Block Class:</label>
			    <td><input type="text" name="<?php echo $this->get_field_name('name_block_class'); ?>"  value="<?php echo $name_class;?>" /></td>
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
			<tr>
			    <td><label>Class:</label></td>
			    <td><input type="text"  size="13px"  name="<?php echo $this->get_field_name('organization_class'); ?>"  value="<?php echo $organization_class;?>" /></td>
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
			<tr>
			    <td><label>Class: </label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_email_class'); ?>"  value="<?php echo $org_email_class;?>" /><?php if($instance['error'] && empty($email_class)):?><span class="error">Required</span><?php endif;?></td>
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
			    <td><label>Fax :</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_fax'); ?>"  value="<?php echo $org_fax;?>" /><?php if($instance['error'] && empty($org_fax)):?><span class="error">Required</span><?php endif;?></td>
			</tr>
			<tr>
			    <td><label>Class: </label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_fax_class'); ?>"  value="<?php echo $org_fax_class;?>" /><?php if($instance['error'] && empty($fax_class)):?><span class="error">Required</span><?php endif;?></td>
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
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_website'); ?>"  value="<?php echo $org_website;?>" /></td>
			</tr>
			<tr>
			    <td><label>Class:</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('website_class'); ?>"  value="<?php echo $org_website_class;?>" /></td>
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
			        <td><label>Address Class:</label></td>
				<td><input type="text" size="13px" name="<?php echo $this->get_field_name('org_address_class'); ?>"  value="<?php echo $org_address_class;?>" /></td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr>
		    <td ><hr /></td>
		</tr>
		<tr>
		    <td>
			<table>
			    <tr>
				<td><label>Street Address:</label></td>
				<td><input type="text"  size="13px" name="<?php echo $this->get_field_name('org_street_address'); ?>"  value="<?php echo $org_street_address;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_street_address_class'); ?>"  value="<?php echo $org_street_address_class;?>" /></td>
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
				<td><label>City:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_locality_address'); ?>"  value="<?php echo $org_locality_address;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_locality_address_class'); ?>"  value="<?php echo $org_locality_address_class;?>" /></td>
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
				<td><label>State or Province:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_region_address'); ?>"  value="<?php echo $org_region_address;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_region_address_class'); ?>"  value="<?php echo $org_region_address_class;?>" /></td>
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
			        <td><label>Zip Or Postalcode:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_postal_address'); ?>"  value="<?php echo $org_postal_address;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_postal_address_class'); ?>"  value="<?php echo $org_postal_address_class;?>" /></td>
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
				<td><label>Country Name:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_country_address'); ?>"  value="<?php echo $org_country_address;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_country_address_class'); ?>"  value="<?php echo $org_country_address_class;?>" /></td>
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
		    <td><hr /></td>
		</tr>
		<tr>
		    <td>
			<table>
			    <tr>
				<td><label>Telephone:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_tel'); ?>"  value="<?php echo $org_tel;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_tel_class'); ?>"  value="<?php echo $org_tel_class;?>" /></td>
			    </tr>
			</table>
		    </td>
		</tr>
		<tr><td><hr /></td></tr>
		<tr><td><table>
		<tr><td><label>Google+</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_googleplus'); ?>"  value="<?php echo $org_googleplus;?>" /></td>
		</tr>
		<tr><td><hr></td></tr>
		<tr><td><label>Twitter Username</label></td>
		<td>@<input type="text" size="13px"  name="<?php echo $this->get_field_name('org_twitter'); ?>"  value="<?php echo $org_twitter;?>" /></td>
		</tr>
		<tr><td><hr></td></tr>
		<tr><td><label>Facebook Profile</label></td>
		<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_facebook'); ?>"  value="<?php echo $org_facebook;?>" /></td>
		</tr>
		<tr><td><hr></td></tr>
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
	wp_register_style('hcard-style', plugins_url('hCard_Widget/style.css', _FILE_));
	wp_enqueue_style('hcard-style');
	}

add_action ('admin_menu', 'register_hcard_options_page');
function register_hcard_options_page(){
	add_options_page('hCard Widget Options' ,'hCard Widget', 'manage_options', 'hcard-widget-options-page', 'hcard_widget_options_output');
	add_action('admin_init','register_hcard_settings');
	}
	function register_hcard_settings () {
		register_setting('hcard-settings-group','hCard-settings', 'hCard_settings_validate');
		
		}
 
 function hcard_widget_options_output () {
	?>
	<div class="wrap">
	<h2>hCard Widget For Wordpress</h2>
	
	More information coming soon.  For details visit the <a href="http://lautman.ca/hcard-wordpress-widget" target="_blank">plugin homepage</a>.
	
	<form method="post" action="options.php">
	 <?php settings_fields( 'hcard-settings-group' ); ?>
   	 <?php $options = get_option('hCard-settings'); ?>
	<table class="form-table">
	<tr valign="top">
        <th scope="row"><h3>Show Your Appreciation</h3></th>
		</tr>
		<tr>
		<th scope="row">Display a credit link in your site's footer?(Thanks)</th>
        <td><input type="checkbox" name="hCard-settings[hCardCreditLink]" value="1" <?php checked('1', $options['hCardCreditLink']); ?> /></td>
        </tr>
		</table>
		<?php submit_button(); ?>
		</form>
	
	You can also show your apppreciation by <a href="http://my.e2rm.com/personalPage.aspx?registrationID=1688089" target="_blank">Donating to UNICEF</a>.
	<br>

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
