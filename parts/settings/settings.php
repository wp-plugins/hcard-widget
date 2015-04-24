<?php


/*


Title: Customize your hCard Widget


Setting: hcard_widget_settings


Tab Order: 1


Order: 30


*/





 piklist('field', array(


    'type' => 'textarea'


    ,'field' => 'hcard_custom_css'


    ,'label' => __('Custom CSS','hcard-widget')


    ,'description' => ''


    ,'help' => __('You can customize the look of your widgets with CSS.','hcard-widget')
				  


    ,'value' => ''


	,'columns' => '12'


    ,'attributes' => array(


      'class' => 'text'


    )


  ));