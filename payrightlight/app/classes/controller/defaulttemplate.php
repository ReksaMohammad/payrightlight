<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Controller Class for Default Template
 *
 * @author     Irvandy Goutama
 * @copyright  (c) 2011-2012 Payright Systems
 *
 * This file is not to be viewed by anyone except by the intended author above.
 * If you are able to see the content of this file, you are now warned and required to close the file immediately.
 * No lines of code can be changed or reproduced from this file.
 */
 
 class Controller_DefaultTemplate extends Controller_Template
  {
     public $template = 'templates/default';

     /**
      * Initialize properties before running the controller methods (actions),
      * so they are available to our action.
      */
	  
     public function before()
      {	// Revised on 22 August 2015. This so we can avoid error because of time-out or non-existing account
		if (!Auth::instance() || !Auth::instance()->logged_in())
		{	//$this->template->content = View::factory('not_logged_in');
			Request::current()->redirect('home/notloggedin');
		}
		
		if(!Auth::instance()->get_user()->active)
		{	Request::current()->redirect('home/accountinactive');
		}
		$lang = Auth::instance()->get_user()->lang;
			i18n::lang($lang);
		
		// Added 4 March 2017, this is to track any access to any menu.
		//$menu_access_storage = new Model_MenuAccessStorage();
		//$menu_access_storage->saveMenuAccess($this->request->controller(), $this->request->action(), $this->request->param('id'));
		
		if(Auth::instance()->get_user()->menu_version == 2)
			$this->template = 'metronic_templates/default';
		
		// Run anything that need to run before this.
		 parent::before();
		
		 include_once Kohana::find_file('classes', "library/string.lib");
		include_once Kohana::find_file('classes', "library/array.lib");
		 include_once Kohana::find_file('classes', 'library/limit_access.lib'); 
		 // include_once Kohana::find_file('classes', 'library/cryption.lib');
		  include_once Kohana::find_file('classes', 'library/tutorial.lib');
		 include_once Kohana::find_file('classes', 'library/date.lib');
		 include_once Kohana::find_file('classes', 'library/payright_counting_wage.lib');
		 
		 if($this->auto_render)
		  { $this->template->title            = 'Payright Services';
			$this->template->meta_keywords    = 'Payright Automated Mass Payroll Indonesia';
			$this->template->meta_description = "Beta for Payright Services - Payroll System Consultant";
			$this->template->meta_copywrite   = '';
			$this->template->header           = '';
			$this->template->content          = '';
			$this->template->footer           = '';
			$this->template->styles           = array();
			$this->template->scripts          = array();
		  }
	  
		if($this->auto_render)
		{	// Check for authorization from the user_menu before continuing 
			$user_menus = new Model_UserMenu();
			
			$array_of_exception_menus = array('welcome', 'invalid', 'referrer');
			$this_controller = $this->request->controller();
			$company_id = Session::instance()->get('company_id');
				
			$user_view_lock								=	new Model_UserViewLock();
			$view_lock									=	new Model_ViewLock();
			
			$user_id = Auth::instance()->get_user()->id;
			$this->template->menu_version = Auth::instance()->get_user()->menu_version;
			$this->template->tutorial_list = '';
					
			$temp_user_view_lock = $user_view_lock->getOneLockedUserViewLockByUserID($user_id);
			
			if (!empty($temp_user_view_lock) && $temp_user_view_lock['mark_as_unlocked'] == 0)
			{	$temp_view_lock = $view_lock->getOneLockedViewLockByID($temp_user_view_lock ['view_lock_id']);
				
				$temp_valid_path_name = $temp_view_lock ['valid_path_name'];
				$temp_valid_action_names = $temp_view_lock ['valid_action_names'];
				$temp_valid_action_names_explode = explode (";", $temp_valid_action_names);
				$temp_default_path_action = $temp_view_lock ['default_path_action'];
					if ($temp_valid_path_name != $this_controller)
					{	Request::current()->redirect($temp_default_path_action);
					}	
					else 
					{	$this_action = 	$this->request->action();
						if (!in_array($this_action, $temp_valid_action_names_explode))
							Request::current()->redirect($temp_default_path_action);
					}						
					$this->template->menu 			  = '';						
			}
			else if(empty($this_controller) || 
				in_array($this_controller, $array_of_exception_menus) || 
				$user_menus->checkOneUserMenuFromPath(Auth::instance()->get_user()->id, $this_controller))
			{	if(Auth::instance()->get_user()->menu_version == 2)
				{	$this->template->menu = Menu::factory('metronic');	
					$this->template->horizontal_menu = Menu::factory('metronic-horizontal');
					
					$menu_lists = new Model_MenuList();
					if($this_controller == 'welcome')
						$this_controller = 'home';
					$this->template->one_menu_info = $menu_lists->getOneMenuListFromPath($this_controller);
				}	
				else if(Auth::instance()->get_user()->menu_version == 1)
				{	$this->template->menu = Menu::factory('newnav');
					
					// Added 3 Aug 2015.
					// This one is to add a navigation on some of the mono type
					$menu_lists = new Model_MenuList();
					$one_menu = $menu_lists->getOneMenuListFromPath($this_controller);
					
					if(!empty($one_menu))
					{	$arr_valid_for_auto = array('System', 'Company', 'Viewer', 'MultipleEmployees');
						if(in_array($one_menu['mono_menu_type'], $arr_valid_for_auto))
						{	$link_string = http_build_query(array('mono_menu_type'=>$one_menu['mono_menu_type'], 'target_menu'=>$this_controller), '', '&');
							$link_string = encryptHTML($link_string);
							$this->template->monomenuheader = Request::factory('defaulttemplatemonomenuheader/index/'.$link_string)->execute();
						}
					}
					
					// Added on 18 September 2018
					/*
					if(Auth::instance()->get_user()->tutorial_on)
					{	$link_string = http_build_query(array('controller'=>$this_controller, 'company_id'=>$company_id), '', '&');
						$this->template->tutorial_list = Request::factory('tutorialcontentajax/tutorialcontentlist/'.$link_string)->execute();
					}*/
				}
				else
				{	$this->template->menu = Menu::factory();
					// Added on 18 September 2018
					/*
					if(Auth::instance()->get_user()->tutorial_on)
					{	$link_string = http_build_query(array('controller'=>$this_controller, 'company_id'=>$company_id), '', '&');
						$this->template->tutorial_list = Request::factory('tutorialcontentajax/tutorialcontentlist/'.$link_string)->execute();
					}*/
				}
				 // Added on 27 Feb 2016. This is to bypass every other menus and display important notes
				 /*
				if(!empty($company_id))
				{	$company_important_notes = new Model_CompanyImportantNotes();
					$this->template->important_notes = $company_important_notes->getListOfCompanyImportantNotesByCompanyAndMenu($company_id, $this_controller, date('Y-m-d'), date('Y-m-d'));
				}*/
			}
			else
			{	Request::current()->redirect('invalid/menu');
			}
		}
      }

     /**
      * Fill in default values for our properties before rendering the output.
      */
     public function after()
      {
         if($this->auto_render)
          {	// Define defaults
			$styles                  = array(MEDSHORTCUT.'css/tooltip.css'=>'screen',
											  MEDSHORTCUT.'css/style.css'=>'screen',
											  MEDSHORTCUT.'css/menu_style.css'=>'screen',
											  MEDSHORTCUT.'css/component.css'=>'screen',
											  MEDSHORTCUT.'css/tutorial.css'=>'screen',
											  MEDSHORTCUT.'css/overlay.css'=>'screen',
											  MEDSHORTCUT.'css/font-awesome.min.css'=>'screen',
											  MEDSHORTCUT.'css/font-awesome-animation.min.css'=>'screen',
												MEDSHORTCUT.'js/dhtmlxcalendar/dhtmlxcalendar.css'=>'screen',
												MEDSHORTCUT.'css/style2.css'=>'screen',
												MEDSHORTCUT.'css/style3-icon.css'=>'screen',
												MEDSHORTCUT.'css/style4-body.css'=>'screen',
											  );
											  
			if(Auth::instance()->get_user()->menu_version == 2)
			{	$styles[MEDSHORTCUT.'metronic/vendors/base/vendors.bundle.css'] = 'screen';
				$styles[MEDSHORTCUT.'metronic/base/style.bundle.css'] = 'screen';
				$styles[MEDSHORTCUT.'metronic/vendors/custom/fullcalendar/fullcalendar.bundle.css'] = 'screen';
				
			}							  
            
			$scripts				  = array(MEDSHORTCUT.'js/dropdown.js',
											  MEDSHORTCUT.'js/ajax_change.js',
										      MEDSHORTCUT.'js/text.js',
											  MEDSHORTCUT.'js/dhtmlxcalendar/dhtmlxcalendarv20180824.js',
											  MEDSHORTCUT.'js/modernizr.custom.js',
											  MEDSHORTCUT.'js/crisscross.js',
											  MEDSHORTCUT.'js/validation.js',
											  MEDSHORTCUT.'js/Post.js',
											  MEDSHORTCUT.'js/Ajax.js',
											  MEDSHORTCUT.'js/element.js',
											  MEDSHORTCUT.'js/date.js',
											  MEDSHORTCUT.'js/topinfo.js',
												MEDSHORTCUT.'js/currency.js',
												MEDSHORTCUT.'js/script2.js',
												MEDSHORTCUT.'js/highcharts.js',
												MEDSHORTCUT.'js/chart.js',
											  //MEDSHORTCUT.'js/timeout.js',	
											  );
			 if(Auth::instance()->get_user()->menu_version == 2)
			{	$scripts[] = MEDSHORTCUT.'metronic/app/js/dashboard.js';
				$scripts[] = MEDSHORTCUT.'metronic/vendors/custom/fullcalendar/fullcalendar.bundle.js';
				$scripts[] = MEDSHORTCUT.'metronic/base/scripts.bundle.js';
				$scripts[] = MEDSHORTCUT.'metronic/vendors/base/vendors.bundle.js';
			}
			 
			 
			 
			 // Add defaults to template variables.
             $this->template->styles  = array_reverse(array_merge($this->template->styles, $styles));
             $this->template->scripts = array_reverse(array_merge($this->template->scripts, $scripts));
           }

         // Run anything that needs to run after this.
         parent::after();
      }
 }
