<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Mapme
 * @author     Chuyen Trung Tran <chuyentt@gmail.com>
 * @copyright  2018 Chuyen Trung Tran
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Mapme', JPATH_COMPONENT);
JLoader::register('MapmeController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Mapme');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
