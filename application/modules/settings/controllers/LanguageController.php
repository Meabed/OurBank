<?php
/*
############################################################################
#  This file is part of OurBank.
############################################################################
#  OurBank is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as
#  published by the Free Software Foundation, either version 3 of the
#  License, or (at your option) any later version.
############################################################################
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
############################################################################
#  You should have received a copy of the GNU Affero General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
############################################################################
*/
?>

<?php
class settings_LanguageController extends Zend_Controller_Action 

{
    public function init() 
    {
        $this->view->pageTitle='Settings';
    }

    public function indexAction()
    {	
	   $settingsForm = new settings_Form_Settings();
	   $this->view->form = $settingsForm;
	   $settingModel=new settings_Model_Setting();
	   $allLanguage=$settingModel->fetchAllLanguage();
	   foreach($allLanguage as $eacharraysent) 
           {
	   $this->view->form->languages->addMultiOption($eacharraysent['language_id'],$eacharraysent['langauge_name']);
	   }
    }
}

