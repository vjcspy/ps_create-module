<?php
/**
 * Created by IntelliJ IDEA.
 * User: vjcspy
 * Date: 05/04/2016
 * Time: 15:41
 */

if (!defined('_PS_VERSION_'))
    exit;

class IzModule extends Module {

    const MODULE_NAME = 'izmodule';

    public function __construct() {

        $this->name                   = self::MODULE_NAME;
        $this->tab                    = 'front_office_features';
        $this->version                = '1.0.0';
        $this->author                 = 'Le Khoi';
        $this->need_instance          = 0;
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
        $this->bootstrap              = true;

        parent::__construct();

        $this->displayName = $this->l('Iz Module For Test');
        $this->description = $this->l('Presta Shop test module');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get(self::MODULE_NAME))
            $this->warning = $this->l('No name provided');
    }

    public function install() {

        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);

        if (!parent::install() ||
            !$this->registerHook('leftColumn') ||
            !$this->registerHook('header') ||
            !Configuration::updateValue(self::MODULE_NAME, 'my friend')
        )
            return false;

        return true;
    }

    public function uninstall() {

        if (!parent::uninstall() ||
            !Configuration::deleteByName(self::MODULE_NAME)
        )
            return false;

        return true;
    }

    public function getContent() {

        $output = null;

        if (Tools::isSubmit('submit' . $this->name)) {
            $my_module_name = strval(Tools::getValue(self::MODULE_NAME));
            if (!$my_module_name
                || empty($my_module_name)
                || !Validate::isGenericName($my_module_name)
            )
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            else {
                Configuration::updateValue(self::MODULE_NAME, $my_module_name);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }

        return $output . $this->displayForm();
    }

    public function displayForm() {

        // Get default language
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        // Init Fields form array
        $fields_form[0]['form'] = [
            'legend' => [
                'title' => $this->l('Settings'),
            ],
            'input'  => [
                [
                    'type'     => 'text',
                    'label'    => $this->l('Configuration value'),
                    'name'     => self::MODULE_NAME,
                    'size'     => 20,
                    'required' => true
                ]
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'button'
            ]
        ];

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->module          = $this;
        $helper->name_controller = $this->name;
        $helper->token           = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex    = AdminController::$currentIndex . '&configure=' . $this->name;

        // Language
        $helper->default_form_language    = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;

        // Title and toolbar
        $helper->title          = $this->displayName;
        $helper->show_toolbar   = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action  = 'submit' . $this->name;
        $helper->toolbar_btn    = [
            'save' =>
                [
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name .
                        '&token=' . Tools::getAdminTokenLite('AdminModules'),
                ],
            'back' => [
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            ]
        ];

        // Load current value
        $helper->fields_value[self::MODULE_NAME] = Configuration::get(self::MODULE_NAME);

        return $helper->generateForm($fields_form);
    }

    public function hookDisplayLeftColumn($params) {
        /*TODO: assign data to HOOK View */
        $this->context->smarty->assign(
            [
                'my_module_name' => Configuration::get(self::MODULE_NAME),
                'my_module_link' => $this->context->link->getModuleLink(self::MODULE_NAME, 'display')
            ]
        );

        return $this->display(__FILE__, 'lefthook.tpl');
    }

    public function hookDisplayRightColumn($params) {

        return $this->hookDisplayLeftColumn($params);
    }

    public function hookDisplayHeader() {

        $this->context->controller->addCSS($this->_path . 'css/izmodule.css', 'all');
    }
}