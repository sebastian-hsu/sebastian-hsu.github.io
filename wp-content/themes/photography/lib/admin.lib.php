<?php
photography_themegoods_action();
$is_verified_envato_purchase_code = false;

//Get verified purchase code data
$pp_verified_envato_photography = get_option("pp_verified_envato_photography");
if(!empty($pp_verified_envato_photography))
{
	$is_verified_envato_purchase_code = true;
}

$customizer_styling_arr = array( 
	array('id'	=>	'bold_white', 'title' => 'Bold White Demo'),
	array('id'	=>	'bold_black', 'title' => 'Bold Black Demo'),
	array('id'	=>	'white1', 'title' => 'White Demo: Left Align Menu'),
	array('id'	=>	'white2', 'title' => 'White Demo: Center Align Menu'),
	array('id'	=>	'white3', 'title' => 'White Demo: With Top Bar'),
	array('id'	=>	'white4', 'title' => 'White Demo: Fullscreen Menu'),
	array('id'	=>	'white5', 'title' => 'White Demo: Left Vertical Menu'),
	array('id'	=>	'white6', 'title' => 'White Demo: Black Frame'),
	array('id'	=>	'white8', 'title' => 'White Demo: Boxed Layout'),
	array('id'	=>	'dark1', 'title' => 'Dark Demo: Left Align Menu'),
	array('id'	=>	'dark2', 'title' => 'Dark Demo: Center Align Menu'),
	array('id'	=>	'dark3', 'title' => 'Dark Demo: With Top Bar'),
	array('id'	=>	'dark4', 'title' => 'Dark Demo: Fullscreen Menu'),
	array('id'	=>	'dark5', 'title' => 'Dark Demo: Left Vertical Menu'),
	array('id'	=>	'dark6', 'title' => 'Dark Demo: White Frame'),
	array('id'	=>	'dark8', 'title' => 'Dark Demo: Boxed Layout'),
);

$customizer_styling_html = '';

//if verified envato purchase code
if($is_verified_envato_purchase_code)
{
	$customizer_styling_html.= '
		<div class="tg_notice">
			<span class="dashicons dashicons-warning"></span>
			Activating demo styling will replace all current theme customizer options.
		</div><br style="clear:both;"/>
		<ul id="get_styling_content" class="demo_list">';
	
	foreach($customizer_styling_arr as $key => $customizer_styling)
	{
		$last_class = '';
		if(($key+1)%3 == 0)
		{
			$last_class = 'last';
		}
		
		$customizer_styling_html.= '<li class="'.$last_class.'" data-styling="'.$customizer_styling['id'].'">
			    	<div class="item_content_wrapper">
			    		<div class="item_content">
			    			<div class="item_thumb">
			    				<img src="'.get_template_directory_uri().'/cache/demos/customizer/screenshots/'.$customizer_styling['id'].'.jpg" alt=""/></div>
			    			<div class="item_content">
			    				<div class="title"><strong>'.$customizer_styling['title'].'</strong></div>
						    	<div class="import">
							    	<input data-styling="'.$customizer_styling['id'].'" type="button" value="Activate" class="pp_get_styling_button button-primary"/>
							    </div>
						    </div>
					    </div>
				    </div>
			    </li>';
	}
	
	$customizer_styling_html.= '</ul>
	<div class="styling_message"><div class="import_message_success"><span class="tg_loading dashicons dashicons-update"></span>Data is being imported please be patient, don\'t navigate away from this page</div></div>';
}
else
{
	$customizer_styling_html.= '
		<div class="tg_notice">
			<span class="dashicons dashicons-warning" style="color:#FF3B30"></span> 
			<span style="color:#FF3B30">'.THEMENAME.' Demos can only be imported with a valid Envato Token</span><br/><br/>
			Please visit <a href="javascript:jQuery(\'#pp_panel_registration_a\').trigger(\'click\');">Product Registration page</a> and enter a valid Envato Token to import the full '.THEMENAME.' demos and single pages through Content Builder.
		</div>';
}

//Begin Create demo import options
$demo_import_options_arr = array( 
	array('id'	=>	'demo1', 'title' => 'Demo 1', 'demo' => 1),
	array('id'	=>	'bold_white', 'title' => 'Bold White Demo', 'demo' => 4),
	array('id'	=>	'bold_black', 'title' => 'Bold Black Demo', 'demo' => 3),
);
//End Create demo import options

$demo_import_options_html = '';

//if verified envato purchase code
if($is_verified_envato_purchase_code)
{
	$demo_import_options_html.= '<div class="tg_notice">
			<span class="dashicons dashicons-warning"></span>
			Importing a demo will create pages, posts, images, theme settings, widgets, sliders.<br/>Please make sure you install and activate all required plugins before importing any demo.
		</div><br style="clear:both;"/>
		
		<ul id="import_demo_content" class="demo_list">';
	
	foreach($demo_import_options_arr as $key => $demo_import_option)
	{
		$last_class = '';
		if(($key+1)%3 == 0)
		{
			$last_class = 'last';
		}
		
		$demo_url = 'http://themes.themegoods.com/photography/demo'.$demo_import_option['demo'].'/';
		
	$demo_import_options_html.= '<li class="'.$last_class.'" data-demo="'.$demo_import_option['demo'].'">
			    	<div class="item_content_wrapper">
			    		<div class="item_content">
			    			<div class="item_thumb">
			    				<a class="preview_wrapper" href="'.esc_url($demo_url).'" target="_blank">Preview</a>
			    				<img src="'.get_template_directory_uri().'/cache/demos/xml/demo'.$demo_import_option['demo'].'/'.$demo_import_option['demo'].'.jpg" alt=""/></div>
			    			<div class="item_content">
			    				<div class="title"><strong>'.$demo_import_option['title'].'</strong></div>
						    	<div class="import">
							    	<input data-demo="'.$demo_import_option['demo'].'" type="button" value="Import" class="pp_import_content_button upload_btn button-primary"/>
							    </div>
						    </div>
					    </div>
				    </div>
			    </li>';
	}
	
	$demo_import_options_html.= '</ul>
		<div class="import_message"><div class="import_message_success"><span class="tg_loading dashicons dashicons-update"></span>Data is being imported please be patient, don\'t navigate away from this page</div></div>';
}
else
{
	$demo_import_options_html.= '
		<div class="tg_notice">
			<span class="dashicons dashicons-warning" style="color:#FF3B30"></span> 
			<span style="color:#FF3B30">'.THEMENAME.' Demos can only be imported with a valid Envato Token</span><br/><br/>
			Please visit <a href="javascript:jQuery(\'#pp_panel_registration_a\').trigger(\'click\');">Product Registration page</a> and enter a valid Envato Token to import the full '.THEMENAME.' demos and single pages through Content Builder.
		</div>';
}

/*
	Begin creating admin options
*/

$getting_started_html = '<div class="one_half">
		<div class="step_icon">
			<a href="'.admin_url("themes.php?page=install-required-plugins").'">
				<span class="dashicons dashicons-admin-plugins"></span>
				<div class="step_title">Install Plugins</div>
			</a>
		</div>
		<div class="step_info">
			Theme has required and recommended plugins in order to build your website using layouts you saw on our demo site. We recommend you to install all plugins first.
		</div>
	</div>
	
	<div class="one_half last">
		<div class="step_icon">
			<a href="'.admin_url("post-new.php?post_type=page").'">
				<span class="dashicons dashicons-format-aside"></span>
				<div class="step_title">Create Page</div>
			</a>
		</div>
		<div class="step_info">
			'.THEMENAME.' support standard WordPress page option. You can also use our live content builder to create and organise page contents.
		</div>
	</div>';

//Check if Photography plugin is installed	
$photography_custom_post = 'photography-custom-post/photography-custom-post.php';

if( !function_exists('is_plugin_active') ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

$photography_custom_post_activated = is_plugin_active($photography_custom_post);
if($photography_custom_post_activated)
{
	$getting_started_html.= '<div class="one_half">
		<div class="step_icon">
			<a href="'.admin_url("post-new.php?post_type=galleries").'">
				<span class="dashicons dashicons-format-gallery"></span>
				<div class="step_title">Create Gallery</div>
			</a>
		</div>
		<div class="step_info">
			'.THEMENAME.' provide advanced gallery option. You can use bulk images uploader, select from various gallery templates option.
		</div>
	</div>
	
	<div class="one_half last">
		<div class="step_icon">
			<a href="'.admin_url("post-new.php?post_type=portfolios").'">
				<span class="dashicons dashicons-media-document"></span>
				<div class="step_title">Create Portfolio</div>
			</a>
		</div>
		<div class="step_info">
			'.THEMENAME.' provide advanced portfolio option. Portfolio is using for other portfolio content type for example text, HTML or video.
		</div>
	</div>';
}
	
$getting_started_html.='<div class="one_half">
		<div class="step_icon">
			<a href="'.admin_url("customize.php").'">
				<span class="dashicons dashicons-admin-settings"></span>
				<div class="step_title">Customize Theme</div>
			</a>
		</div>
		<div class="step_info">
			Start customize theme\'s layouts, typography, elements colors using WordPress customize and see your changes in live preview instantly.
		</div>
	</div>
	
	<div class="one_half last">
		<div class="step_icon">
			<a href="javascript:;" onclick="jQuery(\'#pp_panel_demo-content_a\').trigger(\'click\');">
				<span class="dashicons dashicons-download"></span>
				<div class="step_title">Import Demo</div>
			</a>
		</div>
		<div class="step_info">
			Upload demo content from our demo site. We recommend you to install all recommended plugins before importing demo contents.
		</div>
	</div>';
	
if($is_verified_envato_purchase_code)
{
	
	$getting_started_html.='
	<br style="clear:both;"/>
	
	<div style="height:30px"></div>
	
	<h1>Support</h1>
	<div class="getting_started_desc">To access our support portal. You first must find your purchased code.</div>
	<div style="height:40px"></div>
	<div class="one_half">
		<div class="step_icon">
			<a href="https://themegoods.ticksy.com/submit/" target="_blank">
				<span class="dashicons dashicons-testimonial"></span>
				<div class="step_title">Submit a Ticket</div>
			</a>
		</div>
		<div class="step_info">
			We offer excellent support through our ticket system. Please make sure you prepare your purchased code first to access our services.
		</div>
	</div>
	
	<div class="one_half last">
		<div class="step_icon">
			<a href="http://themes.themegoods.com/photography/doc" target="_blank">
				<span class="dashicons dashicons-book-alt"></span>
				<div class="step_title">Theme Document</div>
			</a>
		</div>
		<div class="step_info">
			This is the place to go find all reference aspects of theme functionalities. Our online documentation is resource for you to start using theme.
		</div>
	</div>
';
}

//Get product registration

//if verified envato purchase code
$check_icon = '';
$verification_desc = 'Thank you for choosing '.THEMENAME.'. Your product must be registered to receive many advantage features ex. demos import and support. We are sorry about this extra step but we built the activation system to prevent mass piracy of our themes. This will help us to better serve our paying customers.';
if($is_verified_envato_purchase_code)
{
	$check_icon = '<span class="tg_valid dashicons dashicons-yes"></span>';
	$verification_desc = 'Congratulations! Your product is registered now.';
}
$pp_envato_personal_token = get_option('pp_envato_personal_token');

$product_registration_html ='
		<h1>Product Registration</h1>
		<div class="getting_started_desc">'.$verification_desc.'</div>
		<br style="clear:both;"/>
		
		<div style="height:10px"></div>
		
		<label for="pp_envato_personal_token">'.$check_icon.'Your Envato Token</label>
		<small class="description">Please enter your Envato Token.</small>
		
		<input name="pp_envato_personal_token" id="pp_envato_personal_token" type="text" value="'.esc_attr($pp_envato_personal_token).'"/>
	';
	
if(isset($_GET['action']) && $_GET['action'] == 'invalid-purchase')
{
	$product_registration_html.='<br style="clear:both;"/><div style="height:20px"></div><div class="tg_error"><span class="dashicons dashicons-warning"></span> We can\'t find your purchase of '.THEMENAME.' theme. Please make sure you enter correct Envato Token. If you are sure you enter correct one. <a href="https://themegoods.ticksy.com" target="_blank">Please open a ticket</a> to us so our support staff can help you. Thank you very much.</div>
	
	<br style="clear:both;"/>
	
	<div style="height:10px"></div>';
}

if(!$is_verified_envato_purchase_code)
{
	$product_registration_html.='
		<br style="clear:both;"/>
		<div style="height:30px"></div>
		<h1>How to get your Envato Token</h1>
		<div style="height:5px"></div>
		<ol>
		 <li>Click on this <a href="https://build.envato.com/create-token/?purchase:download=t&amp;purchase:verify=t&amp;purchase:list=t" target="_blank">Generate A Personal Token</a> link. <strong>IMPORTANT:</strong> You must be logged into the same Themeforest account that purchased '.THEMENAME.'. If you are not logged in, you will be directed to login then directed back to the Create A Token Page.</li>
		 <li>Enter a name for your token, then check the boxes for <strong>View Your Envato Account Username, Download Your Purchased Items, List Purchases You\'ve Made</strong> and <strong>Verify Purchases You\'ve Made</strong> from the permissions needed section. Check the box to agree to the terms and conditions, then click the <strong>Create Token button</strong></li>
								<li>A new page will load with a token number in a box. Copy the token number then come back to this registration page and paste it into the "Your Envato Token" field above and click the <strong>Save</strong> button.</li>
								<li>You will see a green check mark for success, or a failure message if something went wrong. If it failed, please make sure you followed the steps above correctly.</li>
		</ol>
	';
}

//Check if Envato Market plugin is installed	
$envato_market = 'envato-market/envato-market.php';
$envato_market_activated = is_plugin_active($envato_market);

if($is_verified_envato_purchase_code && !$envato_market_activated)
{
	$product_registration_html.='<br style="clear:both;"/><div style="height:40px"></div>
	<h1>Auto Update</h1>
	<div class="getting_started_desc">To enable auto update feature. You first must <a href="'.admin_url('themes.php?page=install-required-plugins').'">install Envato Market plugin</a> and enter your purchase code there. <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">Find your purchase code</a></div>
	<br style="clear:both;"/>
	
	<div style="height:10px"></div>
	';
}

//Get system info
$wordpress_multisite = '-';
if(is_multisite())
{
	$wordpress_multisite = '<span class="dashicons dashicons-yes"></span>';
}

$wordpress_debug = '-';
if(WP_DEBUG)
{
	$wordpress_debug = '<span class="dashicons dashicons-yes"></span>';
}

//Get memory_limit
$memory_limit = ini_get('memory_limit');
$memory_limit_class = '';
$memory_limit_text = '';
if(intval($memory_limit) < 128)
{
    $memory_limit_class = 'tg_error';
    $has_error = 1;
    $memory_limit_text = '*RECOMMENDED 128M';
}
$memory_limit_text = '<div class="'.$memory_limit_class.'">'.$memory_limit.' '.$memory_limit_text.'</div>';

//Get post_max_size
$post_max_size = ini_get('post_max_size');
$post_max_size_class = '';
$post_max_size_text = '';
if(intval($post_max_size) < 32)
{
    $post_max_size_class = 'tg_error';
    $has_error = 1;
    $post_max_size_text = '*RECOMMENDED 32M';
}
$post_max_size_text = '<div class="'.$post_max_size_class.'">'.$post_max_size.' '.$post_max_size_text.'</div>';

//Get max_execution_time
$max_execution_time = ini_get('max_execution_time');
$max_execution_time_class = '';
$max_execution_time_text = '';
if($max_execution_time < 180)
{
    $max_execution_time_class = 'tg_error';
    $has_error = 1;
    $max_execution_time_text = '*RECOMMENDED 180';
}
$max_execution_time_text = '<div class="'.$max_execution_time_class.'">'.$max_execution_time.' '.$max_execution_time_text.'</div>';

//Get max_input_vars
$max_input_vars = ini_get('max_input_vars');
$max_input_vars_class = '';
$max_input_vars_text = '';
if(intval($max_input_vars) < 2000)
{
    $max_input_vars_class = 'tg_error';
    $has_error = 1;
    $max_input_vars_text = '*RECOMMENDED 2000';
}
$max_input_vars_text = '<div class="'.$max_input_vars_class.'">'.$max_input_vars.' '.$max_input_vars_text.'</div>';

//Get upload_max_filesize
$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_filesize_class = '';
$upload_max_filesize_text = '';
if(intval($upload_max_filesize) < 32)
{
    $upload_max_filesize_class = 'tg_error';
    $has_error = 1;
    $upload_max_filesize_text = '*RECOMMENDED 32M';
}
$upload_max_filesize_text = '<div class="'.$upload_max_filesize_class.'">'.$upload_max_filesize.' '.$upload_max_filesize_text.'</div>';

//Get GD library version
$php_gd_arr = gd_info();

$wordpress_child_theme = '-';
if(is_child_theme())
{
	$wordpress_child_theme = '<span class="dashicons dashicons-yes"></span>';
}

$system_info_html = '<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="3">WordPress Environment</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="title">Home URL:</td>
					<td class="help"><a href="javascript" title="The URL of your site\'s homepage." class="tooltipster">[?]</a></td>
					<td class="value">'.home_url('/').'</td>
				</tr>
				<tr>
					<td class="title">Site URL:</td>
					<td class="help"><a href="javascript" title="The root URL of your site." class="tooltipster">[?]</a></td>
					<td class="value">'.site_url('/').'</td>
				</tr>
				<tr>
					<td class="title">WP Version:</td>
					<td class="help"><a href="javascript" title="The version of WordPress installed on your site." class="tooltipster">[?]</a></td>
					<td class="value">'.get_bloginfo('version').'</td>
				</tr>
				<tr>
					<td class="title">WP Multisite:</td>
					<td class="help"><a href="javascript" title="Whether or not you have WordPress Multisite enabled." class="tooltipster">[?]</a></td>
					<td class="value">'.$wordpress_multisite.'</td>
				</tr>
				<tr>
					<td class="title">WP Memory Limit:</td>
					<td class="help"><a href="javascript" title="The maximum amount of memory (RAM) that your site can use at one time." class="tooltipster">[?]</a></td>
					<td class="value">'.$memory_limit_text.'</td>
				</tr>
				<tr>
					<td class="title">WP Debug Mode:</td>
					<td class="help"><a href="javascript" title="Displays whether or not WordPress is in Debug Mode." class="tooltipster">[?]</a></td>
					<td class="value">'.$wordpress_debug.'</td>
				</tr>
				<tr>
					<td class="title">Language:</td>
					<td class="help"><a href="javascript" title="The current language used by WordPress. Default = English" class="tooltipster">[?]</a></td>
					<td class="value">'.get_bloginfo('language').'</td>
				</tr>
			</tbody>
		</table>
		
		<div style="height:30px"></div>
		
		<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="3">Server Environment</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="title">Server Info:</td>
					<td class="help"><a href="javascript" title="Information about the web server that is currently hosting your site." class="tooltipster">[?]</a></td>
					<td class="value">'.$_SERVER['SERVER_SOFTWARE'].'</td>
				</tr>
				<tr>
					<td class="title">PHP Version:</td>
					<td class="help"><a href="javascript" title="The version of PHP installed on your hosting server." class="tooltipster">[?]</a></td>
					<td class="value">'.phpversion().'</td>
				</tr>
				<tr>
					<td class="title">PHP Post Max Size:</td>
					<td class="help"><a href="javascript" title="The largest file size that can be contained in one post." class="tooltipster">[?]</a></td>
					<td class="value">'.$post_max_size_text.'</td>
				</tr>
				<tr>
					<td class="title">PHP Time Limit:</td>
					<td class="help"><a href="javascript" title="The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)" class="tooltipster">[?]</a></td>
					<td class="value">'.$max_execution_time_text.'</td>
				</tr>
				<tr>
					<td class="title">PHP Max Input Vars:</td>
					<td class="help"><a href="javascript" title="The maximum number of variables your server can use for a single function to avoid overloads." class="tooltipster">[?]</a></td>
					<td class="value">'.$max_input_vars_text.'</td>
				</tr>
				<tr>
					<td class="title">Max Upload Size:</td>
					<td class="help"><a href="javascript" title="The largest filesize that can be uploaded to your WordPress installation." class="tooltipster">[?]</a></td>
					<td class="value">'.$upload_max_filesize_text.'</td>
				</tr>
				<tr>
					<td class="title">GD Library:</td>
					<td class="help"><a href="javascript" title="This library help resizing images and improve site loading speed" class="tooltipster">[?]</a></td>
					<td class="value">'.$php_gd_arr['GD Version'].'</td>
				</tr>
			</tbody>
		</table>
		
		<p>
			<strong>*Notice: Please note that all recommended value suggested for above table is only if you want to use DEMO CONTENT IMPORTER feature only. If you won\'t use importer, you can ignore them.</strong>
		</p>
		
		<div style="height:20px"></div>
		
		<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="3">Theme</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="title">Name:</td>
					<td class="help"><a href="javascript" title="The name of the current active theme." class="tooltipster">[?]</a></td>
					<td class="value">'.THEMENAME.'</td>
				</tr>
				<tr>
					<td class="title">Version:</td>
					<td class="help"><a href="javascript" title="The installed version of the current active theme." class="tooltipster">[?]</a></td>
					<td class="value">'.THEMEVERSION.'</td>
				</tr>
				<tr>
					<td class="title">Child Theme:</td>
					<td class="help"><a href="javascript" title="Displays whether or not the current theme is a child theme." class="tooltipster">[?]</a></td>
					<td class="value">'.$wordpress_child_theme.'</td>
				</tr>
			</tbody>
		</table>';

/*
	Begin creating admin options
*/

$api_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

global $photograhy_options;

$photograhy_options = array (
 
//Begin admin header
array( 
		"name" => THEMENAME." Options",
		"type" => "title"
),
//End admin header

//Begin second tab "Home"
array( 	"name" => "Home",
		"type" => "section",
		"icon" => "dashicons-admin-home",	
),
array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => SHORTNAME."_home",
	"type" => "html",
	"html" => '
	<h1>Getting Started</h1>
	<div class="getting_started_desc">Welcome to '.THEMENAME.' theme. '.THEMENAME.' is now installed and ready to use! Read below for additional informations. We hope you enjoy using the theme!</div>
	<div style="height:40px"></div>
	'.$getting_started_html.'
	',
),

array( "type" => "close"),
//End second tab "Home"


//Begin second tab "Registration"
array( 	"name" => "Registration",
		"type" => "section",
		"icon" => "dashicons-admin-network",	
),
array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => SHORTNAME."_registration",
	"type" => "html",
	"html" => $product_registration_html,
),

array( "type" => "close"),
//End second tab "Registration"


//Begin second tab "General"
array( 	"name" => "General",
		"type" => "section",
		"icon" => "dashicons-admin-generic",	
),
array( "type" => "open"),

array( "name" => "<h2>Contact Form Settings</h2>Your email address",
	"desc" => "Enter which email address will be sent from contact form",
	"id" => SHORTNAME."_contact_email",
	"type" => "text",
	"validation" => "email",
	"std" => ""

),
array( "name" => "Select and sort contents on your contact page. Use fields you want to show on your contact form",
	"sort_title" => "Contact Form Manager",
	"desc" => "",
	"id" => SHORTNAME."_contact_form",
	"type" => "sortable",
	"options" => array(
		0 => 'Empty field',
		1 => 'Name',
		2 => 'Email',
		3 => 'Message',
		4 => 'Address',
		5 => 'Phone',
		6 => 'Mobile',
		7 => 'Company Name',
		8 => 'Country',
	),
	"options_disable" => array(1, 2, 3),
	"std" => ''
),

array( "name" => "<h2>Google Maps Setting</h2>API Key",
	"desc" => "Enter Google Maps API Key <a href=\"https://themegoods.ticksy.com/article/7785/\" target=\"_blank\">How to get API Key</a>",
	"id" => SHORTNAME."_googlemap_api_key",
	"type" => "text",
	"std" => ""
),

array( "name" => "Custom Google Maps Style",
	"desc" => "Enter javascript style array of map. You can get sample one from <a href=\"https://snazzymaps.com\" target=\"_blank\">Snazzy Maps</a>",
	"id" => SHORTNAME."_googlemap_style",
	"type" => "textarea",
	"std" => ""
),

array( "name" => "<h2>Captcha Settings</h2>Enable Captcha",
	"desc" => "If you enable this option, contact page will display captcha image to prevent possible spam",
	"id" => SHORTNAME."_contact_enable_captcha",
	"type" => "iphone_checkboxes",
	"std" => 1,
),

array( "name" => "<h2>Custom Sidebar Settings</h2>Add a new sidebar",
	"desc" => "Enter sidebar name",
	"id" => SHORTNAME."_sidebar0",
	"type" => "text",
	"validation" => "text",
	"std" => "",
),

array( "type" => "close"),
//End second tab "General"


//Begin second tab "Styling"
array( "name" => "Styling",
	"type" => "section",
	"icon" => "dashicons-art",
),

array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => SHORTNAME."_get_styling_button",
	"type" => "html",
	"html" => $customizer_styling_html,
),
 
array( "type" => "close"),


//Begin second tab "Images"
array( "name" => "Images",
	"type" => "section",
	"icon" => "dashicons-format-image",
),

array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => SHORTNAME."_gallery_image_dimensions_notice",
	"type" => "html",
	"html" => '<div class="tg_notice"><span class="dashicons dashicons-warning"></span>These settings affect the display and dimensions of images in your gallery, blog pages – the display on the front-end will still be affected by CSS styles. After changing these settings you may need to <a href="https://wordpress.org/plugins/force-regenerate-thumbnails/" target="_blank">regenerate your thumbnails</a></div>',
),
array( "name" => "<h2>Gallery Grid Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter gallery grid image width(in pixels).",
	"id" => SHORTNAME."_gallery_grid_image_width",
	"type" => "text",
	"std" => "705",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter gallery grid image height(in pixels). Please enter 9999 for auto height.",
	"id" => SHORTNAME."_gallery_grid_image_height",
	"type" => "text",
	"std" => "529",
	"validation" => "text",
),
array( "name" => "<h2>Gallery Grid Large Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter gallery grid large image width(in pixels).",
	"id" => SHORTNAME."_gallery_grid_large_image_width",
	"type" => "text",
	"std" => "987",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter gallery grid large image height(in pixels). Please enter 9999 for auto height.",
	"id" => SHORTNAME."_gallery_grid_large_image_height",
	"type" => "text",
	"std" => "740",
	"validation" => "text",
),
array( "name" => "<h2>Gallery Masonry Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter gallery masonry image width(in pixels).",
	"id" => SHORTNAME."_gallery_masonry_image_width",
	"type" => "text",
	"std" => "705",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter gallery masonry image height(in pixels). Please enter 9999 for auto height.",
	"id" => SHORTNAME."_gallery_masonry_image_height",
	"type" => "text",
	"std" => "9999",
	"validation" => "text",
),
array( "name" => "<h2>Gallery Striped Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter gallery striped image width(in pixels).",
	"id" => SHORTNAME."_gallery_striped_image_width",
	"type" => "text",
	"std" => "270",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter gallery striped image height(in pixels). Please enter 9999 for auto height.",
	"id" => SHORTNAME."_gallery_striped_image_height",
	"type" => "text",
	"std" => "690",
	"validation" => "text",
),
array( "name" => "<h2>Blog Featured Image Dimensions Settings</h2>Image Width",
	"desc" => "Enter blog featured image width(in pixels).",
	"id" => SHORTNAME."_blog_image_width",
	"type" => "text",
	"std" => "960",
	"validation" => "text",
),
array( "name" => "Image Height",
	"desc" => "Enter blog featured image height(in pixels). Please enter 9999 for auto height.",
	"id" => SHORTNAME."_blog_image_height",
	"type" => "text",
	"std" => "636",
	"validation" => "text",
),
 
array( "type" => "close"),


//Begin fifth tab "Social Profiles"
array( 	"name" => "Social-Profiles",
		"type" => "section",
		"icon" => "dashicons-facebook",
),
array( "type" => "open"),
	
array( "name" => "<h2>Facebook Sharing Settings</h2>Disable Theme Facebook Open Graph Tags",
	"desc" => "If you are using other 3rd party plugin for handling Facebook Open Graph Tags. You can disable this option to avoid conflict with theme.",
	"id" => SHORTNAME."_facebook_theme_graph",
	"type" => "iphone_checkboxes",
	"std" => 1,
),
array( "name" => "<h2>Accounts Settings</h2>Facebook page URL",
	"desc" => "Enter full Facebook page URL",
	"id" => SHORTNAME."_facebook_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Twitter Username",
	"desc" => "Enter Twitter username",
	"id" => SHORTNAME."_twitter_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Google Plus URL",
	"desc" => "Enter Google Plus URL",
	"id" => SHORTNAME."_google_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Flickr Username",
	"desc" => "Enter Flickr username",
	"id" => SHORTNAME."_flickr_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Youtube Profile URL",
	"desc" => "Enter Youtube Profile URL",
	"id" => SHORTNAME."_youtube_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Vimeo Username",
	"desc" => "Enter Vimeo username",
	"id" => SHORTNAME."_vimeo_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Tumblr Username",
	"desc" => "Enter Tumblr username",
	"id" => SHORTNAME."_tumblr_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Dribbble Username",
	"desc" => "Enter Dribbble username",
	"id" => SHORTNAME."_dribbble_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Linkedin URL",
	"desc" => "Enter full Linkedin URL",
	"id" => SHORTNAME."_linkedin_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Pinterest Username",
	"desc" => "Enter Pinterest username",
	"id" => SHORTNAME."_pinterest_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Instagram Username",
	"desc" => "Enter Instagram username",
	"id" => SHORTNAME."_instagram_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Behance Username",
	"desc" => "Enter Behance username",
	"id" => SHORTNAME."_behance_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "500px Profile URL",
	"desc" => "Enter 500px Profile URL",
	"id" => SHORTNAME."_500px_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "<h2>Photo Stream</h2>Select photo stream photo source. It displays before footer area",
	"desc" => "",
	"id" => SHORTNAME."_photostream",
	"type" => "select",
	"options" => array(
		'' => 'Disable Photo Stream',
		'instagram' => 'Instagram',
		'flickr' => 'Flickr',
	),
	"std" => ''
),
array( "name" => "Instagram Access Token<br/><a href=\"https://instagram.com/oauth/authorize/?client_id=3a81a9fa2a064751b8c31385b91cc25c&scope=basic+public_content&redirect_uri=https://smashballoon.com/instagram-feed/instagram-token-plugin/?return_uri=".admin_url("themes.php?page=functions.php")."&response_type=token\" >Get Access Token here</a>",
	"desc" => "Enter Instagram Access Token",
	"id" => SHORTNAME."_instagram_access_token",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),

array( "name" => "Flickr ID <a href=\"http://idgettr.com/\" target=\"_blank\">Find your Flickr ID here</a>",
	"desc" => "Enter Flickr ID",
	"id" => SHORTNAME."_flickr_id",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "type" => "close"),

//End fifth tab "Social Profiles"


//Begin second tab "Script"
array( "name" => "Script",
	"type" => "section",
	"icon" => "dashicons-format-aside",
),

array( "type" => "open"),

array( "name" => "<h2>CSS Settings</h2>Custom CSS for desktop",
	"desc" => "You can add your custom CSS here",
	"id" => SHORTNAME."_custom_css",
	"type" => "textarea",
	"std" => "",
	'validation' => '',
),

array( "name" => "Custom CSS for iPad Portrait View",
	"desc" => "You can add your custom CSS here",
	"id" => SHORTNAME."_custom_css_tablet_portrait",
	"type" => "textarea",
	"std" => "",
	'validation' => '',
),

array( "name" => "Custom CSS for iPhone Landscape View",
	"desc" => "You can add your custom CSS here",
	"id" => SHORTNAME."_custom_css_mobile_landscape",
	"type" => "textarea",
	"std" => "",
	'validation' => '',
),

array( "name" => "Custom CSS for iPhone Portrait View",
	"desc" => "You can add your custom CSS here",
	"id" => SHORTNAME."_custom_css_mobile_portrait",
	"type" => "textarea",
	"std" => "",
	'validation' => '',
),

array( "name" => "<h2>Optimisation Settings</h2>Combine and compress theme's CSS",
	"desc" => "Combine and compress all CSS files to one. Help reduce page load time. NOTE: If you enable child theme CSS compression is not support",
	"id" => SHORTNAME."_advance_combine_css",
	"type" => "iphone_checkboxes",
	"std" => 1
),

array( "name" => "Combine and compress theme's javascript",
	"desc" => "Combine and compress all javascript files to one. Help reduce page load time",
	"id" => SHORTNAME."_advance_combine_js",
	"type" => "iphone_checkboxes",
	"std" => 1
),

array( "name" => "Disable WordPress heartbeat API",
	"desc" => "Check this option to disable WordPress heartbeat API to reduce server load and improving site loading speed",
	"id" => SHORTNAME."_advance_wp_heartbeat",
	"type" => "iphone_checkboxes",
	"std" => 0
),

array( "name" => "<h2>Cache Settings</h2>Clear Cache",
	"desc" => "Try to clear cache when you enable javascript and CSS compression and theme went wrong",
	"id" => SHORTNAME."_advance_clear_cache",
	"type" => "html",
	"html" => '<br/><a id="'.SHORTNAME.'_advance_clear_cache" href="'.$api_url.'" class="button">Click here to start clearing cache files</a>',
),
 
array( "type" => "close"),

//Begin second tab "System"
array( 	"name" => "System",
		"type" => "section",
		"icon" => "dashicons-dashboard",	
),
array( "type" => "open"),

array( "name" => "<h2>System Information</h2>",
	"desc" => "",
	"id" => SHORTNAME."_system",
	"type" => "html",
	"html" => $system_info_html,
),

array( "type" => "close"),
//End second tab "System"


//Begin second tab "Demo"
array( "name" => "Demo-Content",
	"type" => "section",
	"icon" => "dashicons-download",
),

array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => SHORTNAME."_import_demo_content",
	"type" => "html",
	"html" => $demo_import_options_html,
),
 
array( "type" => "close"),

);
?>