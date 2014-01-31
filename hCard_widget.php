<?php
/*
Plugin Name: hCard Widget
Plugin URI: http://lautman.ca/hcard-wordpress-widget/
Description: Outputs contact information in accordance with the hCard microformat standard (http://microformats.org
Version: 1.5.4
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
		'country_address_class','tel','tel_class','website','website_class','fax','fax_class', 'org_url', 'googleplus','twitter', 'linkedin','facebook','job_title','ind_profile_image'
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
				    <span itemprop="name" class="fn n hc-individual-name">
					<span class="given-name" itemprop="givenName"> <?php echo $given_name;?></span><span class="additional-name" itemprop="additionalName"> <?php echo $middle_name;?></span><span class="family-name" itemprop="familyName"> <?php echo $family_name;?></span>
				    </span>
					<?php if($job_title !='') { ?><span itemprop="jobTitle" class="hc-individual-job"><?php echo $job_title;?></span><?php }?>
				    <?php if($org != '') { ?><div class="org hc-individual-org" itemscope itemtype="http://schema.org/Organization"><?php echo $organization;?></div><?php } ?>
				    <span class="email hc-individual-email" itemprop="email"><a href="mailto:<?php echo $email;?>"><?php echo $email;?></a></span><br>
				    <a class="url hc-individual-url" href="<?php echo $website;?>" itemprop="url"><?php echo $website;?></a><br/>
				    <?php if($street_address !== '') { ?><div class="adr hc-individual-postalAddress" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
					<div class="street-address hc-individual-street" itemprop="streetAddress"> <?php echo $street_address;?></div>
					<span class="locality hc-individual-city" itemprop="addressLocality"> <?php echo $locality_address;?></span>, <span class="region hc-individual-region" itemprop="addressRegion"> <?php echo $region_address;?></span><br/>
					<span class="country-name hc-individual-country" itemprop="addressCountry"> <?php echo $country_address;?></span><br/>
					<span class="postal-code hc-individual-postcode" itemprop="postalCode"> <?php echo $postal_address;?></span><br />
				    </div><?php }?>
				    <div class="tel hc-individual-phone" itemprop="telephone">T:<a href="tel:+1<?php echo $tel;?>"><?php echo $tel;?></a></div>
					<?php if($tel-2 !== '') {?><div class="tel hc-individual-phone-2" itemprop="telephone">T:<a href="tel:+1<?php echo $tel-2;?>"<?php echo $tel;?></a></div><?php }?>
					<?php if($fax !== '') { ?><div class="tel hc-individual-fax" itemprop="faxNumber">F:<?php echo $fax;?></div><?php } ?>
					<div class="hc-individual-social" itemscope itemtype="http://schema.org/Person">
					<?php if($googleplus !== '') { ?><a href="<?php echo $googleplus;?>" class="hc-individual-gplus" itemprop="url" rel="author" title="Google Plus">Find me on Google Plus+</a><br><?php } ?>
					<?php if ($twitter !== '') { ?><a href="http://twitter.com/<?php echo $twitter;?>" class="hc-individual-twitter" itemprop="url" rel="me" title="Twitter">@<?php echo $twitter;?></a><br><?php } ?>
					<?php if($linkedin !== '') { ?><a href="<?php echo $linkedin;?>" itemprop="url" class="hc-individual-linkedin" rel="me" title="LinkedIn">Connect on LinkedIn</a><br><?php } ?>
					<?php if($facebook !== '') { ?><a href="<?php echo $facebook;?>" itemprop="url" class="hc-individual-fb" rel="me" title="Facebook">Follow Me on Facebook</a><br><?php }?>
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
		    <td><hr /></td>
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
			<tr>
		<td><hr/></td>
	    </tr>
		<tr>
		<td>
		<table>
			<tr><td><label>Job Title</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('job_title'); ?>"  value="<?php echo $job_title;?>" /></td>
			</tr>
		    
			<tr>
			    <td><label>Organisation:</label></td>
			    <td><input type="text"  size="13px"  name="<?php echo $this->get_field_name('organization'); ?>"  value="<?php echo $organization;?>" /></td>
			</tr>
			  </table>
		</td>
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
				<td><label>Phone:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('tel'); ?>"  value="<?php echo $tel;?>" /></td>
			    </tr>
			    
			
			    <tr>
				<td><label>Other Phone:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('tel2'); ?>"  value="<?php echo $tel2;?>" /></td>
			    </tr>
			    
			
			<tr>
			    <td><label>Fax :</label></td>
			    <td><input type="text" size="13px"  name="<?php echo $this->get_field_name('fax'); ?>"  value="<?php echo $fax;?>" /><?php if($instance['error'] && empty($fax)):?><span class="error">Required</span><?php endif;?></td>
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
				<td><label>City:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('locality_address'); ?>"  value="<?php echo $locality_address;?>" /></td>
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

			<div itemscope itemtype="http://schema.org/Organization" id="org-hcard" class="vcard hc-organization">
				    
				    <div class="fn org hc-organization-name"><?php echo $organization;?></div>
				    <?php if($email !== '') { ?><span class="email hc-organization-email" itemprop="email"><a href="mailto:<?php echo $org_email;?>"><?php echo $org_email;?></a></span><br><?php } ?>
				    <a class="url hc-organization-url" href="<?php echo $org_website;?>" itemprop="url"><?php echo $org_website;?></a>
				    <?php if($org_street_address !== '') { ?><div class="adr hc-organization-postalAddress" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
					<div class="street-address hc-organization-street" itemprop="streetAddress"> <?php echo $org_street_address;?></div>
					<span class="locality hc-organization-city" itemprop="addressLocality"> <?php echo $org_locality_address;?></span>, <span class="region hc-organization-region" itemprop="addressRegion"> <?php echo $org_region_address;?></span><br>
					<span class="country-name hc-organization-country" itemprop="addressCountry"> <?php echo $org_country_address;?></span>,<br/>
					<span class="postal-code hc-organization-postalcode" itemprop="postalCode"> <?php echo $org_postal_address;?></span><br></div><?php } ?>
					<?php if($map_url !== '') {?>		
					<a href="<?php echo $map_url;?>" target="_blank" class="hc-organization-map" itemprop="map">MAP</a><?php } ?>
					<?php if ($org_tel !== '') {?><div class="tel hc-organization-tel " itemprop="telephone">T:<a href="tel:+1<?php echo $org_tel;?>"><?php echo $org_tel;?></a></div><?php }?>
					<?php if ($org_tel !== '') {?><div class="tel hc-organization-tel2 " itemprop="telephone">T:<a href="tel:+1<?php echo $org_tel2;?>"><?php echo $org_tel;?></a></div><?php }?>
					<?php if($org_fax !== '') {?><div class="tel hc-organization-fax>" itemprop="faxNumber">F:<?php echo $org_fax;?></div><?php } ?>
					<div class="hc-organization-social" itemscope itemtype="http://schema.org/Organization">
					<?php if($org_googleplus !== '') { ?><a href="<?php echo $org_googleplus;?>" class="hc-organization-gplus" itemprop="url" rel="publisher">Find Us on Google Plus+</a><br><?php } ?>
					<?php if($org_twitter !== '') { ?><a href="http://twitter.com/<?php echo $org_twitter;?>" class="hc-organization-twitter" itemprop="url" rel="me">@<?php echo $org_twitter;?></a><br><?php } ?>
					<?php if($org_linkedin !== '') { ?><a href="<?php echo $org_linkedin;?>" class="hc-organization-linkedin" itemprop="url" rel="me">Connect on LinkedIn</a><br><?php } ?>
					<?php if($org_facebook !== '') { ?><a href="<?php echo $org_facebook;?>" class="hc-organization-fb" itemprop="url" rel="me">Follow Us on Facebook</a><br><?php }?>
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
		    <td><hr /></td>
		</tr>
		<tr>
		    <td>
			<table>
			    <tr>
				<td><label>Phone:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_tel'); ?>"  value="<?php echo $org_tel;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Other Phone:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('org_tel2'); ?>"  value="<?php echo $org_tel2;?>" /></td>
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
				<tr><td><label>Twitter Username</label></td>
		<td>@<input type="text" size="13px"  name="<?php echo $this->get_field_name('org_twitter'); ?>"  value="<?php echo $org_twitter;?>" /></td>
		</tr>
				<tr><td><label>Facebook Profile</label></td>
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



//Load the Options Pag
 require_once ('hcard-admin.php');