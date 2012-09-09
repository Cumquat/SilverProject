
<?php

class ProjectPage extends Page {

	// One to many relationship with Contact object
	public static $has_many = array(
		'Projects' => 'Project'
	);

// Create Grid Field
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$gridFieldConfig = GridFieldConfig::create()->addComponents(
			//new GridFieldToolbarHeader(),
			//new GridFieldAddNewButton('toolbar-header-right'),
			//new GridFieldSortableHeader(),
			new GridFieldDataColumns(),
			new GridFieldPaginator(10),
			new GridFieldEditButton(),
			new GridFieldDeleteAction(),
			new GridFieldDetailForm()
		);
		$fields->removeByName("Metadata"); 
		$fields->removeByName("Content"); 
		$gridField = new GridField("Projects", "Project list:", $this->Projects(), $gridFieldConfig);
		$fields->addFieldToTab("Root.Main", $gridField);
		
		return $fields;
	}

}
class ProjectPage_Controller extends Page_Controller {
public static $allowed_actions = array (
	);
	public function init() {
		parent::init();
		//Requirements::css("framework/css/GridField.css");
		Requirements::css("project/css/grid.css");		
		
	}
	
	 function ProjectForm() {

        $formName = 'ProjectForm';
        $config = GridFieldConfig_RecordEditor::create(25); 
        $config->addComponents(new GridFieldExportButton());
        $itemsInGrid = $this->Projects(); // get a list of object you want to show
        
        $gridField = new GridField("MyProjects", "List of Projetcs", $itemsInGrid, $config);
        
        $fields = new FieldList($gridField);
        $actions = new FieldList();
        $form = new Form($this, $formName, $fields, $actions);
        return $form;
    }
}