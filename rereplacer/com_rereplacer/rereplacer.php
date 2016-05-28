<?php
/**
 * @package         ReReplacer
 * @version         7.0.1
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2016 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_rereplacer'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

require_once JPATH_LIBRARIES . '/regularlabs/helpers/functions.php';

RLFunctions::loadLanguage('com_rereplacer');

jimport('joomla.filesystem.file');

// return if Regular Labs Library plugin is not installed
if (!JFile::exists(JPATH_PLUGINS . '/system/regularlabs/regularlabs.php'))
{
	$msg = JText::_('RR_REGULAR_LABS_LIBRARY_NOT_INSTALLED')
		. ' ' . JText::sprintf('RR_EXTENSION_CAN_NOT_FUNCTION', JText::_('COM_REREPLACER'));
	JFactory::getApplication()->enqueueMessage($msg, 'error');

	return;
}

// give notice if Regular Labs Library plugin is not enabled
$regularlabs = JPluginHelper::getPlugin('system', 'regularlabs');
if (!isset($regularlabs->name))
{
	$msg = JText::_('RR_REGULAR_LABS_LIBRARY_NOT_ENABLED')
		. ' ' . JText::sprintf('RR_EXTENSION_CAN_NOT_FUNCTION', JText::_('COM_REREPLACER'));
	JFactory::getApplication()->enqueueMessage($msg, 'notice');
}

// load the Regular Labs Library language file
RLFunctions::loadLanguage('plg_system_regularlabs');

$controller = JControllerLegacy::getInstance('ReReplacer');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

