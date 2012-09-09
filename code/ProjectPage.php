<?php

class ProjectPage extends Page {

	// One to many relationship with Contact object
	public static $has_many = array(
		//'Projects' => 'Project'
	);
 

}
class ProjectPage_Controller extends Page_Controller {
static $allowed_actions = array(
        'show'
    );
	public function init() {
		parent::init();
		Requirements::css("project/css/project.css");
			
		
	}
	public function getoldProjects() {
	$projects = Project::get();
	return $projects;
	}
	
	public function getProject(){
		$Params = $this->getURLParams();
		
		if(is_numeric($Params['ID']) && $project = DataObject::get_by_id('Project', $Params['ID']))
		{		
			return $project;
		}
		
	}
	function show() 
	{		
		if($project = $this->getProject())
		{
			$Data = array(
				'Project' => $project
			);
			
			//return our $Data to use on the page
			return $this->Customise($Data)->renderWith(array('TheProject', 'Page'));
		}
		else
		{
			//Staff member not found
			return $this->httpError(404, 'Sorry that callout could not be found');
		}
				
	}
	
	
	
	
	
	
}