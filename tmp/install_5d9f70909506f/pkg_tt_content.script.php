<?php

defined('_JEXEC') or die();


class pkg_TT_ContentInstallerScript
{
    
    /**
     * Called after any type of action
     *
     * @param     string              $route      Which action is happening (install|uninstall|discover_install)
     * @param     jadapterinstance    $adapter    The object responsible for running this script
     *
     * @return    boolean                         True on success
     */
    public function postflight($route, JAdapterInstance $adapter)
    {
            // Enable module
			$query = "update `#__extensions` set enabled=1 where type = 'module' and element = 'mod_ttcontent'";
			$db = JFactory::getDBO();
			$db->setQuery($query);
			$db->query();
			
			$query= "select id  from `#__modules` where  module like 'mod_ttcontent'";
			$db->setQuery($query);
			$id=$db->loadResult();
			
			$query2 = "select * from `#__modules_menu` where  moduleid=".$id;
			$db->setQuery($query2);
			$result=$db->loadResult();
			if(!$result)
			{
			// Module assignment
			$query = "insert into `#__modules_menu` (menuid, moduleid) select 0 as menuid, id as moduleid from `#__modules`
                        where  module like 'mod_ttcontent'";
			$db->setQuery($query);
			$db->query();
			}
			// Module default location
			$query = "update `#__modules` set position='cpanel',ordering=-1,published=1,access=2 where module = 'mod_ttcontent'";
			$db = JFactory::getDBO();
			$db->setQuery($query);
			$result = $db->query();
			// set the default template
			$db1 = JFactory::getDBO();
			$query1 = "select id from `#__template_styles` where template='theme--200114'";
			$db1->setQuery($query1);
			$tid = $db1->loadResult();
			JLoader::register('TemplatesTableStyle', JPATH_ROOT . '/administrator/components/com_templates/tables/style.php');
			JLoader::register('TemplatesModelStyle', JPATH_ROOT . '/administrator/components/com_templates/models/style.php');
			JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_templates/models/');
			JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_templates/tables/');
			$model = JModelLegacy::getInstance('style', 'TemplatesModel');
			$result=$model->setHome($tid);
			// redirect to control panel
			$app=JFactory::getApplication();
			$app->enqueueMessage('Package Installed Successfully');
			$app->redirect(JRoute::_('index.php'));
			return $result;
			
    }
     
 
}
