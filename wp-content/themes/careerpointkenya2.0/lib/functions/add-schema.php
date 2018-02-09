<?php
/**
 * Add Schema
 *
 * This file inserts the appropriate JobListing schema on job postings. 
 *
 */

/* If schema exists on post dump it out 
*/

add_action( 'genesis_before', 'wsm_write_job_posting_schema' );
function wsm_write_job_posting_schema(  ){

global $post;

if ( ! is_main_query() && ! genesis_is_blog_template() ) {
  return;
}

if ( 'job_posting' === get_post_type() ) {
  $attributes['itemscope'] = true;
  $attributes['itemtype']  = 'http://schema.org/JobPosting';

  //* If not search results page
  if ( ! is_search() ) {
    $attributes['itemprop']  = 'JobPosting';
  }

} else {
  return;
}

//* do not add job posting schema data for old posts - temp fix
$post_date = get_the_date("Y", $my_post_id_exists );
if ( $post_date < "2018" ) return;

// var_dump("doing jobposting");
$post_id = get_the_ID( $post->ID ); 

$prefix = '_careerpoint_jobposting_';

// Build output string

//* First start with the script headings 
$jobposting_content = '<script type="application/ld+json">	
{
  "@context": "http://schema.org",
  "@type": "JobPosting"';

//* Special treatment needed for addresses which may have up to 4 property settings
$postal_address_schema_props = array( 
  'addressLocality' => get_post_meta( $post_id, $prefix . 'job_location_locality', true ),  //City
  'addressRegion'	=> get_post_meta( $post_id, $prefix . 'job_location_region', true ),  //State
  'streetAddress' => get_post_meta( $post_id, $prefix . 'job_location_street_address', true ),
  'postalCode' => get_post_meta( $post_id, $prefix . 'job_location_postal_code', true ),
);

$job_posting_schema_props = array();
$set1 = false;
$jobposting_content_postal_address .= '
"@type": "Place",
    "address": { 
      "@type": "PostalAddress"';

      foreach ($postal_address_schema_props as $postalkey => $postalvalue) {
        if ( $postal_address_schema_props[$postalkey] ) {
          $jobposting_content_postal_address .= ',
              "' . $postalkey . '": "' . $postalvalue . '"';
              $set1 = true;
        }
      }
$jobposting_content_postal_address .= '
     }';

if ( $set1 ) { 
  $job_posting_schema_props['jobLocation'] = '{ ' . $jobposting_content_postal_address . ' }';  
}

//* Set up date specific properties
$date_post_tmp = get_post_meta( $post_id, $prefix . 'date_posted', true );
if ( $date_post_tmp ) {
  $job_posting_schema_props['datePosted'] = '"' . date('Y-m-d', strtotime( $date_post_tmp ) ) . '"';
}

$valid_through_tmp = get_post_meta( $post_id, $prefix . 'valid_through', true );
if ( $valid_through_tmp ) {
  $job_posting_schema_props['validThrough'] = '"' . date('Y-m-d', strtotime( $valid_through_tmp ) ) . 'T' . date('H:i:s', strtotime( $valid_through_tmp ) )  . '"';
  $attributes['validThrough'] = '"' . date('Y-m-d', strtotime( $valid_through_tmp ) ) . 'T' . date('H:i:s', strtotime( $valid_through_tmp ) )  . '"';
}

//* Build array of populated props

// Updated 2/7/2018 per TKT 1412
// Post Content contains all of the descriptive items for Job Posting schema. 
if ( $post->post_content ) {
  $job_posting_schema_props['description'] = '"' . esc_html($post->post_content) . '"';
  $attributes['description'] = '"' . esc_html($post->post_content) . '"';
}

// Employment Type is now a custom taxonomy: employment_type

  $jp_empl_type = wp_get_post_terms( $post_id, 'employment_type', array("fields" => "names") );
  $job_posting_schema_props['employmentType'] = '"' . $jp_empl_type[0] . '"';

// Hiring organization is now a custom taxonomy 
  $jp_hire_org = wp_get_post_terms( $post_id, 'hiring_organizations', array("fields" => "names") );
  $job_posting_schema_props['hiringOrganization'] = '"' . $jp_hire_org[0] . '"';
  
if ( get_post_meta( $post_id, $prefix . 'job_title', true ) ) 
 $job_posting_schema_props['title'] = '"' . get_post_meta( $post_id, $prefix . 'job_title', true ) . '"';

foreach ($job_posting_schema_props as $key => $value) {
  $jobposting_content .= ',
     "' . $key . '": ' . $value;
}

//* Finish it up.
$jobposting_content .= '
}
</script>';

//* Dump it out
printf( '%s', $jobposting_content  );

return;
}

