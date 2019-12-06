<?php
class WCM_optionlist{
	
    /*
    * @Fucntion to create main option
    * @Dragable option on form page dashboard
    */
    public static function WCM_form_menu_dragable_option_array() {
            return array(
                    'Dragable Fields' => 
					array(
						'Text',
						'Paragraph Text',
						'Drop Down',
						'Multi Select',
						'Number',
						'Checkboxes',
						'Radio Buttons',
						'Hidden',
						'HTML',
						'Email',
						'Phone',
						'State',
						'ZipCode',
						'File',
						'Multiple Files',
					)


            );

    }


}




 