<?php
/*
 * Page: hcard-admin
*/
?>
<style type="text/css">

.row {width:100%;}
.col-12 {width:100%;}
.col-9 {width:75%;}
.col-8 {width:66.66%;}
.col-6 {width:50%;}
.col-4 {width:33.33%;}
.col-3 {width:25%;}

[class*='col-'] {
  float: left;
}
.row:after {
  content: "";
  display: table;
  clear: both;
}

*, *:after, *:before {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

[class*='col-'] {
  padding-right: 20px;
}
[class*='col-']:last-of-type {
  padding-right: 0;
}
[class*='col-'] {
  padding-right: 20px;
}
[class*='col-']:last-of-type {
  padding-right: 0;
}
.grid-pad > [class*='col-']:last-of-type {
  padding-right: 20px;
} 
.white-bg {background-color:#ffffff; border:1px solid #BDBDBD;}
.box {padding:10px; margin-top:3px;
}
.btn {
  -webkit-box-shadow: 0px 1px 3px #666666;
  -moz-box-shadow: 0px 1px 3px #666666;
  box-shadow: 0px 1px 3px #666666;
  font-family: Arial;
  color: #ffffff;
  font-size: 16px;
  background: #3498db;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}

.btn:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
  text-decoration: none;
}
</style>
<p><h3>Hey, thanks for installing hCard Widget for WordPress.</h3>

</p>
<div class="row">
<div class="col-8">
<h2>Getting Started</h2>
Using hCard Widget is really easy. 
<ol>
<li>On your widgets page you'll see a new widget called <strong>hCard Widget</strong>. Both the Individual widget and the Organization widget are in there.</li>
<li>Drag it to the widget area where you want it to appear.</li>
<li>Click on the arrow to open the widget.  There will be a drop-down menu where you can select the widget (individual or organization) that you want to include.</li>
<li>Fill in the details.</li>
<li>Click save. You're done.</li>
</ol>
</div>
<div class="col-4 ">
<div class="box white-bg rss-widget">
<?php include_once( ABSPATH . WPINC . '/feed.php' );

$rss = fetch_feed('http://contexta.ca/category/updates/feed/');

if (!is_wp_error($rss)) :

    $maxitems = $rss->get_item_quantity(5); 

    $rss_items = $rss->get_items(0, $maxitems);

endif;
?>
<ul>

      <?php if ($maxitems == 0) : ?>

          <li>

            <?php _e('No items', 'simple-dir'); ?>

          </li>

      <?php else : ?>

          <?php foreach ($rss_items as $item) : ?>

              <?php $title = esc_html($item->get_title()); ?>

              <?php $date = date_i18n(get_option('date_format'), $item->get_date('U')); ?>

              <?php
                $description = str_replace(array("\n", "\r"), ' ', esc_attr(strip_tags( @html_entity_decode($item->get_description(), ENT_QUOTES, get_option('blog_charset')))));
                $description = wp_html_excerpt( $description, 50 );

                if ('[...]' == substr( $description, -5 ))
                {
                  $description = substr($description, 0, -5) . '[&hellip;
                  ]';
                }
                elseif ('[&hellip;]' != substr($description, -10 ))
                {
                  $description .= ' [&hellip;]';
                }                        

                $description = esc_html( $description );
              ?>

              <?php
                $link = $item->get_link();
                while (stristr($link, 'http') != $link)
                {
                  $link = substr($link, 1);
                }
                  $link = esc_url(strip_tags($link));
              ?>

              <li>

                <a class='rsswidget' href='<?php echo esc_url($link); ?>' title='<?php echo $description;?>'>
                  <?php echo esc_html($title); ?>
                </a>

                <span class="rss-date">
                  <?php echo esc_html($date); ?>
                </span>

                <div class="rss-summary">
                  <?php echo esc_html($description); ?>
                </div>

              </li>

          <?php endforeach; ?>

      <?php endif; ?>
      
  </ul>
</div>
<div class="box white-bg">
<h2>Looking for help?</h2>
 <p> Check out the <a href="http://contexta.ca/forums/" target="_blank">support forum.</a></p>

</div>
<div class="box white-bg">
<h3>Take a look at some of our other plugins:</h3>
<a href="http://wordpress.org/plugins/simple-directory" target="_blank">Simple Directory</a>
<a href="http://github.com/michaellautman/Piklist-Plugin-Builder" target="_blank">Piklist Plugin Builder</a>
</div>
</div>
</div>
<h2>Share The Love!</h2>
<a href="http://ctt.ec/SaNPB"><img src="http://clicktotweet.com/img/tweet-graphic-4.png" alt="Tweet: I'm using hCard Widget for WordPress! Check it out. http://ctt.ec/SaNPB+" /></a>


