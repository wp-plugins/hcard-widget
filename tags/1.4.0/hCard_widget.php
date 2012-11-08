<?php
/*
Plugin Name: hCard Widget
Plugin URI: http://lautman.ca/hcard-wordpress-widget/
Description: Outputs contact information in accordance with the hCard microformat standard (http://microformats.org
Version: 1.3.5
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
		return array('title','main_class' ,'name_class', 'name_block_class','name_url','given_name','middle_name','family_name'
		,'organization','organization_class','email','email_class','address_class','street_address','street_address_class',
		'locality_address','locality_address_class','region_address','region_address_class','postal_address','postal_address_class','country_address',
		'country_address_class','tel','tel_class','website','website_class','fax','fax_class', 'org_url');
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
					<a class="url" href="<?php echo $name_url;?>" itemprop="url"><span class="given-name <?php echo $given_name_class;?>" itemprop="givenName"> <?php echo $given_name;?></span>
					<span class="additional-name <?php echo $middle_name_class;?>" itemprop="additionalName"> <?php echo $middle_name;?></span>
					<span class="family-name <?php echo $family_name_class;?>" itemprop="familyName"> <?php echo $family_name;?></span></a>
				    </span>
				    <div class="org <?php echo $organization_class;?>" itemscope itemtype="http://schema.org/Organization"><a class="url"  href="<?php echo $org_url;?>" itemprop="url"> <?php echo $organization;?></a></div>
				    
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
				    <div class="tel <?php echo $tel_class;?>" itemprop="telephone"><?php echo $tel;?></div>
					<div class="tel <?php echo $fax_class;?>"><?php echo $fax;?></div>
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
			<tr>
			    <td><label>Class: </label></td>
			    <td><input type="text"  size="13px"  name="<?php echo $this->get_field_name('name_class'); ?>"  value="<?php echo $family_name_class;?>" /></td>
			</tr>
			<tr>
			<td><label>URL:</label></td>
			<td> <input type="text" size="13px"  name="<?php echo $this->get_field_name('name_url'); ?>"  value="<?php echo $name_url;?>" /></td>
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
			<tr>
			<td><label>URL:</label></td>
			<td><input type="text" size="13px" name="org_url" value="<?php echo $org_url;?>" /></td>
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
		return array('title','main_class' ,'name_class', 'name_block_class','name_url','given_name','middle_name','family_name'
		,'organization','organization_class','email','email_class','address_class','street_address','street_address_class',
		'locality_address','locality_address_class','region_address','region_address_class','postal_address','postal_address_class','country_address',
		'country_address_class','tel','tel_class','website','website_class','fax','fax_class', 'org_url','map_url');
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
				    
				    <div class="fn org <?php echo $organization_class;?>"><a class="url"  href="<?php echo $org_url;?>" itemprop="url"> <?php echo $organization;?></a></div>
				    
				    <?php if($email !== '') { ?><span class="email <?php echo $email_class;?>" itemprop="email"><a href="mailto:<?php echo $email;?>"><?php echo $email;?></a></span><br><?php } ?>
				    <a class="url <?php echo $website_class;?>" href="<?php echo $website;?>" itemprop="url"><?php echo $website;?></a>
				    <div class="adr <?php echo $address_class;?>" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
					<div class="street-address <?php echo $street_address_class;?>" itemprop="streetAddress"> <?php echo $street_address;?></div>
					<span class="locality <?php echo $locality_address_class;?>" itemprop="addressLocality"> <?php echo $locality_address;?></span>
					, 
					<span class="region <?php echo $region_address_class;?>" itemprop="addressRegion"> <?php echo $region_address;?></span><br>
					<span class="country-name <?php echo $country_address_class;?>" itemprop="addressCountry"> <?php echo $country_address;?></span>,
					<span class="postal-code <?php echo $postal_address_class;?>" itemprop="postalCode"> <?php echo $postal_address;?></span><br>
					<?php if($map_url !== '') {?>		
					<a href="<?php echo $map_url;?>" target="_blank" itemprop="map">MAP</a><?php } ?>
				    <div class="tel <?php echo $tel_class;?>" itemprop="telephone"><?php echo $tel;?></div>
					<div class="tel <?php echo $fax_class;?>" itemprop="faxNumber"><?php echo $fax;?></div>
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
			<tr>
			<td><label>URL:</label></td>
			<td><input type="text" size="13px" name="org_url" value="<?php echo $org_url;?>" /></td>
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
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('tel'); ?>"  value="<?php echo $tel;?>" /></td>
			    </tr>
			    <tr>
				<td><label>Class:</label></td>
				<td><input type="text" size="13px"  name="<?php echo $this->get_field_name('tel_class'); ?>"  value="<?php echo $tel_class;?>" /></td>
			    </tr>
			</table>
		    </td>
		</tr>
           </table>
<?php 
    } 
} // end class example_widget

add_action('widgets_init', create_function('', 'return register_widget("org_hCard_widget");'));
?>