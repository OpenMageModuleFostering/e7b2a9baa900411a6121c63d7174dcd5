<?php
class Mediotype_Core_Helper_Acl extends Mage_Core_Helper_Abstract
{

    public function isAllowed($controller, $action = null, $moduleName = null)
    {
        $aclPath = $this->getAclPath($controller, $action, $moduleName);
        Mage::log($aclPath, null, "acl.log");
        return Mage::getSingleton('admin/session')
            ->isAllowed($aclPath);
    }

    protected function getAclPath($controller, $action = null, $moduleName = null)
    {
        /** @var $helper Mediotype_Core_Helper_Data */
        $helper = Mage::helper("mediotype_core");

        $controllerName = $controller;
        if (is_null($moduleName)) {
            $controllerName = strtolower($controller->getRequest()->getControllerName());
            $moduleName = strtolower($controller->getRequest()->getModuleName());
        }

        if (is_null($action)) {
            $action = $helper->explodeCamelCase($controller->getRequest()->getActionName());
            $action = strtolower(implode("/", $action));
        } elseif (is_array($action)) {
            $action = implode("/", $action);
        }

        $aclPath = "$moduleName/$controllerName/$action";

        return $aclPath;
    }
}