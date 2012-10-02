<?php
/**
 * Adds extra fields for team members.
 * 
 *
 * 
 */
class MemberProjectExtension extends DataExtension {

	public static $db = array(
		'DefaultNum'  => 'Varchar(40)',
	);
	
	
	public static $has_many = array(
	'Projects' => 'Project'
	);




}