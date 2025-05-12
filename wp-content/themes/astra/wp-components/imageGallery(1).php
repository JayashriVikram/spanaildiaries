<?php


function make_slides($results)
{
 $output = '';
 $count = 0;
 foreach($results->products as $result)
 {
      $output .= '
      <div class="slide">
      <img src='.$result->images[0].' alt="" />
      </div>';
 }
 
 return $output;
}


function make_slidesOld($results)
{
    
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
	
	
    ob_start();?>
    

    <div class="nav">
        <button onclick="goPrev()">Prev</button>
        <button onclick="goNext()">Next</button>
    </div>

    <div class=main>
        <?php echo make_slides($results); ?>
    </div>

    <?php $html = ob_get_clean();
    return $html;
}



add_shortcode( 'home_page_slider', 'slider_section' );




