<?php

class rex_xform_value_showvalue extends rex_xform_value_abstract
{

	function enterObject()
	{

		if ($this->getValue() == '' && !$this->params['send'])
		{
			$this->setValue($this->getElement(3));
		}


		$class = $this->getHTMLClass();
		$classes = $class;
		
		$classes = (trim($classes) != '') ? ' class="'.trim($classes).'"' : '';

		
		
    $before = '';
    $after = '';    
    $label = ($this->getElement(2) != '') ? '<label'.$classes.' for="' . $this->getFieldId() . '">' . rex_i18n::translate($this->getElement(2)) . '</label>' : '';	
		$field = '<input type="hidden" name="'.$this->getFieldName().'" value="'.htmlspecialchars(stripslashes($this->getValue())).'" />';
		$field .= '<input'.$classes.' id="'.$this->getFieldId().'" type="text" disabled="disabled" value="'.htmlspecialchars(stripslashes($this->getValue())).'" />';
		$extra = '';
    $html_id = $this->getHTMLId();
    $name = $this->getName();
    
    
		$f = new rex_fragment();
		$f->setVar('before', $before, false);
		$f->setVar('after', $after, false);
		$f->setVar('label', $label, false);
		$f->setVar('field', $field, false);
		$f->setVar('extra', $extra, false);
		$f->setVar('html_id', $html_id, false);
		$f->setVar('name', $name, false);
		$f->setVar('class', $class, false);
		
		$fragment = $this->params['fragment'];
		$this->params["form_output"][$this->getId()] = $f->parse($fragment);
		

		$this->params["value_pool"]["email"][$this->getElement(1)] = stripslashes($this->getValue());

	}
	
	function getDescription()
	{
		return "showvalue -> Beispiel: showvalue|login|Loginname|defaultwert";
	}
}

?>