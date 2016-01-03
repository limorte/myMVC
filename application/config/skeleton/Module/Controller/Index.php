<?php
/**
 * Index.php
 *
 * @package myMVC
 * @copyright ueffing.net
 * @author Guido K.B.W. Üffing <info@ueffing.net>
 * @license GNU GENERAL PUBLIC LICENSE Version 3. See application/doc/COPYING
 */

/**
 * @name ${module}Controller
 */
namespace {module}\Controller;

/**
 * Index
 * 
 * @implements \MVC\MVCInterface\Controller
 */
class Index implements \MVC\MVCInterface\Controller
{
	/**
	 * Session Object
	 * 
	 * @var \MVC\Session
	 * @access protected
	 */
	protected $_oMVCSession;
	
	/**
	 * routing array for current page
	 * 
	 * @var array
	 * @access protected
	 */
	protected $_aRoutingCurrent = array();

	/**
	 * Event Object
	 * 
	 * @var \{module}\Event\Index
	 * @access protected
	 */
	protected $_o{module}EventIndex;
	
	/**
	 * View Object
	 * 
	 * @var {module}_View_Index
	 * @access public
	 */
	public $o{module}ViewIndex;

	/**
	 * Model Object
	 * 
	 * @var {module}_Model_Index 
	 * @access protected
	 */
	protected $_o{module}ModelIndex;

	/**
	 * this method is autom. called by MVC_Application->runTargetClassBeforeMethod()
	 * in very early stage
	 * 
	 * @access public
	 * @static
	 */
	public static function __preconstruct ()
	{
		// start event listener
		\{module}\Event\Index::getInstance ();
	}
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct ()
	{
		$this->_oMVCSession = \MVC\Registry::get('MVC_SESSION');
		$this->_aRoutingCurrent = \MVC\Registry::get('MVC_ROUTING_CURRENT');
		
		$this->_o{module}ModelIndex = new \{module}\Model\Index ();
		$this->o{module}ViewIndex = new \{module}\View\Index();

		// Standard Title
		$this->o{module}ViewIndex->assign ('sTitle', '{module}');
	}

	/**
	 * index
	 * 
	 * @access public
	 * @return void
	 */
	public function index ()
	{
		// Set Value in sContent Var
		$this->o{module}ViewIndex->assignValue ($this->o{module}ViewIndex->loadTemplateAsString ('index/index.tpl'));
	}
	
	/**
	 * Destrucor
	 * 
	 * @access public
	 * @return void
	 */
	public function __destruct ()
	{
		$this->o{module}ViewIndex->render ();
	}	
}
