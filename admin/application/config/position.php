<?php

    $sql_position=$this->db->query("SELECT * FROM " . DB_PREFIX . "layout_module WHERE `position` IN ('top_left','top_right','header_left','header_right','header_center','menu_left','menu_main','menu_right')");
    $this->lang->load('position/layout');
if($sql_position->num_rows == 0){ 
    // define themes user position custom
    $themes_not_use_position = $data['themes_not_use_position'] = array('default');
    // Define position custom
    /* @params
        group: (string) group the position
        boss:(string) Zone website.
        full_width: (boolean) Full width of group
        position_id:(string) is id use to show module in position
        position_name:(String) Name of position
        position_description:(String) Description of position
        layout: (boolean): if is true the position show all layout  
    */
$position = $data['mb_position'] = array(
    array(
        'group' => 'top-header',
        'boss' => 'theme_header',
        'position' => array(
            array(
                'position_id' => 'top',
                'position_name' => $this->lang->line('text_top1'),
                'position_description' => $this->lang->line('text_descripotion_all'),
                'full_width' => false,
                'layout' => true,
            ),
            array(
                'position_id' => 'header',
                'position_name' => $this->lang->line('text_top2'),
                'position_description' => $this->lang->line('text_descripotion_all'),
                'full_width' => false,
                'layout' => true,
            ),
            array(
                'position_id' => 'menu_header',
                'position_name' => $this->lang->line('text_menu'),
                'position_description' => $this->lang->line('text_descripotion_all'),
                'full_width' => false,
                'layout' => true,
            ),
            array(
                'position_id' => 'custom_top',
                'position_name' => $this->lang->line('text_slide'),
                'position_description' => $this->lang->line('text_descripotion_layout'),
                'full_width' => false,
                'layout' => false,
            )
        )
    ),
                       
                    
    // Default position OC ---------------------------------------------------------------------  
    // B?n không du?c xóa cung nhu ch?nh s?a b?t c? gì trong array này;
    array(
               'group'=>'Default OC',
               'boss'=>'default_oc',
               'position'=>array()
        ),
    // Footer Position ---------------------------------------------------------------------
    array(
        'group' => 'footer',
        'boss' => 'theme_footer',       
        'position' => array(
            array(
                'position_id' => 'custom_bottom',
                'position_name' => $this->lang->line('text_content_buttom2'),
                'position_description' => $this->lang->line('text_descripotion_all'),
                'full_width' => false,
                'layout' => false,
            ),
            array(
                'position_id' => 'footer_top',
                'position_name' => $this->lang->line('text_footer_top'),
                'position_description' => $this->lang->line('text_descripotion_all'),
                'full_width' => false,
                'layout' => true,
            ),           
            array(
                'position_id' => 'footer_bottom',
                'position_name' => $this->lang->line('text_footer_bottom'),
                'position_description' => $this->lang->line('text_descripotion_all'),
                'full_width' => false,
                'layout' => true,
            ),
        )
    )
);
}else{
// define themes user position custom
$theme_use_position=$data['themes_use_position']=array('Mb_Themes','default');
// define position custom
/* @params
	position_id:(string) is id use to show module in position
	position_name:(String) Name of position
	position_description: Description of position
	layout: (boolen): if is true the position show all layout
	group: (string) group the position
	boss:(string) group on layout.
*/
$position=$data['mb_position']=array(
                        array(
                            'position_id'=>'top_left',
                            'position_name' => $this->lang->line('text_top1'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'top-header',
                            'boss'=>'theme_header',
                        ),
                        array(
                            'position_id'=>'top_right',
                            'position_name' => $this->lang->line('text_top2'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'top-header',
                            'boss'=>'theme_header',
                        ),
                        array(
                            'position_id'=>'header_left',
                            'position_name' => $this->lang->line('top_column_left'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'header',
                            'boss'=>'theme_header',
                        ),
                    
                        array(
                            'position_id'=>'header_center',
                            'position_name' => $this->lang->line('top_column_center'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'header',
                            'boss'=>'theme_header',
                        ),
                    
                        array(
                            'position_id'=>'header_right',
                            'position_name' => $this->lang->line('top_column_right'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'header',
                            'boss'=>'theme_header',
                        ),
                        array(
                            'position_id'=>'menu_left',
                            'position_name' => $this->lang->line('text_menu_left'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'menu',
                            'boss'=>'theme_header',
                        ),
                        array(
                            'position_id'=>'menu_main',
                            'position_name' => $this->lang->line('text_menu_center'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'menu',
                            'boss'=>'theme_header',
                            ),
                        array(
                            'position_id'=>'menu_right',
                            'position_name' => $this->lang->line('text_menu_right'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'menu',
                            'boss'=>'theme_header',
                            ),
                    array(
                            'position_id'=>'content_slider',
                            'position_name' => $this->lang->line('text_slide'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>false,
                            'group'=>'content',
                            'boss'=>'theme_header',
                        ), 
                    array(
                            'position_id'=>'custom_top',
                            'position_name' => $this->lang->line('text_content_top_once'),
                            'position_description'=>'V? trí này Hi?n th? theo layout',
                            'layout'=>false,
                            'group'=>'content',
                            'boss'=>'theme_header',
                        ), 
                    // Footer ---------------------------------------------------------------------
                    array(
                            'position_id'=>'custom_bottom',
                            'position_name' => $this->lang->line('text_content_buttom2'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>false,
                            'group'=>'content',
                            'boss'=>'theme_footer',
                        ),
                        array(
                            'position_id'=>'FooterTop1',
                            'position_name' => $this->lang->line('text_footer_top_col1'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'footer_top',
                            'boss'=>'theme_footer',
                        ),
                        array(
                            'position_id'=>'FooterTop2',
                            'position_name'=>'Chân trang trên, c?t 2',
                            'position_name' => $this->lang->line('text_footer_top_col2'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'footer_top',
                            'boss'=>'theme_footer',
                        ),
                        array(
                            'position_id'=>'FooterTop3',
                            'position_name' => $this->lang->line('text_footer_top_col3'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'footer_top',
                            'boss'=>'theme_footer',
                            ),
                        array(
                            'position_id'=>'FooterCenter1',
                            'position_name' => $this->lang->line('text_between_footer_col1'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'footer_center',
                            'boss'=>'theme_footer',
                        ),
                        array(
                            'position_id'=>'FooterCenter2',
                            'position_name' => $this->lang->line('text_between_footer_col2'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'footer_center',
                            'boss'=>'theme_footer',
                        ),
                        array(
                            'position_id'=>'FooterCenter3',
                            'position_name' => $this->lang->line('text_between_footer_col3'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'footer_center',
                            'boss'=>'theme_footer',
                            ),
                        array(
                            'position_id'=>'FooterCenter4',
                            'position_name' => $this->lang->line('text_between_footer_col4'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'footer_center',
                            'boss'=>'theme_footer',
                            ),
                        array(
                            'position_id'=>'Footercopy1',
                            'position_name' => $this->lang->line('text_copyright'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'footer_copyright',
                            'boss'=>'theme_footer',
                            ),
                        array(
                            'position_id'=>'Footercopy2',
                            'position_name' => $this->lang->line('text_identified'),
                            'position_description' => $this->lang->line('text_descripotion_all'),
                            'layout'=>true,
                            'group'=>'footer_copyright',
                            'boss'=>'theme_footer',
                            ),
                );   
}