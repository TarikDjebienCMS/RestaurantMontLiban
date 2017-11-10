<?php

//
// Functions for menu
//

class GKTemplateMenu {
    //
    private $parent;
    //
    function __construct($parent) {
    	$this->parent = $parent;
    }
	// function to get menu override
	public function getMenuOverride() {
	    // get current ItemID
	    $ItemID = JRequest::getInt('Itemid');
	    // get current option value
	    $option = JRequest::getCmd('option');
	    // override array
	    $menu_overrides = $this->parent->config->get('menu_override');
	    // check the config
	    if (isset($menu_overrides[$ItemID])) {
	        return $menu_overrides[$ItemID];
	    } else {
	        if (isset($menu_overrides[$option])) {
	            return $menu_overrides[$option];
	        } else {
	            return false;
	        }
	    }   
	}
	
	// function to get menu type
	public function getMenuType() {
	    // check the override
	    $is_overrided = $this->getMenuOverride();
	    $menu_type = 'gk_menu';
	    // if current menu is overrided
	    $menu_type = ($is_overrided !== false) ? $is_overrided : $this->parent->API->get('menu_type', 0);
	    // check layout saved in cookie
	    $cookie_name = 'gkGavernMobile_'.$this->parent->name;
	    $cookie = (isset($_COOKIE[$cookie_name])) ? $_COOKIE[$cookie_name] : 'mobile';        
	    if(!$this->parent->browser->get('mobile') || $cookie == 'desktop') {
	    	// check the override
	        $menu_type = 'gk_menu';
	        // if current menu is overrided
	        $menu_type = ($is_overrided !== false) ? $is_overrided : $this->parent->API->get('menu_type', 0);
	    } else {
	        $menu_type = ($this->parent->browser->get('browser') == 'iphone' || $this->parent->browser->get('browser') == 'android') ? 'gk_smartphone' : 'gk_handheld';       
	    }
		// select the menu
		switch ($menu_type) {
	    	case 'gk_smartphone' :
	            	$file = dirname(__file__) . DS . '..' . DS . 'menu' . DS . 'GKSmartphone.php';
	            	if (!is_file($file)) return null;
	            	require_once ($file);
	            	$menuclass = 'GKSmartphone';
	            	$this->parent->config->set('generateSubmenu', false);
				break;
			case 'gk_handheld' :
					$file = dirname(__file__) . DS . '..' . DS . 'menu' . DS . 'GKHandheld.php';
					if (!is_file($file)) return null;
					require_once ($file);
					$menuclass = 'GKHandheld';
					$this->parent->config->set('generateSubmenu', false);
				break;
	        case 'gk_menu':
	                $file = dirname(__file__) . DS . '..' . DS . 'menu' . DS . 'GKMenu.php';
	                if (!is_file($file)) return null;
	                require_once ($file);
	                $menuclass = 'GKMenu';
	                $this->parent->config->set('generateSubmenu', false);
	            break;
	        case 'gk_dropline':
					$file = dirname(__file__) . DS . '..' . DS . 'menu' . DS . 'GKDropline.php';
	                if (!is_file($file)) return null;
	                require_once ($file);
	                $menuclass = 'GKDropline';
	                $this->parent->config->set('generateSubmenu', true);
	            break;
	        case 'gk_split':
					$file = dirname(__file__) . DS . '..' . DS . 'menu' . DS . 'GKSplit.php';
	                if (!is_file($file)) return null;
	                require_once ($file);
	                $menuclass = 'GKSplit';
	                $this->parent->config->set('generateSubmenu', true);
	            break;
	        default:
	            	$file = dirname(__file__) . DS . '..' . DS . 'menu' . DS . 'GKMenu.php';
	            	if (!is_file($file)) return null;
	            	require_once ($file);
	            	$menuclass = 'GKMenu';
	            	$this->parent->config->set('generateSubmenu', false);
	            break;
	    }
	    
	    $gkmenu = new $menuclass($this->parent->APITPL->params);
	    $gkmenu->_tmpl = $this->parent->API;
	    
	    return $gkmenu;
	}
}

// EOF