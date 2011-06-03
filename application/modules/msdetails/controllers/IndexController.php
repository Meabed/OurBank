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
class Msdetails_IndexController extends Zend_Controller_Action
{
    public function init() 
    {
    	$this->view->title = "Savings";
	$this->view->pageTitle = "Member savings details";
	$this->view->type='savings';
        $this->view->savingsModel = new Msdetails_Model_msdetails ();
        //$this->view->cl = new App_Model_Users ();
        $this->view->adm = new App_Model_Adm ();

        $globalsession = new App_Model_Users();
        $this->view->globalvalue = $globalsession->getSession();// get session values
        $this->view->createdby = $this->view->globalvalue[0]['id'];
        $this->view->username = $this->view->globalvalue[0]['username'];

        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data)
        {
            $this->_redirect('index/login');
        }
    }

    public function indexAction() 
    {
	$this->view->form = new Msdetails_Form_Search();
    }
    public function msdetailsAction()
    {
	$accNum = $this->view->accNum = $this->_request->getParam('accNum');
	$this->view->details = $this->view->savingsModel->search($this->_request->getParam('accNum'));
	$this->view->tran = $this->view->savingsModel->transaction($this->_request->getParam('accNum'));
        $Balance = $this->view->savingsModel->getbalance($accNum);
                foreach($Balance as $balances){
                    $this->view->balance =  $balance = $balances['Balance'];
                }
	$form = new Msdetails_Form_msdetails($this->view->accNum);
	$this->view->form = $form;
	$mode = $this->view->adm->viewRecord("ourbank_master_paymenttypes","id","DESC");
	foreach($mode as $mode) {
            $form->transactionMode->addMultiOption($mode['id'],$mode['name']);
	}
	//if group members
	if (substr($accNum,4,1) == 2 or substr($accNum,4,1) == 3) {
             $this->view->groupmember=$this->view->savingsModel->groupmember($accNum);
	}

    }
    public function messageAction() 
    {
        $this->view->amt = base64_decode($this->_request->getParam('amt'));
        $this->view->accNum = base64_decode($this->_request->getParam('accNum'));
    }
}
