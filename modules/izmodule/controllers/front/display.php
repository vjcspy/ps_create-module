<?php

/**
 * Đây là controller của prre
 * User: vjcspy
 * Date: 06/04/2016
 * Time: 15:25
 */
class izmoduledisplayModuleFrontController extends ModuleFrontController {

    public function initContent() {
        parent::initContent();
        $this->setTemplate('display.tpl');
    }
}