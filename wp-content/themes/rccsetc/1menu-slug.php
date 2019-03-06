<?php 
/*--------ADD MENU----------------*/
function register_my_menus() {
  register_nav_menus(
    array(
	  'bachelor-interior-design' => __( 'Bachelor of Interior Design' ),
          'academy-design' => __( 'Academy of Design' ),
	  'faculty-engineering-technology-computing' => __( 'Faculty of Engineering Technology & Computing' ),
          'about-menu' => __( 'About Menu' ),
	  'admissions' => __( 'Admissions' ),
	  'international-students' => __( 'International Students' ),
	  'resources' => __( 'Resources' ),
	  'contact-us' => __( 'Contact us' ),
	  'programs' => __( 'Programs' ),
	  'news-events' => __( 'News events' ),
          'bachelor-of-business-information-systems' => __( 'Bachelor of Business Information Systems' ),
	  'bachelor-of-technology' => __( 'Bachelor of Technology' ),
	  'electronics-engineering-technology-diploma' => __( 'Electronics Engineering Technology Diploma' ),
	  'electronics-engineering-technician-diploma' => __( 'Electronics Engineering Technician Diploma' ),
	  'footer-menu-program' => __( 'Footer menu Program' ),
	  
	  'mobile-programs' => __( 'Mobile Programs' )
	  
    )
  );
}
add_action( 'init', 'register_my_menus' );
/*-------------END ADD MENU-------------------*/
?>