<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Mapme
 * @author     Chuyen Trung Tran <chuyentt@gmail.com>
 * @copyright  2018 Chuyen Trung Tran
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_mapme'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Mapme', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('MapmeHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'mapme.php');

$controller = JControllerLegacy::getInstance('Mapme');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
