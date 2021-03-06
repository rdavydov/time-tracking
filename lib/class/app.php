<?php
/**
 * Tzn Framework
 * 
 * @package tzn_core_classes
 * @author Stan Ozier <framework@tirzen.com>
 * @version 0.3
 * @copyright GNU Lesser General Public License (LGPL) version 3
 */

/**
 * Controller super class (abstract)
 * 
 * All controllers must extend this class
 * @since 0.1
 * @todo constuctor parameter login : could require specific level
 */
abstract class AppController extends Pluginable {

	private $view;
	
	protected $fc;
	protected $page;

	/**
	 * constructor
	 * @param mixed $login is user login required
	 */
	public function __construct($login=false, $iphone=false) {
		parent::__construct();
		
		// get front controller instance
		$this->fc = FrontController::getInstance();
		
		// instantiate page
		$this->page = new PageModel();
		
		// detect iphone
		if (preg_match('/'.APP_IPHONE_AGENT.'/', $_SERVER['HTTP_USER_AGENT']) && !$iphone) {
			NaviHelper::redirect($this->fc->getUrl('iphone'));
		}
		
		// check login ?
		if ($login && APP_SETUP_USER_MODEL) {
			if (!$this->fc->user->isLoggedIn()) {
				if (is_string($login)) {
					if ($this->fc->controller != StringHelper::flatToCamel($login,true) || $this->fc->action != 'login') {
						NaviHelper::redirect($this->fc->getUrl($login,'login'));
					}
				} else {
					NaviHelper::redirect($this->fc->getUrl('login'));
				}
			}
		}
	}
	
	/**
	 * setting the file containing HTML which is sent to the browser
	 */
	protected function setView($view) {
		$this->view = $view;
	}
	
	/**
	 * dispatch controller's action view
	 * @todo if ajaxed, no full header and all
	 * @todo search in other folders, such as plugins
	 */
	protected function view() {
		$this->page->dispatchHeader();
		include APP_VIEW_PATH.$this->view.'.php';
		$this->page->dispatchFooter();
	}
	
	protected function viewXml($encoding='UTF-8') {
		echo '<'.'?xml version="1.0" encoding="'.$encoding.'"?'.">\n";
		include APP_VIEW_PATH.$this->view.'.php';
	}
	
	protected function viewIPhone() {
		$this->page->iphoneHeader();
		include APP_VIEW_PATH.$this->view.'.php';
		$this->page->dispatchFooter();
	}
	
	protected function viewRaw() {
		include APP_VIEW_PATH.$this->view.'.php';
	}
	
	/**
	 * include another view (called within a view)
	 * @todo search in other folders, such as plugins
	 */
	protected function incView($file, $evenOnAjax=true) {
		if ($evenOnAjax || !$this->fc->getReqVar('ajax')) {
			include APP_VIEW_PATH.$file.'.php';
		}
	}
	
	/**
	 * reset Navi::referrers to the current page
	 * this should be called in any top level controller action
	 */
	protected function resetReferrer() {
		$this->fc->setReferrer($this->fc->thisUrl());
	}
	
	/**
	 * any controller must inmplement at least the default action
	 */
	abstract function mainAction();
	
}