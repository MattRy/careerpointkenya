<?php
/**
 * Add Schema
 *
 * This file inserts the appropriate JobListing schema on job postings. 
 *
 */

/* If schema exists on post dump it out 
*/

// add_filter( 'genesis_attr_body', 'wsm_write_job_posting_schema' );

add_action( 'genesis_before', 'wsm_write_job_posting_schema' );

// add_action( 'wp_enqueue_scripts', 'wsm_write_job_posting_schema' );

function wsm_write_job_posting_schema(  ){

global $post;

if ( ! is_main_query() && ! genesis_is_blog_template() ) {
  return;
}




if ( 'post' === get_post_type() ) {
  $attributes['itemscope'] = true;
  $attributes['itemtype']  = 'http://schema.org/JobPosting';

  //* If not search results page
  if ( ! is_search() ) {
    $attributes['itemprop']  = 'JobPosting';
  }

}

//* do not add job posting schema data for old posts - temp fix
$post_date = get_the_date("Y", $my_post_id_exists );
if ( $post_date < "2018" ) return;

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

//* Build salary properties (Base and Estimated) from 3 separate meta input fields
$monetary_amount_schema_props_value =  get_post_meta( $post_id, $prefix . 'base_salary', true );
if ( $monetary_amount_schema_props_value ) {  
  $monetary_amount_schema_props_units = get_post_meta( $post_id, $prefix . 'base_salary_units', true );
  $monetary_amount_salary_currency = get_post_meta( $post_id, $prefix . 'salary_currency', true );

  $jobposting_content_base_salary = '
    "@type": "MonetaryAmount",
    "currency": "' . $monetary_amount_salary_currency . '",
    "value": {
      "@type": "QuantitativeValue",
      "value": "' . $monetary_amount_schema_props_value . '",
      "unitText": "' . $monetary_amount_schema_props_units . '"
        }';
  $job_posting_schema_props['baseSalary'] = '{ ' . $jobposting_content_base_salary . ' }';     
}

//* Do it again for Estimated Salary. We will use the same units frrom above. 
$monetary_amount_schema_props_value =  get_post_meta( $post_id, $prefix . 'estimated_salary', true );
if ( $monetary_amount_schema_props_value ) { 
  $jobposting_content_estimated_salary = '
    "@type": "MonetaryAmount",
    "currency": "' . $monetary_amount_salary_currency . '",
    "value": {
      "@type": "QuantitativeValue",
      "value": "' . $monetary_amount_schema_props_value . '",
      "unitText": "' . $monetary_amount_schema_props_units . '" 
        }';
  $job_posting_schema_props['estimatedSalary'] = '{ ' . $jobposting_content_estimated_salary . ' }';
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

if ( $post->post_content ) {
  $job_posting_schema_props['description'] = '"' . esc_html($post->post_content) . '"';
  $attributes['description'] = '"' . esc_html($post->post_content) . '"';
}

if ( get_post_meta( $post_id, $prefix . 'education_requirements', true ) )  
  $job_posting_schema_props['educationRequirements'] = '"' . get_post_meta( $post_id, $prefix . 'education_requirements', true ) . '"';

if ( get_post_meta( $post_id, $prefix . 'employment_type', true ) )  
  $job_posting_schema_props['employmentType'] = '"' . get_post_meta( $post_id, $prefix . 'employment_type', true ) . '"';

  if ( get_post_meta( $post_id, $prefix . 'experience_requirements', true ) ) 
  $job_posting_schema_props['experienceRequirements'] = '"' . get_post_meta( $post_id, $prefix . 'experience_requirements', true ) . '"';

if ( get_post_meta( $post_id, $prefix . 'hiring_organization', true ) ) 
  $job_posting_schema_props['hiringOrganization'] = '"' . get_post_meta( $post_id, $prefix . 'hiring_organization', true ) . '"';
  
if ( get_post_meta( $post_id, $prefix . 'incentive_compensation', true ) ) 
  $job_posting_schema_props['incentiveCompensation'] = '"' . get_post_meta( $post_id, $prefix . 'incentive_compensation', true ) . '"';

  if ( get_post_meta( $post_id, $prefix . 'industry', true )  ) 
  $job_posting_schema_props['industry'] = '"' . get_post_meta( $post_id, $prefix . 'industry', true ) . '"';

if ( get_post_meta( $post_id, $prefix . 'job_benefits', true ) ) 
  $job_posting_schema_props['jobBenefits'] = '"' . get_post_meta( $post_id, $prefix . 'job_benefits', true ) . '"';
  
if ( get_post_meta( $post_id, $prefix . 'occupational_category', true ) ) 
 $job_posting_schema_props['occupationalCategory'] = '"' . get_post_meta( $post_id, $prefix . 'occupational_category', true ) . '"';
  
if ( get_post_meta( $post_id, $prefix . 'qualifications', true ) ) 
 $job_posting_schema_props['qualifications'] = '"' . get_post_meta( $post_id, $prefix . 'qualifications', true ) . '"';
 
if ( get_post_meta( $post_id, $prefix . 'responsibilities', true ) ) 
 $job_posting_schema_props['responsibilities'] = '"' . get_post_meta( $post_id, $prefix . 'responsibilities', true ) . '"';

if ( get_post_meta( $post_id, $prefix . 'salary_currency', true ) ) 
 $job_posting_schema_props['salaryCurrency'] = '"' . get_post_meta( $post_id, $prefix . 'salary_currency', true ) . '"';

if ( get_post_meta( $post_id, $prefix . 'skills', true ) ) 
 $job_posting_schema_props['skills'] = '"' . get_post_meta( $post_id, $prefix . 'skills', true ) . '"';

if ( get_post_meta( $post_id, $prefix . 'special_commitments', true ) ) 
 $job_posting_schema_props['specialCommitments'] = '"' . get_post_meta( $post_id, $prefix . 'special_commitments', true ) . '"';

if ( get_post_meta( $post_id, $prefix . 'title', true ) ) 
 $job_posting_schema_props['title'] = '"' . get_post_meta( $post_id, $prefix . 'title', true ) . '"';

if ( get_post_meta( $post_id, $prefix . 'work_hours', true ) )
 $job_posting_schema_props['workHours'] = '"' . get_post_meta( $post_id, $prefix . 'work_hours', true ) . '"';

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

