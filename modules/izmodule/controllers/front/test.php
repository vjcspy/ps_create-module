<?php

/**
 * Created by khoild@smartosc.com/mr.vjcspy@gmail.com
 * User: vjcspy
 * Date: 06/04/2016
 * Time: 15:56
 */
/*TODO: tên class controller của presta shop: tên_module + contrller+ModuleFrontController/ Và phải extends ModuleFrontController
 */

class IzModuleTestModuleFrontController extends ModuleFrontController {

    /**
     *
     */
    public function initContent() {
        echo 'abc';
        parent::initContent();
    }
}