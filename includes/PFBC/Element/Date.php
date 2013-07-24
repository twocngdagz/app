<?php
class Element_Date extends Element_Textbox {
	protected $jQueryOptions;
	
	public function jQueryDocumentReady() {
		parent::jQueryDocumentReady();
		if(!$this->attributes['datetime'] && !$this->attributes['time'])
		echo 'jQuery("#', $this->attributes["id"], '").datepicker(', $this->jQueryOptions(), ');';
		if($this->attributes['datetime'])
		echo 'jQuery("#', $this->attributes["id"], '").datetimepicker(', $this->jQueryOptions(), ');';
		if($this->attributes['time'])
		echo 'jQuery("#', $this->attributes["id"], '").timepicker(', $this->jQueryOptions(), ');';
	}

	public function render() {
		$this->validation[] = new Validation_Date;
		parent::render();
	}
}
