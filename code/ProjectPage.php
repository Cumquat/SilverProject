<?php

class ProjectPage extends Page {

	// One to many relationship with Contact object
	public static $has_many = array(
		//'Projects' => 'Project'
	);
 

}
class ProjectPage_Controller extends Page_Controller {
static $allowed_actions = array(
        'show',
		'add',
		'addProjectForm',
		'editProjectForm',
		'edit',
		'approveForm',
		'addTaskForm'
    );
	public function init() {
		parent::init();
		Requirements::css("project/css/project.css");

	


	}
	public function getoldProjects() {
	$projects = Project::get()->sort('DueDate');
	return $projects;
	}
	
	public function getProject(){
		$Params = $this->getURLParams();
		
		if(is_numeric($Params['ID']) && $project = DataObject::get_by_id('Project', $Params['ID']))
		{		
			return $project;
		}
		
	}
	public function getProjectID(){
		$Params = $this->getURLParams();
		
		if(is_numeric($Params['ID']) && $project = DataObject::get_by_id('Project', $Params['ID']))
		{		
			return $project->ID;
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
			return $this->httpError(404, 'Sorry that Project could not be found');
		}
				
	}
	function edit() 
	{		
		if($project = $this->getProject())
		{
			$Data = array(
				'Project' => $project
			);
			
			//return our $Data to use on the page
			return $this->Customise($Data)->renderWith(array('EditProject', 'Page'));
		}
		else
		{
			//Staff member not found
			return $this->httpError(404, 'Sorry that Project could not be found');
		}
				
	}
	public function addLink(){
		return  'projects/add/'; 
			
	}
	
	function add() {
	
		return $this->renderWith(array('AddProject', 'Page'));
		
	}
	function themachine() {
	$hostname = $_SERVER['REMOTE_ADDR'];
	
	return $hostname;
	}
	

	
	public function addProjectForm() {
		
			$project = Score::get()->map('ID', 'Title');
			$impact = Impact::get()->map('ID', 'Title');
	 		$requester	= Member::get()->map('ID', 'Title');
			
			DateField::set_default_config('showcalendar', true);
			DateField::set_default_config('dateformat', 'dd/MM/YYYY');
			
			
			$fields = new FieldList(
			new LiteralField ("LiteralField","<div class='addForm'>" ),
				new LiteralField ("LiteralField","<div class='formleft'>" ),
					new TextField('Title'),
					new TextField('ShortDescription','One Liner'),
					new DateField('DueDate', 'Due Date'),
					new DropDownField('RequesterID','Requested By',$requester),
				new LiteralField ("LiteralField","</div>" ),
					new LiteralField ("LiteralField","<div class='formright'>" ),
						new TextAreaField('Description','Description'),
					new LiteralField ("LiteralField","</div>" ),
				new LiteralField ("LiteralField","<div class='formleft'>" ),
					new LiteralField ("LiteralField","<div class='info'>" ),
					new LiteralField ("LiteralField","<div class='checkboxes'>" ),
						new CheckboxSetField('Scores','Check Boxes',$project),
					new LiteralField ("LiteralField","</div>" ),
					new LiteralField ("LiteralField","<div class='checkboxes'>" ),
						new CheckboxSetField('Impacts','Impacts',$impact),
					new LiteralField ("LiteralField","</div>" ),
					new LiteralField ("LiteralField","</div>" ),
				new LiteralField ("LiteralField","</div>" ),
			new LiteralField ("LiteralField","</div>" )
				
				
			);
         
       $actions = new FieldList(
	   new LiteralField ("LiteralField","<div class='addForm'>" ),
		new LiteralField ("LiteralField","<div class='formright'>" ),
			new FormAction('doprojectadd', 'Submit'),
		new LiteralField ("LiteralField","</div>" ),
		new LiteralField ("LiteralField","</div>" )
		);
		
		return new Form($this, 'addProjectForm', $fields,  $actions);
		}
	
	function doprojectadd($data, $form) {
		$submission  = new Project();
		$submission ->write();
		$form->saveInto($submission );
		$submission ->write();
      	Controller::curr()->redirectBack();
		}
	
	
	//////////////////
	
	
		function editProjectForm(){
		$project = $this->getProject();		
		$score = Score::get()->map('ID', 'Title');
		$impact = Impact::get()->map('ID', 'Title');
	 	$requester	= Member::get()->map('ID', 'Title');
		
			DateField::set_default_config('showcalendar', true);
			DateField::set_default_config('dateformat', 'dd/MM/YYYY');
			
			$fields = new FieldList(
			new HiddenField('ID', 'aID'),
			new LiteralField ("LiteralField","<div class='addForm'>" ),
				new LiteralField ("LiteralField","<div class='formleft'>" ),
					new TextField('Title'),
					new TextField('ShortDescription','One Liner'),
					new DateField('DueDate', 'Due Date'),
					new DropDownField('RequesterID','Requested By',$requester),
				new LiteralField ("LiteralField","</div>" ),
					new LiteralField ("LiteralField","<div class='formright'>" ),
						new TextAreaField('Description','Description'),
					new LiteralField ("LiteralField","</div>" ),
				new LiteralField ("LiteralField","<div class='formleft'>" ),
					
					new LiteralField ("LiteralField","<div class='checkboxes'>" ),
						new CheckboxSetField('Scores','Check Boxes',$score),
					new LiteralField ("LiteralField","</div>" ),
					new LiteralField ("LiteralField","<div class='checkboxes'>" ),
						new CheckboxSetField('Impacts','Impacts',$impact),
					new LiteralField ("LiteralField","</div>" ),
				new LiteralField ("LiteralField","</div>" ),
			new LiteralField ("LiteralField","</div>" )
			
			);
		
		
		$actions = new FieldList(
		new LiteralField ("LiteralField","<div class='addForm'>" ),
		new LiteralField ("LiteralField","<div class='formright'>" ),
			new FormAction("dosave", "Save"),
		new LiteralField ("LiteralField","</div>" ),
		new LiteralField ("LiteralField","</div>" )
		);
		$form = new Form($this, 'editProjectForm', $fields, $actions);
		$Params = $this->getURLParams();
		if(is_numeric($Params['ID']) && $editproj = DataObject::get_by_id('Project', $Params['ID']))
		$form->loadDataFrom($editproj->data());
			
		return $form;
		
	}
	function dosave($data, $form){
		
		$theID = $_POST["ID"];
		$project = DataObject::get_by_id("Project", $theID);
		$form->saveInto($project);
		$project->write();

			Controller::curr()->redirect("projects/show"  . '/' .$theID);
		
	}
	function approveForm(){
		$project = $this->getProject();		
		
			$fields = new FieldList(
			new HiddenField('ID', '', $this->getProjectID()	),
			new HiddenField('Status', '', 'Approved')
			
			);
		
		$actions = new FieldList(
			new FormAction("doapprove", "Approve")
		);

		$form = new Form($this, 'approveForm', $fields, $actions);
		
			
		return $form;
		
	}
	function doapprove($data, $form){
		
		$theID = $_POST["ID"];	
		$project = DataObject::get_by_id("Project", $theID);
		$form->saveInto($project);
		$project->write();

			Controller::curr()->redirectBack();
		
	}
	public function addTaskForm() {
	 		
			$theproj = $this->getProjectID();
							
			DateField::set_default_config('showcalendar', true);
			DateField::set_default_config('dateformat', 'dd/MM/YYYY');
			
			$fields = new FieldList(
			new LiteralField ("LiteralField","<h3>Add a Task</h3>" ),
			new HiddenField( 'ProjectID', '', $theproj),
			new LiteralField ("LiteralField","<table class='standard'>" ),
			new LiteralField ("LiteralField","<thead>" ),
			new LiteralField ("LiteralField","<tr>" ),
			new LiteralField ("LiteralField","<th class='form450'>Title</th>" ),
			new LiteralField ("LiteralField","<th class='form90'>Due Date</th>" ),
			new LiteralField ("LiteralField","<th class='form450'>Description</th>" ),
			new LiteralField ("LiteralField","<th class='form90'>Hours Est.</th>" ),
			new LiteralField ("LiteralField","<th>&nbsp;</th>" ),
			new LiteralField ("LiteralField","</tr>" ),
			new LiteralField ("LiteralField","</thead>" ),
			new LiteralField ("LiteralField","<tbody>" ),
			new LiteralField ("LiteralField","<tr>" ),
			new LiteralField ("LiteralField","<td>" ),
				new TextField( 'Title', ''),
			new LiteralField ("LiteralField","</td>" ),
			new LiteralField ("LiteralField","<td>" ),
				new DateField('DueDate', ''),
			new LiteralField ("LiteralField","</td>" ),
				new LiteralField ("LiteralField","<td>" ),
				new TextAreaField('Description', ''),
			new LiteralField ("LiteralField","</td>" ),
				new LiteralField ("LiteralField","<td class='hours'>" ),
				new NumericField('OriginalHourEstimate', '','0'),
			new LiteralField ("LiteralField","</td>" )
			
			
			
        );
         
       $actions = new FieldList(
	   new LiteralField ("LiteralField","<td>" ),
			new FormAction('doTaskadd', 'Submit'),
			new LiteralField ("LiteralField","</td>" ),
			new LiteralField ("LiteralField","</tr>" ),
			new LiteralField ("LiteralField","<tbody>" ),
			new LiteralField ("LiteralField","</table>" )
		);
		
		return new Form($this, 'addTaskForm', $fields,  $actions);
		}
	
	function doTaskadd($data, $form) {
		$submission  = new Task();
		$submission ->write();
		$form->saveInto($submission );
		$submission ->write();
      	Controller::curr()->redirectBack();
		}
	
	
	
	
}