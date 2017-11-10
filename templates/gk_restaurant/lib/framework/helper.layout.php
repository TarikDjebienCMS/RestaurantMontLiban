<?php 

//
// Functions used in layouts
//

class GKTemplateLayout {
    //
    private $parent;
    // APIs from the parent to use in the loadBlocks functions
    public $API;
    public $cache;
    public $social;
    public $utilities;
    public $menu;
    public $mootools;
    // access to the module styles
    public $module_styles;
    //
    function __construct($parent) {
    	$this->parent = $parent;
    	$this->API = $parent->API;
    	$this->cache = $parent->cache;
    	$this->social = $parent->social;
    	$this->utilities = $parent->utilities;
    	$this->menu = $parent->menu;
    	$this->mootools = $parent->mootools;
    	$this->module_styles = $parent->module_styles;
    }
	// function to load specified block
	public function loadBlock($path) {
	    jimport('joomla.filesystem.file');
	    
	    if(JFile::exists($this->API->URLtemplatepath() . DS . 'layouts' . DS . 'blocks' . DS . $path . '.php')) { 
	        include($this->API->URLtemplatepath() . DS . 'layouts' . DS . 'blocks' . DS . $path . '.php');
	    }
	}
	// function to generate columns block
    public function generateColumnsBlock($amount, $base_name, $group_id, $start_num) {
        // returns:
        // array(
        //    [number] => array(
        //          "class" => // class of the position
        //          "width" => // width of the position
        //          "name" => // name of the position
        //    ),
        //    ...
        // )
        
        // read settings
        $column_settings = json_decode($this->API->get('positions', ''));
        // if the template is installed first time
        if(!$column_settings) {
        	$json_data = JFile::read($this->API->URLtemplatepath() . DS . 'admin' . DS . 'elements' . DS . 'positions.json');
        	$column_settings = json_decode($json_data); 
        }
        // possible classes: gkColLeft, gkColRight, gkColCenter, gkColFull
        $amount_of_columns = 0;
        // column existing
        $columns = array();
        $columns_width = array();
        $free_space = 0;
        // check how many columns you have to generate
        for($i = 0; $i < $amount; $i++) {
            if($this->API->modules($base_name . ($i + $start_num))) {
                $columns[$i] = true;
                $columns_width[$i] = $column_settings->default->{$group_id}[$i];
                $amount_of_columns++;
            } else {
                $columns[$i] = false;
                $columns_width[$i] = 0;
                $free_space += $column_settings->default->{$group_id}[$i];
            }
        }
        
        // if any column exists
        if($amount_of_columns > 0) {
            // variable to store column width
            $column_width = '100';
            // check if more than one column exists
            if($amount_of_columns > 1) {
                //
                $first_add = floor($free_space / $amount_of_columns);
                //
                for($j = 0; $j < count($columns); $j++) {
                	if($columns[$j]) {
                		$columns_width[$j] += $first_add;
                	}
                }
                //
                if($free_space - ($first_add * $amount_of_columns) > 0) {
            		//
            		$to_add = $free_space - ($first_add * $amount_of_columns);
					//
            		for($j = 0; $j < count($columns) && $to_add > 0; $j++) {
            			if($columns[$j]) {
            				$columns_width[$j] += 1;
							$to_add -= 1;
            			}
            		}
                }
                //    
                $result = array();
                $added_amount = 0;
                //   
                for($i = 0; $i < $amount; $i++) {
                    if(isset($columns[$i])) {
                        $added_amount++;
                        $column_class = ($added_amount == 1) ? 'gkColLeft' : (($added_amount == $amount_of_columns) ? 'gkColRight' : 'gkColCenter');
                        $result[$i-$start_num] = array(
                            "class" => $column_class,
                            "width" => $columns_width[$i],
                            "name" => $base_name . ($i + $start_num)
                        );
                    }
                }   
            } else {
                $active_index = $start_num;
                
                for($i = $start_num; $i <= $amount + ($start_num - 1); $i++) {
                    if(isset($columns[$i]) && $columns[$i] == true) $active_index = $i;
                }
                
                $result = array(
                                "0" => array(
                                        "class" => 'gkColFull',
                                        "width" => '100',
                                        "name" => $base_name . $active_index
                                    )
                                );
            }

            return $result;
        } else { // if any column exists - return null
            return null;
        }
    }

    // function to generate columns widths
    public function generateColumnsWidth() {
        // read the column settings
        $column_settings = json_decode($this->API->get('positions', '')); 
        // if the template is installed a first time
        if(!$column_settings) {
        	$json_data = JFile::read($this->API->URLtemplatepath() . DS . 'admin' . DS . 'elements' . DS . 'positions.json');
        	$column_settings = json_decode($json_data); 
        }
        // header column
        if($this->API->modules('banner1 and banner2')) {
        	$this->API->addCSSRule('#gkBanner1 { width: ' . $column_settings->default->banners[0] . '%; }');
        	$this->API->addCSSRule('#gkBanner2 { width: ' . $column_settings->default->banners[1] . '%; }');
        } else {
        	$this->API->addCSSRule('#gkBanner1, #gkBanner2 { width: 100%; }');
        }  
        // all columns
        $left_column = $this->API->modules('left');
        $right_column = $this->API->modules('right');
        $ratio = 0;
        $gkContentWidth = 0;
        
        if($left_column && $right_column) {
        	$this->API->addCSSRule('#gkLeft { width: ' . $column_settings->default->main[0] . '%; }');
        	$this->API->addCSSRule('#gkRight { width: ' . $column_settings->default->main[4] . '%; }');
        	$this->API->addCSSRule('#gkContent { width: ' . (100 - ($column_settings->default->main[0] +  $column_settings->default->main[4])) . '%; }');
        	$gkContentWidth = (100 - ($column_settings->default->main[0] +  $column_settings->default->main[4]));
        } elseif ( $left_column ) {
        	$this->API->addCSSRule('#gkLeft { width: ' . $column_settings->default->main[0] . '%; }');
        	$this->API->addCSSRule('#gkContent { width: ' . (100 - $column_settings->default->main[0]) . '%; }');
        	$gkContentWidth = (100 - $column_settings->default->main[0]);
        } elseif ( $right_column ) {
        	$this->API->addCSSRule('#gkRight { width: ' . $column_settings->default->main[4] . '%; }');
        	$this->API->addCSSRule('#gkContent { width: ' . (100 - $column_settings->default->main[4]) . '%; }');
        	$gkContentWidth = (100 - $column_settings->default->main[4]);
        } else {
        	$this->API->addCSSRule('#gkContent { width: 100%; }');
        	$gkContentWidth = 100;
        }
        // main column
        $inset1Width = 0;
        $inset2Width = 0;
        
        if($this->API->modules('inset1 and inset2')) {
        	$this->API->addCSSRule('#gkInset1 { width: ' . ($column_settings->default->main[1] * (100 / $gkContentWidth)) . '%; }');
        	$this->API->addCSSRule('#gkInset2 { width: ' . ($column_settings->default->main[3] * (100 / $gkContentWidth)) . '%; }');
        	$inset1Width = ($column_settings->default->main[1] * (100 / $gkContentWidth));
        	$inset2Width = ($column_settings->default->main[3] * (100 / $gkContentWidth));
        } elseif($this->API->modules('inset1 or inset2')) {
        	if($this->API->modules('inset1')) {
        		$this->API->addCSSRule('#gkInset1 { width: ' . ($column_settings->default->main[1] * (100 / $gkContentWidth)) . '%; }');
        		$inset1Width = ($column_settings->default->main[1] * (100 / $gkContentWidth));
        	} else {
        		$this->API->addCSSRule('#gkInset2 { width: ' . ($column_settings->default->main[3] * (100 / $gkContentWidth)) . '%; }');
        		$inset2Width = ($column_settings->default->main[3] * (100 / $gkContentWidth));
        	}
        }
        // calculate the main column
        $this->API->addCSSRule('#gkComponentWrap { width: ' . (100 - $inset1Width - $inset2Width) . '%; }');
    }
    
    // function to generate blocks paddings
    public function generateLayout($offset) {
    	// set main width
    	$this->API->addCSSRule("#gkPageTop > div, #gkBanners, #gkPage, #gkHeader, #gkBottom2, #gkBg > footer, #gkTop1, #gkTop2 { width: " . $this->API->get('template_width','1240px') . "!important; }\n");
    	// set min-width to avoid problems with bg on smaller screens
    	$this->API->addCSSRule("body { min-width: " . (str_replace('px', '', $this->API->get('template_width','1240px')) + 30) . "px!important; }\n");
    }
    
    // function to check if the page is frontpage
    function isFrontpage() {
        // get all known languages
        $languages	= JLanguage::getKnownLanguages();
        $menu = JSite::getMenu();
        
        foreach($languages as $lang){
            if ($menu->getActive() == $menu->getDefault( $lang['tag'] )) {
            	return true;
            }
        }
    	   
        return false;    
    }

	public function addTemplateFavicon() {
		$favicon_image = $this->API->get('favicon_image', '');
		
		if($favicon_image == '') {
			$favicon_image = $this->API->URLtemplate() . '/images/favicon.ico';
		} else {
			$favicon_image = $this->API->URLbase() . $favicon_image;
		}
		
		$this->API->addFavicon($favicon_image);
	}
	
	public function getTemplateStyle($type) {
		$template_style = $this->API->get("template_color", 1);
		
		if($this->API->get("stylearea", 1)) {
			if(isset($_COOKIE['gk_'.$this->parent->name.'_'.$type])) {
				$template_style = $_COOKIE['gk_'.$this->parent->name.'_'.$type];
			} else {
				$template_style = $this->API->get("template_color", 1);
			}
		}
		
		return $template_style;
	}
}

// EOF