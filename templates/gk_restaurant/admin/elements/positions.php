<?php

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldPositions extends JFormField
{
	public $type = 'Positions';

	protected function getInput() {
		$jsonsrc = file_get_contents(dirname(__FILE__) . DS . 'positions.json');
		$json = json_decode($jsonsrc);
		
		$html = '<div id="positions_form">';
		
		foreach($json->positions as $name => $arr) {
			$html .= '<fieldset id="positions_form_block_'.$name.'">';
			$html .= '	<legend>'.$name.'</legend>';
			for($i = 0; $i < count($arr); $i++) {
				$html .= '<div id="positions_form_'.$arr[$i].'" class="col-'.count($arr).'">'.$arr[$i].'</div>';
			}
			$html .= '	<div class="form" id="positions_form_block_'.$name.'_form">';
			$html .= '	<div>';
			for($i = 0; $i < count($arr); $i++) {
				$html .= '		<div class="col-'.count($arr).'"><label>'.$arr[$i].'</label><br /><input type="text" id="positions_form_edit_'.$arr[$i].'" /><span>%</span></div>';
			}
			$html .= '	</div>';
			$html .= '	<div class="form-info"><span>'.JText::_('TPL_GK_LANG_CURRENT_WIDTH').'<strong>100%</strong></span> <button class="save">'.JText::_('TPL_GK_LANG_SAVE').'</button></div>';
			$html .= '	</div>';
			$html .= '</fieldset>';
		}
		
		$value = '';
		
		if( htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') != '') {
			$value =  htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8');
		} else {
			$value = $jsonsrc;
		}
		
		$html .= '<textarea name="'.$this->name.'" id="'.$this->id.'">' . $value . '</textarea>';
		$html .= '</div>';
		
		return $html;
	}
}
