<?php

/**
 * Created by khoild@smartosc.com/mr.vjcspy@gmail.com
 * User: vjcspy
 * Date: 06/04/2016
 * Time: 16:48
 */
class AdminGcbulkController extends ModuleAdminController {

    public function __construct() {
        $this->bootstrap = true;
        $this->lang      = (!isset($this->context->cookie) || !is_object($this->context->cookie)) ? intval(
            Configuration::get('PS_LANG_DEFAULT')) : intval($this->context->cookie->id_lang);

        parent::__construct();
    }

    public function display() {

        parent::display();
    }

    public function renderList() {
        $return = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'izmodule/views/templates/admin/adminyourmodule.tpl');

        return $return;
    }
}