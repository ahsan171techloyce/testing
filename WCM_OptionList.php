<?php
class WCM_OptionList{
	
    /*
    * @Fucntion to create main option
    * @Dragable option on form page dashboard
    */
    public function WCM_form_menu_dragable_option_array() {
            return array(
                    'Text',
                    'Date',
                    'Phone',
                    'Email'


            );

    }


}
new WCM_OptionList;


 