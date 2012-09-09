<?php

  
class Project extends DataObject  {
   
 	public static $db = array( 
   		'Title' => 'Varchar()',
		'ShortDescription' => 'Text',
		'Description' => 'HTMLText',
		'Status' => "Enum('Active, Completed, Cancelled, Suspended, Standby, Deleted', 'Active')",
		'Type' => "Enum('Client, Internal, Private, Idea, N.A.', 'N.A.')",
		'Priority' => "Enum('A. (High), B. (Medium), C. (Low), N.A.', 'N.A.')",
		'DueDate' => 'Date'	
	);
	public static $has_one = array(
		'Owner' => 'Member',
		'ProjectPage' => 'ProjectPage'
	);
	public static $has_many = array(
			
	);
	public static $many_many = array(); 
	public static $belongs_many_many = array(); 

	//formatting
	public static $casting = array(); //adds computed fields that can also have a type (e.g. 
	public static $field_labels = array(
		'ShortDescription' => 'Project One liner'
	);
	public static $singular_name = 'Project';
	public static $plural_name = 'Projects';

	static $default_sort = 'Priority, DueDate';
	
	static $searchable_fields = array(
     	
		
   );
	public static $summary_fields = array(
		'ID',
		'Title',
		'Owner.FirstName'
		
		
	); 	
	
	
	
	
}