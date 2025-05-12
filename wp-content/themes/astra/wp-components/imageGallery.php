<?php


function make_slides($results)
{
 $output = '';
 $count = 0;
 foreach($results->products as $result)
 {
     if($count == 0)
     {
               $output .= '
      <div class="slide active">
      <img src='.$result->images[0].' alt="" />
      <div class="caption">'.$result->title.'</div>
      <div class="description">'.$result->description.'</div>
      </div>';
     }
     
     else {
              $output .= '
      <div class="slide">
      <img src='.$result->images[0].' alt="" />
      <div class="caption">'.$result->title.'</div>
      <div class="description">'.$result->description.'</div>
      </div>';
     }

 }
 
 return $output;
}




function slider_section( $atts, $content ) 
{
	$url='https://dummyjson.com/products';
	
	$args= array('method'=>'GET');

	$response=wp_remote_get($url, $args);

	if(is_wp_error($response))
	{
		$error_message=$response->get_error_message();
		echo "something gets wrong: $error_message";
	}

	$results=json_decode(wp_remote_retrieve_body($response));
    foreach($results->products as $result)
     {
        echo $result->title;
     }    
	
    ob_start();?>
 
 <div class="slider">
  <div class="slides" id="slides">
    <?php echo make_slides($results); ?>

  </div>
 
  <div class="nav-buttons">
    <button onclick="moveSlide(-1)">❮</button>
    <button onclick="moveSlide(1)">❯</button>
    
  </div>
</div>
 

   <?php $html = ob_get_clean();
    return $html;
}



add_shortcode( 'image_slider', 'slider_section' );