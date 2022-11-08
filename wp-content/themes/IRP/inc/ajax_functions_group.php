<?php
/* Common Listing using AJAX */
add_action('wp_ajax_get_casestudy_listing_data', 'get_casestudy_listing_data');
add_action('wp_ajax_nopriv_get_casestudy_listing_data', 'get_casestudy_listing_data');

function get_casestudy_listing_data()
{
  //Declaration of temporary variables
  $type_query = array();
  $date_query = array();
  $industry_query = '';
  $solution_query = '';
  $category_query = '';
  $items_per_page = '';

  $current_page = $_REQUEST['current_page'];

  $flag = $_REQUEST['flag'];

  if ($flag == 'casestudy_listing') {
    $post_type = 'case_studies';
    $items_per_page = 6;
    $content_priority = 'content_priority';

    $indusryTermId = $_REQUEST['ind_term_id'];
    if ($indusryTermId) {
      $industry_query = array(
        'taxonomy' => 'industry',
        'field' => 'term_id',
        'terms' => $indusryTermId
      );
    }

    $solutionTermId = $_REQUEST['sol_term_id'];
    if ($solutionTermId) {
      $solution_query = array(
        'taxonomy' => 'solution',
        'field' => 'term_id',
        'terms' => $solutionTermId
      );
    }

    $countryTermId = $_REQUEST['con_term_id'];
    if ($countryTermId) {
      $country_query = array(
        'taxonomy' => 'country',
        'field' => 'term_id',
        'terms' => $countryTermId
      );
    }
  } elseif ($flag == 'blog_listing') {
    $post_type = 'post';
    $items_per_page = 6;
    $content_priority = 'content_priority';

    $categoryId = $_REQUEST['category_id'];
    if ($categoryId) {
      $category_query = array(
        'taxonomy' => 'category',
        'field' => 'term_id',
        'terms' => $categoryId
      );
    }
  } elseif ($flag == 'whitepaper_listing') {
    $post_type = 'whitepapers';
    $items_per_page = 6;
    $content_priority = 'content_priority';
  } elseif ($flag == 'ebook_listing') {
    $post_type = 'ebooks';
    $items_per_page = 6;
    $content_priority = 'content_priority';
  } elseif ($flag == 'webinar_listing') {
    $post_type = 'webinars';
    $items_per_page = 6;
    $content_priority = 'content_priority';
	$meta_key = "status";
	$meta_val = "Past";
	$type_query[] =  array(
          'key'       => $meta_key,
          'value'     => $meta_val,
          'compare'   => '='
        );
  } elseif ($flag == 'ourleaders_listing') {
    $post_type = 'our_leaders';
    $items_per_page = 12;
    $content_priority = 'content_priority';
  } elseif ($flag == 'in_the_news_listing') {
    $post_type = 'in_the_news';
    $items_per_page = 3;
    $content_priority = 'content_priority';
  }

  //Querying wordpress to fetch all the data conditionally.
  $args = array(
    'post_type'     => $post_type,
    'post_status'   => 'publish',
    'posts_per_page' => $items_per_page,
    'paged'      => $current_page,
    'tax_query' => array(
      'relation' => 'AND',
      $industry_query,
      $solution_query,
      $country_query,
      $category_query
    ),
    'meta_query' => array(
      'relation' => 'AND',
      /*array(
    		'key' => $content_priority,
    		'value' => 'none',
    		'compare' => '='
    	),*/
      $type_query,
    ),
    'date_query' => $date_query
  );

  $listingObj = new WP_Query($args); ?>
  <?php $i = 0; ?>
  <div class="row mb-n4">
    <?php if ($listingObj->have_posts()) :
      while ($listingObj->have_posts()) :  $listingObj->the_post();

        // Case Study Listing by AJAX
        if ($flag == 'casestudy_listing') :
          //$terms = @get_the_terms($listingObj->ID, 'solutions');
          ?>
          <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
            <div class="card h-100 wow fadeInUp" data-wow-delay="<?php echo $s; ?>s" data-wow-offset="30">
              <div class="card-image-box">
                <?php if (has_post_thumbnail($post->ID)) : ?>
                  <?php $caseImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large'); ?>
                  <div class="card-image cover-bg" style="background-image: url('<?php echo $caseImage[0]; ?>');"></div>
                <?php endif; ?>
              </div>
              <div class="card-body">
                <?php if($terms) : ?>
                <p>
                  <span class="btn btn-sm btn-outline-primary btn-muted px-3 case-tag">
                    <?php echo $terms[0]->name; ?>
                  </span>
                </p>
                <?php endif; ?>

                <?php if (get_the_title()) : ?>
                  <!--<h5 class="card-title"><a href="<?php echo the_field('pdf_link'); ?>" target="_blank"><?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a></h5>-->
                  <h5 class="card-title"><a href="<?php echo the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a></h5>
                <?php endif; ?>

                <?php
                $caseContent = get_field('short_description', $post->ID);
                if ($caseContent) : ?>
                  <p class="card-text"><?php echo wp_trim_words($caseContent, 30, '...'); ?></p>
                <?php endif; ?>
              </div>

              <?php /*if (get_field('pdf_link')) : ?>
                <div class="card-footer bg-transparent border-top-0">
                  <a href="<?php echo the_field('pdf_link'); ?>" class="read-more-link" title="Read Full Story" target="_blank">Read Full Story <img src="<?php echo THEME_PATH; ?>assets/images/Iconfeather-arrow-right.svg" alt="navigation right" /></a>
                </div>
              <?php endif; */ ?>
				<div class="card-footer bg-transparent border-top-0">
					<a href="<?php the_permalink(); ?>" class="read-more-link" title="Read Full Story">Read Full Story <img src="<?php echo THEME_PATH; ?>assets/images/Iconfeather-arrow-right.svg" alt="navigation right" /></a>
			    </div>
            </div>
          </div>

        <?php
        // Blog Listing by AJAX
        elseif ($flag == 'blog_listing') :
          $category = @get_the_terms($listingObj->ID, 'category');  ?>
          <div class="col-sm-6 col-lg-4 mb-4">
            <div class="card h-100 wow fadeInUp" data-wow-delay="<?php echo $s; ?>s" data-wow-offset="30">
              <div class="card-image-box">
                <?php if ($category[0]->name) : ?>
                  <div class="card-image-tag">
                    <span class="btn btn-sm btn-lightest-blue btn-muted px-3 case-tag"><?php echo $category[0]->name; ?></span>
                  </div>
                <?php endif; ?>
                <?php if (has_post_thumbnail($post->ID)) : ?>
                  <?php $caseImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large'); ?>
                  <div class="card-image cover-bg" loading="lazy" style="background-image: url('<?php echo $caseImage[0]; ?>');"></div>
                <?php endif; ?>
              </div>
              <div class="card-body">
                <?php if (get_the_title()) : ?>
                  <h5 class="card-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                      <?php echo wp_trim_words(get_the_title(), 10, '...'); ?>
                    </a>
                  </h5>
                <?php endif; ?>
                <?php
                $blogContent = get_field('short_description', $post->ID);
                if ($blogContent) : ?>
                  <p class="card-text"><?php echo wp_trim_words($blogContent, 30, '...'); ?></p>
                <?php endif; ?>
              </div>
              <div class="card-footer bg-transparent border-top-0">
                <a href="<?php the_permalink(); ?>" class="read-more-link" title="Know More">Read More <img src="<?php echo THEME_PATH; ?>assets/images/Iconfeather-arrow-right.svg" alt="navigation right" /></a>
              </div>
            </div>
          </div>
        <?php
        // White Paper Listing by AJAX
        elseif ($flag == 'whitepaper_listing') : ?>
          <div class="col-sm-6 col-lg-4 mb-4">
            <div class="card h-100">
              <div class="card-image-box">
                <!-- <div class="card-image-tag">
                  <span class="btn btn-sm btn-lightest-blue btn-muted px-3 case-tag"><?php //echo 'Technology' ?></span>
                </div> -->
                <?php if (has_post_thumbnail($post->ID)) : ?>
                  <?php $caseImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large'); ?>
                  <div class="card-image cover-bg" style="background-image: url('<?php echo $caseImage[0]; ?>');"></div>
                <?php endif; ?>
              </div>
              <div class="card-body">
                <?php if (get_the_title()) : ?>
                  <h5 class="card-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                      <?php echo wp_trim_words(get_the_title(), 10, '...'); ?>
                    </a>
                  </h5>
                <?php endif; ?>
                <?php
                $whiteContent = get_field('short_description', $post->ID);
                if ($whiteContent) : ?>
                  <p class="card-text"><?php echo wp_trim_words($whiteContent, 30, '...'); ?></p>
                <?php endif; ?>
              </div>
              <div class="card-footer bg-transparent border-top-0 text-end">
                <a href="<?php the_permalink(); ?>" class="read-more-link" title="Know More">Know More<img src="<?php echo THEME_PATH; ?>assets/images/Iconfeather-arrow-right.svg" alt="navigation right" /></a>
              </div>
            </div>
          </div>

        <?php
        // eBooks Listing by AJAX
        elseif ($flag == 'ebook_listing') : ?>
          <div class="col-sm-6 col-lg-4 mb-4">
            <div class="card h-100">
              <div class="card-image-box">
                <?php /*
                $ebookCategory = get_the_terms(get_the_ID(), 'ebook_categories');
                if ($ebookCategory[0]->name) : ?>
                  <div class="card-image-tag">
                    <span class="btn btn-sm btn-lightest-blue btn-muted px-3 case-tag"><?php echo $ebookCategory[0]->name; ?></span>
                  </div>
                <?php endif; */ ?>
                
                <?php if (has_post_thumbnail($post->ID)) : ?>
                  <?php $caseImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large'); ?>
                  <div class="card-image cover-bg" style="background-image: url('<?php echo $caseImage[0]; ?>');"></div>
                <?php endif; ?>
              </div>
              <div class="card-body">
                <?php if (get_the_title()) : ?>
                  <h5 class="card-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                      <?php echo wp_trim_words(get_the_title(), 10, '...'); ?>
                    </a>
                  </h5>
                <?php endif; ?>
                <?php
                $ebookContent = get_field('short_description', $post->ID);
                if ($ebookContent) : ?>
                  <p class="card-text"><?php echo wp_trim_words($ebookContent, 30, '...'); ?></p>
                <?php endif; ?>
              </div>
              <div class="card-footer bg-transparent border-top-0 text-end">
                <a href="<?php the_permalink(); ?>" class="read-more-link" title="Know More">Know More<img src="<?php echo THEME_PATH; ?>assets/images/Iconfeather-arrow-right.svg" alt="navigation right" /></a>
              </div>
            </div>
          </div>

        <?php
        // Webinars Listing by AJAX
        elseif ($flag == 'webinar_listing') :
          $category = @get_the_terms($listingObj->ID, 'category'); 
		  $speakerinner = '';
			if (have_rows('webinars_list')) :
				while (have_rows('webinars_list')) : the_row(); 
					if (get_sub_field('speaker_name', $post->ID)) : 
						$speakerinner .= get_sub_field('speaker_name', $post->ID).' | '; 
					endif; 
				endwhile;
			endif;		  
		  ?>
          <div class="col-sm-6 col-lg-4 mb-4">
            <div class="card h-100 wow fadeInUp" data-wow-delay="<?php echo $s; ?>s" data-wow-offset="30">
              <div class="card-image-box">
                <?php if ($category[0]->name) : ?>
                  <div class="card-image-tag">
                    <span class="btn btn-sm btn-lightest-blue btn-muted px-3 case-tag"><?php echo $category[0]->name; ?></span>
                  </div>
                <?php endif; ?>
                <?php if (has_post_thumbnail($post->ID)) : ?>
                  <?php $webinarImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large'); ?>
                  <div class="card-image cover-bg" style="background-image: url('<?php echo $webinarImage[0]; ?>');"></div>
                <?php endif; ?>
              </div>
              <div class="card-body">
                <?php if (get_the_title()) : ?>
                  <h5 class="card-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                      <?php echo wp_trim_words(get_the_title(), 10, '...'); ?>
                    </a>
                  </h5>
                <?php endif; ?>                

                <?php if (get_field('date', $post->ID)) :
				$formated_date_inner = date('jS F Y', strtotime(get_field('date', $post->ID))); ?>
                  <p class="card-text"><span><i class="fas fa-calendar-alt"></i><?php echo $formated_date_inner; ?></span><span class="text-uppercase"><i class="fas fa-clock"></i><?php if (get_field('start_time', $post->ID)) : ?> <?php echo the_field('start_time', $post->ID); ?> <!--To <?php echo the_field('end_time', $post->ID); ?> -->(<?php echo the_field('time_selection', $post->ID); ?>)</span><?php endif; ?></p>
                <?php endif; ?>

                <?php
                if ($speakerinner != '') : ?>
                  <p class="card-text"><img src="<?php echo THEME_PATH; ?>assets/images/employee.svg" alt="navigation right" /> <?php echo rtrim(trim($speakerinner), '|'); ?></p>
                <?php endif; ?>
              </div>
              <div class="card-footer bg-transparent border-top-0">
                <a href="<?php the_permalink(); ?>" class="read-more-link" title="Watch Now">Watch Now <img src="<?php echo THEME_PATH; ?>assets/images/Iconfeather-arrow-right.svg" alt="navigation right" /></a>
              </div>
            </div>
          </div>

        <?php
        // Our Leaders Listing by AJAX
        elseif ($flag == 'ourleaders_listing') : ?>
          <div class="col-sm-6 col-lg-4 mb-4">
            <div class="leadership-card card d-flex flex-wrap mb-4 h-100">
              <div class="leadership-box">
                <?php if (get_the_title()) : ?>
                  <h4 class="leader-title"> <?php echo wp_trim_words(get_the_title(), 10, '...'); ?></h4>
                <?php endif; ?>

                <?php if (get_field('leader_designation', $post->ID)) : ?>
                  <p><?php echo the_field('leader_designation', $post->ID); ?></p>
                <?php endif; ?>

                <?php if (get_field('leader_description', $post->ID)) : ?>
                  <p class="text-light-gray"><?php echo the_field('leader_description', $post->ID); ?></p>
                <?php endif; ?>
              </div>

              <?php if (get_field('leader_linkedin_url', $post->ID)) : ?>
                <div class="linkedin-box">
                  <a href="<?php echo the_field('leader_linkedin_url', $post->ID); ?>" title="Linkedin" class="link-linkedin" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                </div>
              <?php endif; ?>
            </div>
          </div>

        <?php
        // In the News Listing by AJAX
        elseif ($flag == 'in_the_news_listing') : ?>
          <div class="col-sm-6 col-lg-4 mb-4">
            <div class="card h-100">
              <div class="card-image-box">
                <?php if (has_post_thumbnail($post->ID)) : ?>
                  <?php $newsImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large'); ?>
                  <div class="card-image cover-bg" style="background-image: url('<?php echo $newsImage[0]; ?>');"></div>
                <?php endif; ?>
              </div>
              <div class="card-body">
                <?php if (get_the_title()) : ?>
                  <h5 class="card-title">
                    <a href="<?php if (get_field('news_url', $post->ID)) {
                                echo the_field('news_url', $post->ID);
                              } else {
                                echo '#';
                              } ?>" title="<?php the_title(); ?>" target="_blank">
                      <?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a>
                  </h5>
                <?php endif; ?>
              </div>
              <?php if (get_field('news_url', $post->ID)) : ?>
                <div class="card-footer bg-transparent border-top-0 text-end">
                  <a href="<?php echo the_field('news_url', $post->ID); ?>" class="read-more-link" title="Read More" target="_blank">Read More<img src="<?php echo THEME_PATH; ?>assets/images/Iconfeather-arrow-right.svg" alt="navigation right" /></a>
                </div>
              <?php endif; ?>
            </div>
          </div>
    <?php endif;
		$s = $s + 0.2;
      endwhile; 
	  else : ?>
	  <p class="text-center">No Record Found</p>
    <?php endif; ?>
  </div>

  <div class="pagination justify-content-center">
    <?php
    $output = '';
    $total = $listingObj->found_posts;

    if ($current_page > 1) :
      $output .= '<a href="javascript:void(0);" title="Previous" class="pagination-link prev-link" data-page_num = ' . ($current_page - 1) . '><span aria-hidden="true"><i class="bi bi-chevron-left"></i></span></a>';

    endif;

    if ($current_page >= 5) :

      if ($current_page == 1) :
        $output .= '<a href="javascript:void(0);" class="pagination-link current-page" id="pagination_link' . $current_page . '" data-page_num = 1> 1 </a>';

      else :
        $output .= '<a href="javascript:void(0);" class="pagination-link" data-page_num = 1> 1 </a>';
      endif;

      $output .= '<span> .... </span>';

      for ($j = ($current_page - 3); $j < $current_page; $j++) {
        if ($current_page == $j) :
          $output .= '<a href="javascript:void(0);" class="pagination-link current_page" id="pagination_link' . $current_page . '" data-page_num = ' . $j . '>' . $j . '</a>';

        else :
			$output .= '<a href="javascript:void(0);" class="pagination-link" data-page_num = ' . $j . '>' . $j . '</a>';
        endif;
      }

      for ($k = $current_page; $k < ($current_page + 3); $k++) {

        if ($k != (ceil($total / $items_per_page)) && $k != (ceil($total / $items_per_page) + 1)) :
          if ($current_page != ceil($total / $items_per_page)) :
            if ($current_page == $k) :
              $output .= '<a href="javascript:void(0);" class="pagination-link current-page" id="pagination_link' . $current_page . '" data-page_num = ' . $k . '>' . $k . '</a>';

            else :
              $output .= '<a href="javascript:void(0);" class="pagination-link" data-page_num = ' . $k . '>' . $k . '</a>';
            endif;
          endif;
        endif;
      }

      $output .= '<span> .... </span>';

      if ($current_page == ceil($total / $items_per_page)) :
        $output .= '<a href="javascript:void(0);" class="pagination-link current-page" id="pagination_link' . $current_page . '" data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';

      else :
        $output .= '<a href="javascript:void(0);" class="pagination-link" data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';
      endif;

    else :

      for ($i = 1; $i <= ceil($total / $items_per_page); $i++) {
        if ($i > 5) :
          $output .= '<span> .... </span>';
          if ($current_page == ceil($total / $items_per_page)) :
            $output .= '<a href="javascript:void(0);" class="pagination-link current-page" id="pagination_link' . $current_page . '"  data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';

          else :
            $output .= '<a href="javascript:void(0);" class="pagination-link" data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';
          endif;

          break;

        else :
          if ($current_page == $i) :
            $output .= '<a href="javascript:void(0);" class="pagination-link current-page"  id="pagination_link' . $current_page . '" data-page_num = ' . $i . '>' . $i . '</a>';

          else :
            $output .= '<a href="javascript:void(0);" class="pagination-link" data-page_num = ' . $i . '>' . $i . '</a>';
          endif;
        endif;
      }
    endif;

    if (($current_page < ceil($total / $items_per_page)) && ($current_page != ceil($total / $items_per_page))) :
      $output .= '<a href="javascript:void(0);" title="Next" class="pagination-link next-link" data-page_num = ' . ($current_page + 1) . '><span aria-hidden="true"><i class="bi bi-chevron-right"></i></span></a>';
    endif;

	if($total <= 6){
		$output = '';
	}
    echo $output;
    die();
    ?>
  </div>
<?php } 

/* Press Release Listing */
add_action('wp_ajax_get_press_release_listing', 'get_press_release_listing');
add_action('wp_ajax_nopriv_get_press_release_listing', 'get_press_release_listing');

function get_press_release_listing()
{
  //Declaration of temporary variables
  $items_per_page = '';
  $current_page = $_REQUEST['current_page'];
  $flag = $_REQUEST['flag'];

  if ($flag == 'press_release_listing') {
    $post_type = 'press-release';
    $items_per_page = 6;
    $content_priority = 'content_priority';
  }

  //Querying wordpress to fetch all the data conditionally.
  $args = array(
    'post_type'     => $post_type,
    'post_status'   => 'publish',
    'posts_per_page' => $items_per_page,
    'paged'      => $current_page
  );

  $listingObj = new WP_Query($args); ?>
  <?php $i = 0; ?>
  <div class="row mb-n4">
    <?php if ($listingObj->have_posts()) :
      while ($listingObj->have_posts()) :  $listingObj->the_post();

        // Press Release Listing by AJAX
        if ($flag == 'press_release_listing') : ?>
          <div class="col-sm-6 col-lg-4 mb-4">
            <div class="card h-100">
              <div class="card-image-box">
                <?php if (has_post_thumbnail($post->ID)) : ?>
                  <?php $pressImage = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium_large'); ?>
                  <div class="card-image cover-bg" style="background-image: url('<?php echo $pressImage[0]; ?>');"></div>
                <?php endif; ?>
              </div>
              <div class="card-body">
                <?php if (get_the_title()) : ?>
                  <h5 class="card-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                      <?php echo wp_trim_words(get_the_title(), 10, '...'); ?></a>
                  </h5>
                <?php endif; ?>
              </div>

              <div class="card-footer bg-transparent border-top-0 text-end">
                <a href="<?php the_permalink(); ?>" class="read-more-link" title="Read More">Read More<img src="<?php echo THEME_PATH; ?>assets/images/Iconfeather-arrow-right.svg" alt="navigation right" /></a>
              </div>
            </div>
          </div>
    <?php endif;

      endwhile;
    endif; ?>
  </div>

  <div class="pagination justify-content-center">
    <?php
    $output = '';
    $total = $listingObj->found_posts;

    if ($current_page > 1) :
      $output .= '<a href="javascript:void(0);" title="Previous" class="pagination-links prev-link" data-page_num = ' . ($current_page - 1) . '><span aria-hidden="true"><i class="bi bi-chevron-left"></i></span></a>';

    endif;

    if ($current_page >= 5) :

      if ($current_page == 1) :
        $output .= '<a href="javascript:void(0);" class="pagination-links current-page" id="pagination_link' . $current_page . '" data-page_num = 1> 1 </a>';

      else :
        $output .= '<a href="javascript:void(0);" class="pagination-links" data-page_num = 1> 1 </a>';
      endif;

      $output .= '<span> .... </span>';

      for ($j = ($current_page - 3); $j < $current_page; $j++) {
        if ($current_page == $j) :
          $output .= '<a href="javascript:void(0);" class="pagination-links current_page" id="pagination_link' . $current_page . '" data-page_num = ' . $j . '>' . $j . '</a>';

        else :
          $output .= '<a href="javascript:void(0);" class="pagination-link" data-page_num = ' . $j . '>' . $j . '</a>';
        endif;
      }

      for ($k = $current_page; $k < ($current_page + 3); $k++) {

        if ($k != (ceil($total / $items_per_page)) && $k != (ceil($total / $items_per_page) + 1)) :
          if ($current_page != ceil($total / $items_per_page)) :
            if ($current_page == $k) :
              $output .= '<a href="javascript:void(0);" class="pagination-links current-page" id="pagination_link' . $current_page . '" data-page_num = ' . $k . '>' . $k . '</a>';

            else :
              $output .= '<a href="javascript:void(0);" class="pagination-links" data-page_num = ' . $k . '>' . $k . '</a>';
            endif;
          endif;
        endif;
      }

      $output .= '<span> .... </span>';

      if ($current_page == ceil($total / $items_per_page)) :
        $output .= '<a href="javascript:void(0);" class="pagination-links current-page" id="pagination_link' . $current_page . '" data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';

      else :
        $output .= '<a href="javascript:void(0);" class="pagination-links" data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';
      endif;

    else :

      for ($i = 1; $i <= ceil($total / $items_per_page); $i++) {
        if ($i > 5) :
          $output .= '<span> .... </span>';
          if ($current_page == ceil($total / $items_per_page)) :
            $output .= '<a href="javascript:void(0);" class="pagination-links current-page" id="pagination_link' . $current_page . '"  data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';

          else :
            $output .= '<a href="javascript:void(0);" class="pagination-links" data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';
          endif;

          break;

        else :
          if ($current_page == $i) :
            $output .= '<a href="javascript:void(0);" class="pagination-links current-page"  id="pagination_link' . $current_page . '" data-page_num = ' . $i . '>' . $i . '</a>';

          else :
            $output .= '<a href="javascript:void(0);" class="pagination-links" data-page_num = ' . $i . '>' . $i . '</a>';
          endif;
        endif;
      }
    endif;

    if (($current_page < ceil($total / $items_per_page)) && ($current_page != ceil($total / $items_per_page))) :
      $output .= '<a href="javascript:void(0);" title="Next" class="pagination-links next-link" data-page_num = ' . ($current_page + 1) . '><span aria-hidden="true"><i class="bi bi-chevron-right"></i></span></a>';
    endif;

    echo $output;
    die();
    ?>
  </div>
<?php } 

/* Search Result Listing */
add_action('wp_ajax_get_search_result_listing', 'get_search_result_listing');
add_action('wp_ajax_nopriv_get_search_result_listing', 'get_search_result_listing');

function get_search_result_listing()
{
  //Declaration of temporary variables
  $items_per_page = '';
  $current_page = $_REQUEST['current_page'];
  $flag = $_REQUEST['flag'];

  if ($flag == 'search_result') {
    $post_type = array('post', 'page', 'case_studies', 'ebooks', 'whitepapers', 'webinars', 'press-release');
    $items_per_page = 10;
    $content_priority = 'content_priority';
  }

  //Querying wordpress to fetch all the data conditionally.
  $args = array(
    'post_type'     => $post_type,
    's' => esc_attr($_POST['keyword']),
    'post_status'   => 'publish',
    'posts_per_page' => $items_per_page,
    'paged'      => $current_page
  );

  $listingObj = new WP_Query($args);
  $count = $listingObj->found_posts;
  $i = 0; ?>

  <div class="search-result-page">
    <p> Your search for <strong class="text-light-orange"><?php echo $_POST['keyword'];?></strong> matches <strong class="text-light-orange"><?php echo $count; ?></strong> Results </p>
  </div>
  <div class="">
    <ul id="search-results list-unstyled">
      <?php if ($listingObj->have_posts()) :
        while ($listingObj->have_posts()) :  $listingObj->the_post();
          if ($flag == 'search_result') : ?>
            <li>
              <div>
                <a href="<?php the_permalink(); ?>" class="search-table">
                  <div class="search-table-cell">
                    <h4><?php the_title(); ?></h4>
                    <p><?php echo wp_trim_words(get_the_content(), 40, '...'); ?><span class="mobile-arrow"><i class="icon bi bi-arrow-right" aria-hidden="true"></i></span></p>
                  </div>
                  <div class="search-table-cell"><i class="icon bi bi-arrow-right" aria-hidden="true"></i></div>
                </a>
              </div>
            </li>
      <?php endif;
        endwhile;
      endif; ?>
    </ul>
    <div>

      <div class="pagination justify-content-center">
        <?php
        $output = '';
        $total = $listingObj->found_posts;

        if ($current_page > 1) :
          $output .= '<a href="javascript:void(0);" title="Previous" class="pagination-lnk prev-link" data-page_num = ' . ($current_page - 1) . '><span aria-hidden="true"><i class="bi bi-chevron-left"></i></span></a>';

        endif;

        if ($current_page >= 5) :

          if ($current_page == 1) :
            $output .= '<a href="javascript:void(0);" class="pagination-lnk current-page" id="pagination_link' . $current_page . '" data-page_num = 1> 1 </a>';

          else :
            $output .= '<a href="javascript:void(0);" class="pagination-lnk" data-page_num = 1> 1 </a>';
          endif;

          $output .= '<span> .... </span>';

          for ($j = ($current_page - 3); $j < $current_page; $j++) {
            if ($current_page == $j) :
              $output .= '<a href="javascript:void(0);" class="pagination-lnk current_page" id="pagination_link' . $current_page . '" data-page_num = ' . $j . '>' . $j . '</a>';

            else :
              $output .= '<a href="javascript:void(0);" class="pagination-link" data-page_num = ' . $j . '>' . $j . '</a>';
            endif;
          }

          for ($k = $current_page; $k < ($current_page + 3); $k++) {

            if ($k != (ceil($total / $items_per_page)) && $k != (ceil($total / $items_per_page) + 1)) :
              if ($current_page != ceil($total / $items_per_page)) :
                if ($current_page == $k) :
                  $output .= '<a href="javascript:void(0);" class="pagination-lnk current-page" id="pagination_link' . $current_page . '" data-page_num = ' . $k . '>' . $k . '</a>';

                else :
                  $output .= '<a href="javascript:void(0);" class="pagination-lnk" data-page_num = ' . $k . '>' . $k . '</a>';
                endif;
              endif;
            endif;
          }

          $output .= '<span> .... </span>';

          if ($current_page == ceil($total / $items_per_page)) :
            $output .= '<a href="javascript:void(0);" class="pagination-lnk current-page" id="pagination_link' . $current_page . '" data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';

          else :
            $output .= '<a href="javascript:void(0);" class="pagination-lnk" data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';
          endif;

        else :

          for ($i = 1; $i <= ceil($total / $items_per_page); $i++) {
            if ($i > 5) :
              $output .= '<span> .... </span>';
              if ($current_page == ceil($total / $items_per_page)) :
                $output .= '<a href="javascript:void(0);" class="pagination-lnk current-page" id="pagination_link' . $current_page . '"  data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';

              else :
                $output .= '<a href="javascript:void(0);" class="pagination-lnk" data-page_num = ' . ceil($total / $items_per_page) . '> ' . ceil($total / $items_per_page) . ' </a>';
              endif;

              break;

            else :
              if ($current_page == $i) :
                $output .= '<a href="javascript:void(0);" class="pagination-lnk current-page"  id="pagination_link' . $current_page . '" data-page_num = ' . $i . '>' . $i . '</a>';

              else :
                $output .= '<a href="javascript:void(0);" class="pagination-lnk" data-page_num = ' . $i . '>' . $i . '</a>';
              endif;
            endif;
          }
        endif;

        if (($current_page < ceil($total / $items_per_page)) && ($current_page != ceil($total / $items_per_page))) :
          $output .= '<a href="javascript:void(0);" title="Next" class="pagination-lnk next-link" data-page_num = ' . ($current_page + 1) . '><span aria-hidden="true"><i class="bi bi-chevron-right"></i></span></a>';
        endif;

        echo $output;
        die();
        ?>
      </div>
<?php } ?>