<?php $skin_color = 'light'; ?>
				<!-- BEGIN: Aside Menu -->
					<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-<?php echo $skin_color;?> m-aside-menu--submenu-skin-<?php echo $skin_color;?> m-scroller" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500">
						<ul class="m-menu__nav ">
							
							<?php 
								$arr_mono_menu_type_icons = array('SingleEmployee'=>'flaticon-user-ok',
											  'MultipleEmployees'=>'flaticon-users',
											  'Core'=>'flaticon-interface-8',
											  'System'=>'flaticon-edit-1',
											  'Company'=>'flaticon-suitcase',
											  'Import'=>'flaticon-add',
											  'Recruitment'=>'flaticon-user-add',
											  'New Company'=>'flaticon-file-1',
											  'Loan'=>'flaticon-coins',
											  );
								
								foreach ($menu['items'] as $mono_menu_type=>$groups): 
								
								//echo '<!--<li class="m-menu__section m-menu__section--first">
								//	<h4 class="m-menu__section-text">Department</h4>
								//	<i class="m-menu__section-icon flaticon-more-v2"></i>
								//</li>-->';
								
								if(count($groups['type_items']) > 1) 
								{	echo '<li class="m-menu__item  m-menu__item--'.(!empty($groups['menu_active']) ? 'active' : 'submenu').'" aria-haspopup="true" m-menu-submenu-toggle="hover"><a href="javascript:;" class="m-menu__link m-menu__toggle gap-js"><i class="m-menu__link-icon '.(isset($arr_mono_menu_type_icons[$mono_menu_type]) ? $arr_mono_menu_type_icons[$mono_menu_type] : '').'"></i><span class="m-menu__link-text">'.__($mono_menu_type).'</span><i class="m-menu__ver-arrow la la-angle-right"></i>
										<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
											<ul class="m-menu__subnav">';
											
												 foreach ($groups['type_items'] as $mono_menu_group=>$items): 
													if(count($items['group_items']) > 1) 
														{	echo '<li class="m-menu__item  m-menu__item--'.(!empty($items['menu_active']) ? 'active' : 'submenu').'" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1"><a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon '.(!empty($items['group_items'][key($items['group_items'])]['mono_menu_icon']) ? $items['group_items'][key($items['group_items'])]['mono_menu_icon'] : '').'"></i><span
																	 class="m-menu__link-text">'.__($mono_menu_group).'</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>
																<div class="m-menu__submenu "><span class="m-menu__arrow"></span>
																	<ul class="m-menu__subnav">';
															foreach ($items['group_items'] as $the_item):
																		echo '<li class="m-menu__item  m-menu__item--'.(!empty($the_item['menu_active']) ? 'active' : 'submenu').'" aria-haspopup="true" m-menu-link-redirect="1"><a href="'.url::site($the_item['path']).'" class="m-menu__link "><i class="m-menu__link-icon '.(!empty($the_item['mono_menu_icon']) ? $the_item['mono_menu_icon'] : '').'"></i><span class="m-menu__link-text">'.__($the_item['name']).'</span></a></li>';
															endforeach;
																echo '</ul>
															</div>
														</li>';
													 }
													 else {
														echo '<li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="'.url::site($items['group_items'][0]['path']).'" class="m-menu__link "><i class="m-menu__link-icon '.(!empty($items['group_items'][0]['mono_menu_icon']) ? $items['group_items'][0]['mono_menu_icon'] : '').'"></i><span class="m-menu__link-text"><span class="m-menu__link-text">'.__($items['group_items'][0]['name']).'</span></a></li>';
													 }
												endforeach; 
									echo '</ul>
										</div>
									</li>';
								}
								else
								{	$the_group_key = key($groups['type_items']);
									echo '<li class="m-menu__item " aria-haspopup="true" m-menu-link-redirect="1"><a href="'.url::site($groups['type_items'][$the_group_key]['group_items'][0]['path']).'" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon '.(isset($groups['type_items'][$the_group_key]['group_items'][0]['mono_menu_icon']) ? $groups['type_items'][$the_group_key]['group_items'][0]['mono_menu_icon'] : '').'"></i><span class="m-menu__link-text">'.__($mono_menu_type).'</span></a></li>';
								}
							endforeach;?>
						
						</ul>
					</div>

					<!-- END: Aside Menu -->




