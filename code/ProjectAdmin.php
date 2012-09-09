<?php
class ProjectAdmin extends ModelAdmin {
 
	public static $managed_models = array(
			
		'Project',
		'Task',	
		'WorkLog',
		'Score',
		'HSEA',
		'Financial',
		'Service',
		'Impact'
		
	);
	 
	static $url_segment = 'pm';
	static $menu_title = 'PM';
	static $menu_priority = 1; 
}