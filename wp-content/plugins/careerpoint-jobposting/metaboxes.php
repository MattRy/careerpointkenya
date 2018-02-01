<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 */
namespace WebSavvyMarketing\CareerpointJobPosting;
/**
 * Get the bootstrap!
 */

if ( file_exists( dirname( __FILE__ ) . '/metabox/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/metabox/init.php';
}


add_action( 'cmb2_init', __NAMESPACE__ . '\wsm_register_jobposting_metabox' );
function wsm_register_jobposting_metabox() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_careerpoint_jobposting_';

	/**
	 * Metabox to be displayed on a single page ID
	 */
	$cmb_jobposting = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Job Posting Schema Detail:', 'careerpoint-jobposting' ),
		'object_types' => array( 'post' ),
		'context'      => 'normal',
		'priority'     => 'high',
		'show_names'   => true, 
		'taxonomies'	=> array('type'),
	) );
	
	$cmb_jobposting->add_field( array(
		'name' => __( 'Base Salary', 'careerpoint-jobposting' ),
		'desc' => __('No currency symbol needed.', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'base_salary',
		'type' => 'text_small',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Salary Currency', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'salary_currency',
		'type'    => 'radio_inline',
		'options' => array(
			'USD' => __( 'USD', 'careerpoint-jobposting' ),
			'KES' => __( 'KES', 'careerpoint-jobposting' ),
			'EUR' => __( 'EUR', 'careerpoint-jobposting' ),
		),
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Base Salary Units', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'base_salary_units',
		'type' => 'radio_inline',
		'options' => array(
			'YEAR'   => __( 'YEAR', 'careerpoint-jobposting' ),
			'MONTH'  => __( 'MONTH', 'careerpoint-jobposting' ),
			'WEEK'   => __( 'WEEK', 'careerpoint-jobposting' ),			
			'HOUR'   => __( 'HOUR', 'careerpoint-jobposting' ),		
		),
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Date Posted', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'date_posted',
		'type' => 'text_date',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Education Requirements', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'education_requirements',
		'type' => 'textarea',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Employment Type', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'employment_type',
		'type' => 'radio_inline',
		'options' => array(
			'FULL_TIME'   => __( 'Full Time', 'careerpoint-jobposting' ),
			'PART_TIME'   => __( 'Part Time', 'careerpoint-jobposting' ),
			'CONTRACTOR'     => __( 'Contract', 'careerpoint-jobposting' ),
			'TEMPORARY'     => __( 'Temporary', 'careerpoint-jobposting' ),
			'VOLUNTEER'     => __( 'Volunteer', 'careerpoint-jobposting' ),
			'INTERN'     => __( 'Intern', 'careerpoint-jobposting' ),
			'PER_DIEM'     => __( 'Per Diem', 'careerpoint-jobposting' ),
			'OTHER'     => __( 'Other', 'careerpoint-jobposting' ),
		),
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Estimated Salary', 'careerpoint-jobposting' ),
		'desc' => __('No currency symbol needed.', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'estimated_salary',
		'type' => 'text_small',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Experience Requirements', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'experience_requirements',
		'type' => 'textarea',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Hiring Organization', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'hiring_organization',
		'type' => 'text',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Incentive Compensation', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'incentive_compensation',
		'type' => 'text',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Industry', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'industry',
		'type' => 'text',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Job Benefits', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'job_benefits',
		'type' => 'textarea',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Job Location-Locality', 'careerpoint-jobposting' ),
		'desc' => __('City', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'job_location_locality',
		'type' => 'select',
		'show_option_none' => true,
		'options' => array(
			'Nairobi' => __( 'Nairobi', 'careerpoint-jobposting' ),
			'Mombasa' => __( 'Mombasa', 'careerpoint-jobposting' ),
			'Kisumu' => __( 'Kisumu', 'careerpoint-jobposting' ),
			'Eldoret' => __( 'Eldoret', 'careerpoint-jobposting' ),
			'Nyeri' => __( 'Nyeri', 'careerpoint-jobposting' ),
			'Thika' => __( 'Thika', 'careerpoint-jobposting' ),
			'Nakuru' => __( 'Nakuru', 'careerpoint-jobposting' ),
		),
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Job Location-Region', 'careerpoint-jobposting' ),
		'desc' => __('Country', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'job_location_region',
		'type' => 'select',
		'show_option_none' => true,
		'options' => array(
			'Kenya' => __( 'Kenya', 'careerpoint-jobposting' ),
			'Uganda' => __( 'Uganda', 'careerpoint-jobposting' ),
			'Tanzania' => __( 'Tanzania', 'careerpoint-jobposting' ),
		),
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Job Location-PostalCode', 'careerpoint-jobposting' ),
		'desc' => __('Postal Code', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'job_location_postal_code',
		'type' => 'text',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Job Location-Street Address', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'job_location_street_address',
		'type' => 'text',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Occupational Category', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'occupational_category',
		'type' => 'select',
		'show_option_none' => true,
		'options' => array(
			'Accounting' => __( 'Accounting', 'careerpoint-jobposting' ),
			'Auditing' => __( 'Auditing', 'careerpoint-jobposting' ),
			'Agriculture' => __( 'Agriculture', 'careerpoint-jobposting' ),
			'Airline' => __( 'Airline', 'careerpoint-jobposting' ),
			'Administration' => __( 'Administration', 'careerpoint-jobposting' ),
			'Banking' => __( 'Banking', 'careerpoint-jobposting' ),
			'Customer Service' => __( 'Customer Service', 'careerpoint-jobposting' ),
			'Communication' => __( 'Communication', 'careerpoint-jobposting' ),
			'Government' => __( 'Government', 'careerpoint-jobposting' ),
			'Credit Control' => __( 'Credit Control', 'careerpoint-jobposting' ),
			'Driving' => __( 'Driving', 'careerpoint-jobposting' ),
			'Engineering' => __( 'Engineering', 'careerpoint-jobposting' ),
			'Graduate' => __( 'Graduate', 'careerpoint-jobposting' ),
			'Graphics Designer' => __( 'Graphics Designer', 'careerpoint-jobposting' ),
			'Hotel' => __( 'Hotel', 'careerpoint-jobposting' ),
			'Human Resource' => __( 'Human Resource', 'careerpoint-jobposting' ),
			'IT' => __( 'IT', 'careerpoint-jobposting' ),
			'Internships' => __( 'Internships', 'careerpoint-jobposting' ),
			'Insurance' => __( 'Insurance', 'careerpoint-jobposting' ),
			'Legal' => __( 'Legal', 'careerpoint-jobposting' ),
			'Logistics' => __( 'Logistics', 'careerpoint-jobposting' ),
			'Management Trainee' => __( 'Management Trainee', 'careerpoint-jobposting' ),
			'Media' => __( 'Media', 'careerpoint-jobposting' ),
			'Medical' => __( 'Medical', 'careerpoint-jobposting' ),
			'Nutritionist' => __( 'Nutritionist', 'careerpoint-jobposting' ),
			'NGO' => __( 'NGO', 'careerpoint-jobposting' ),
			'Procurement' => __( 'Procurement', 'careerpoint-jobposting' ),
			'Public Relations' => __( 'Public Relations', 'careerpoint-jobposting' ),
			'Quantity Surveyor' => __( 'Quantity Surveyor', 'careerpoint-jobposting' ),
			'Quality Assurance' => __( 'Quality Assurance', 'careerpoint-jobposting' ),
			'Sales & Marketing' => __( 'Sales & Marketing', 'careerpoint-jobposting' ),
			'Social Work' => __( 'Social Work', 'careerpoint-jobposting' ),
			'Scholarships' => __( 'Scholarships', 'careerpoint-jobposting' ),
			'Security' => __( 'Security', 'careerpoint-jobposting' ),
			'Teaching' => __( 'Teaching', 'careerpoint-jobposting' ),
			'Tours & Travel' => __( 'Tours & Travel', 'careerpoint-jobposting' ),
			'Nursing' => __( 'Nursing', 'careerpoint-jobposting' ),
			'Warehouse & Stores' => __( 'Warehouse & Stores', 'careerpoint-jobposting' ),
			'UN' => __( 'UN', 'careerpoint-jobposting' ),
			'University' => __( 'University', 'careerpoint-jobposting' ),
		),
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Qualifications', 'careerpoint-jobposting' ),
		'desc' => __( 'Qualifications needed for this role.', 'careerpoint-jobposting' ),				
		'id'   => $prefix . 'qualifications',
		'type' => 'textarea',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Responsibilities', 'careerpoint-jobposting' ),
		'desc' => __( 'Job responsibilities associated with this role.', 'careerpoint-jobposting' ),		
		'id'   => $prefix . 'responsibilities',
		'type' => 'textarea',
	) );

	$cmb_jobposting->add_field( array(
		'name' => __( 'Skills', 'careerpoint-jobposting' ),
		'desc' => __( 'Skills required to fulfill this role.', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'skills',
		'type' => 'textarea',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Special Commitments', 'careerpoint-jobposting' ),
		'desc' => __( 'Any special commitments associated with this job posting. Valid entries include VeteranCommit, MilitarySpouseCommit, etc.', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'special_commitments',
		'type' => 'text',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Title', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'title',
		'type' => 'text',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Valid Through', 'careerpoint-jobposting' ),
		'desc' => __( 'The date after when the item is not valid. For example the end of an offer, salary period, or a period of opening hours.', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'valid_through',
		'type' => 'text_date',
	) );
	$cmb_jobposting->add_field( array(
		'name' => __( 'Work Hours', 'careerpoint-jobposting' ),
		'desc' => __( 'The typical working hours for this job (e.g. 1st shift, night shift, 8am-5pm).', 'careerpoint-jobposting' ),
		'id'   => $prefix . 'work_hours',
		'type' => 'text',
	) );
}