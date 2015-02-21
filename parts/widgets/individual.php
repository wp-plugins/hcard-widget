<?php
/*
Title: Individual hCard
Description: hCard for Individuals
*/
?>
<style><?php echo $settings['hcard_custom_css']; ?></style>
<?php echo $before_widget; ?>
 
<?php echo $before_title; ?>
 
<?php echo $settings['hcard_ind_widget_title']; ?>!
 
<?php echo $after_title; ?>
<div itemscope itemtype="http://schema.org/Person">
 <span itemprop="name" class="hcard-ind-name"><?php echo $settings['hcard_ind_name']; ?></span>
 <span itemprop="jobTitle" class="hcard-ind-job"><?php echo $settings['hcard_ind_job']; ?></span>
<span itemprop="worksFor" class="hcard-ind-org"><?php echo $settings['hcard_ind_org']; ?></span>
<div itemprop="address" class="hcard-ind-address" itemscope itemtype="http://schema.org/PostalAddress">
<span itemprop="streetAddress">
<?php echo $settings['hcard_ind_street']; ?><br/>
<?php echo $settings['hcard_ind_street2'];?>
</span>
<span itemprop="addressLocality"><?php echo $settings['hcard_ind_city']; ?></span>, <span itemprop="addressRegion"><?php echo $settings['hcard_ind_state']; ?></span>
<span itemprop="addressCountry"><?php echo $settings['hcard_ind_country']; ?></span>
<span itemprop="postalCode"><?php echo $settings['hcard_ind_postcode']; ?></span>
</div>
<?php if(empty($settings['hcard_ind_website'])) {} else { ?><a href="<?php echo $settings['hcard_ind_website'];?>" target="_blank" ><?php echo $settings['hcard_ind_website'];?></a><?php } ?>
<?php if ($settings['hcard_ind_phone'] != '') {?><span itemprop="telephone" class="hcard-ind-phone">Phone:<a href="tel:<?php echo $settings['hcard_ind_phone']; ?>"><?php echo $settings['hcard_ind_phone']; ?></a></span><?php }?>
<?php if ($settings['hcard_ind_fax'] != '') {?><span itemprop="faxNumber" class="hcard-ind-fax">Fax:<?php echo $settings['hcard_ind_fax']; ?></span><?php }?>
<a href="mailto:<?php echo $settings['hcard_ind_email']; ?>" itemprop="email" class="hcard-ind-email"><?php echo $settings['hcard_ind_email'];?></a><br/>
	
<?php if ($settings['hcard_ind_twitter'] != '') {?><a href="https://twitter.com/<?php echo $settings['hcard_ind_twitter'];?>" itemprop="url" rel="me" target="_blank" class="hcard-ind-twitter">@<?php echo $settings['hcard_ind_twitter']; ?></a><?php } ?>
<?php if ($settings['hcard_ind_fb'] != '') {?><a href="<?php echo $settings['hcard_ind_fb']; ?>" itemprop="url" rel="me" target="_blank" class="hcard-ind-fb">Follow Me On Facebook</a><?php }?>
<?php if ($settings['hcard_ind_gplus'] != '') {?><a href="<?php echo $settings['hcard_ind_gplus']; ?>" itemprop="url" rel="author" target="_blank" class="hcard-ind-gplus">Find Me on Google+</a><?php }?>
<?php if (empty($settings['hcard_ind_linkedin'] )) { } else {?><a href="<?php echo $settings ['hcard_ind_linkedin'];?>" itemprop="url" rel="me" target="_blank" class="hcard-ind-linkedin">Connect on LinkedIn</a><?php } ?>
 </div>
<?php echo $after_widget; ?>