<?php

function make_slide_indicators($result)
{
 $output = ''; 
 $count = 0;

 while($row = $results->products)
 {
  if($count == 0)
  {
   $output .= '
   <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'" class="active"></li>
   ';
  }
  else
  {
   $output .= '
   <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'"></li>
   ';
  }
  $count = $count + 1;
 }
 return $output;
}


function make_slides($results)
{
 $output = '';
 $count = 0;
 foreach($results->products as $result)
 {
  if($count == 0)
  {
   $output .= '<div class="item active">';
  }
  else
  {
   $output .= '<div class="item">';
  }
  $output .= '
    <div>
    <img class="center-block" width="50%" height="50%" src='.$result->images[0].' alt="'.$result->title.'" />
    </div>
    
    <div class="carousel-caption">
    <h5>'.$result->title.'</h3>
    <h5>'.$result->description.'</h3>
    </div>
    </div>
  ';
  $count = $count + 1;
 }
 return $output;
}

function slider_section( $atts, $content ) 
{
   	$atts = shortcode_atts(
		array(
			'featured_slider_image' => '',
			'slider_title' => '',
		), $atts, 'vcas_title' );
    
    
	$url='https://dummyjson.com/products';
	
	$args= array('method'=>'GET');

	$response=wp_remote_get($url, $args);

	if(is_wp_error($response))
	{
		$error_message=$response->get_error_message();
		echo "something gets wrong: $error_message";
	}

	$results=json_decode(wp_remote_retrieve_body($response));
	
	
    ob_start();?>
    
    <div class="container">
        <h2 align="center">Product carousel</h2>
        <br />
        <div id="dynamic_slide_show" class="carousel slide" data-ride="carousel">
    
            <ol class="carousel-indicators">
                <?php echo make_slide_indicators($results); ?>
            </ol>
            <div class="carousel-inner">
             <?php echo make_slides($results); ?>
            </div>
            
        </div>
    </div>
    
    
    <?php $html = ob_get_clean();
    return $html;
}




function vcas_component_for_home_page(){
	  vc_map(array(
    "name" => __("Home Page slider"),
    "base" => "home_page_slider",
    "category" => __('Custom Component'),
    "params" => array(
      array(
        "type" => "attach_image",
        "holder" => "div",
        "class" => "",
        "heading" => __("featured Image"),
        "param_name" => "featured_slider_image",
        "value" => array("Self", "Blank"),
        "description" => __("	Please upload Image")
      ),

      array(
        "type" => "textarea",
        "holder" => "div",
        "class" => "",
        "heading" => __("Slider Title"),
        "param_name" => "slider_title",
        "value" => array("Show" => "show", "Hide" => "hide"),
        "description" => __("")
      ),

    )
  ));
}

add_shortcode( 'home_page_slider', 'slider_section' );