<?php

// This is the code which will be placed in the head section

// No direct access.
defined('_JEXEC') or die;

$this->API->addCSS($this->API->URLtemplate() . '/css/mobile/smartphone.css');
// include JavaScript
$this->API->addJS($this->API->URLtemplate() . '/js/mobile/zepto.js');
$this->API->addJS($this->API->URLtemplate() . '/js/mobile/gk.smartphone.js');
// remove mootools and other template scripts
$k2option = JRequest::getCmd('option');

if($k2option != 'com_k2') {
	GKParser::$customRules['/<script type="text\/javascript">(.*?)<\/script>/mis'] = '';
	GKParser::$customRules['/<script type="text\/javascript" src="(.*?)media\/system\/js(.*?)"><\/script>/mi'] = '';
}