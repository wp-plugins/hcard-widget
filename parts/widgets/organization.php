<?php
/*
Title: Organization hCard
Description: hCard for Organizations
*/
?>
<style><?php echo $settings['hcard_custom_css']; ?></style>
<?php echo $before_widget; ?>
 
<?php echo $before_title; ?>
 
<?php echo $settings['hcard_org_widget_title']; ?>!
 
<?php echo $after_title; ?>
<div itemscope itemtype="http://schema.org/Organization">
<span itemprop="brandName"><?php echo $settings['hcard_org_brandname']?></span>
 <span itemprop="legalName"><?php echo $settings['hcard_org_legalname']; ?></span>

<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
<span itemprop="streetAddress">
<?php echo $settings['hcard_org_street']; ?><br/>
<?php echo $settings['hcard_org_street2'];?>
</span>
<span itemprop="addressLocality"><?php echo $settings['hcard_org_city']; ?></span>, <span itemprop="addressRegion"><?php echo $settings['hcard_org_state']; ?></span>
<span itemprop="addressCountry"><?php echo $settings['hcard_org_country']; ?></span>
<span itemprop="postalCode"><?php echo $settings['hcard_org_postcode']; ?></span>
</div>
<span itemprop="telephone">Phone:<a href="tel:<?php echo $settings['hcard_org_phone'];?>"><?php echo $settings['hcard_org_phone']; ?></a></span>
<span itemprop="faxNumber">Fax:<?php echo $settings['hcard_org_fax']; ?></span>
<a href="mailto:<?php echo $settings['hcard_org_email']; ?>" itemprop="email"><?php echo $settings['hcard_org_email'];?></a><br/>
<a href="http://<?php echo $settings['hcard_org_url'];?> itemprop="url" target="_blank"><?php echo $settings['hcard_org_url'];?></a><br/>

<a href="https://twitter.com/<?php echo $settings['hcard_org_twitter'];?>" itemprop="url" rel="me" target="_blank">@<?php echo $settings['hcard_org_twitter']; ?></a>
<a href="<?php echo $settings['hcard_org_fb']; ?>" itemprop="url" rel="me" target="_blank">Follow Me On Facebook</a>
<a href="<?php echo $settings['hcard_org_gplus']; ?>" itemprop="url" rel="publisher" target="_blank">Find Me on Google+</a>
<a href="<?php echo $settings ['hcard_org_linkedin'];?>" itemprop="url" rel="me" target="_blank">Connect on LinkedIn</a>
 </div>
<?php echo $after_widget; ?>