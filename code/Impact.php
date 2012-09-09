<?php
class Impact extends DataObject {
	//database
	public static $db = array(
		'Title' => 'Varchar',
		'Value' => "Enum('0,1,2,3,4,5','0')",
		
		
	
	);
	public static $has_one = array();
	public static $has_many = array(
		
	);
	public static $many_many = array(); 
	public static $belongs_many_many = array(
			'Projects' => 'Project'
	); 

	
	
}