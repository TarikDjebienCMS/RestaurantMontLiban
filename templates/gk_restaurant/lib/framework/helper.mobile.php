<?php 

//
// Functions used for Social API and Google Analytics
//

class GKTemplateMobile {
    //
    private $parent;
    //
    function __construct($parent) {
    	$this->parent = $parent;
    }
    // parse mobile version elements
    function mobileParser() {
    	if($this->parent->browser->get('mobile')) {
        	// clear desktop elements
        	GKParser::$customRules['/<gavern:desktop(.*?)gavern:desktop>/mis'] = '';
        	GKParser::$customRules['/<gavern:mobile>/mis'] = '';
        	GKParser::$customRules['/<\/gavern:mobile>/mis'] = '';	
           	if(($this->parent->browser->get('browser') == 'iphone' || $this->parent->browser->get('browser') == 'android') && $this->parent->API->get('mobile_collapsible', '0') == '1') {
            	GKParser::$customRules['/<gavern:gk_collapsible\/>/mis'] = ' class="gkCollapsible"';
            	GKParser::$customRules['/<gavern:gk_collapsible_button\/>/mis'] = '<span class="gkToggle show">Toggle</span>';
            } else {
            	GKParser::$customRules['/<gavern:gk_collapsible\/>/mis'] = ' class="gkFeaturedItemTitle"';
            	GKParser::$customRules['/<gavern:gk_collapsible_button\/>/mis'] = '';
            }
        } else {
        	// clear mobile elements
        	GKParser::$customRules['/<gavern:mobile(.*?)gavern:mobile>/mis'] = '';
        	GKParser::$customRules['/<gavern:desktop>/mis'] = '';
        	GKParser::$customRules['/<\/gavern:desktop>/mis'] = '';
        	GKParser::$customRules['/<gavern:gk_collapsible\/>/mis'] = '';
        	GKParser::$customRules['/<gavern:gk_collapsible_button\/>/mis'] = '';
        }
     }        
}

// EOF