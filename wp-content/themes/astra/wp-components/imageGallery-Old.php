<?php

function make_slides($results)
{
 $output = '';
 $count = 0;
 foreach($results->products as $result)
 {
      $output .= '<li class="card-item">
                    <a href="" class="card-link">
                        <img class="card-image" width="50%" height="50%" src='.$result->images[0].' alt="" />
                        <p class="badge">'.$result->title.'</p>
                        <h2 class="card-title"> '.$result->price.'</h2>
                    </a>
                </li>';
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
        <div class="card-wrapper">
            <ul class="card-list"
                <?php echo make_slides($results); ?>
            </ul>
            
        </div>
        
    </div>
    
    
    <?php $html = ob_get_clean();
    return $html;
}



add_shortcode( 'home_page_slider', 'slider_section' );




