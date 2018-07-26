<?php

if (!defined('_PS_VERSION_')) {
	exit;
}

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class FreshLetterPrint extends Module implements WidgetInterface {

	private $templateFile;

	function __construct() {
		$this->name    = 'freshletterprint';
		$this->tab     = 'front_office_features';
		$this->version = '1.0.0';
		$this->author  = 'goldminer1030';
		$this->need_instance = 0;
		parent::__construct();
		$this->bootstrap   = true;
		$this->displayName = $this->l( 'Fresh Letter Print Module' );
		$this->description = $this->l( 'With this module, you will be able to generate a letter with  your favorite style(font, color, size).' );

		$this->templateFile = 'module:freshletterprint/freshletterprint.tpl';
	}

	function install() {
		return parent::install()
					 && Configuration::updateValue('FRESH_LETTER_VISIBLE', 1)
					 && $this->registerHook('header')
					 && $this->registerHook('displayProductAdditionalInfo')
			;
	}

	public function getContent() {
		$output = '';
		if (Tools::isSubmit('submitFreshLetterPrint')) {
			Configuration::updateValue('FRESH_LETTER_VISIBLE', (int)Tools::getValue('FRESH_LETTER_VISIBLE'));

			$this->_clearCache($this->templateFile);

			$output .= $this->displayConfirmation($this->trans('Settings updated.', array(), 'Admin.Notifications.Success'));

			Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules', true).'&conf=6&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name);
		}

		$helper = new HelperForm();
		$helper->submit_action = 'submitFreshLetterPrint';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array('fields_value' => $this->getConfigFieldsValues());

		$fields = array();
		$fields[] = array(
			'type' => 'switch',
			'label' => 'Show letter module?',
			'name' => 'FRESH_LETTER_VISIBLE',
			'values' => array(
				array(
					'id' => 'FRESH_LETTER_active_on',
					'value' => 1,
					'label' => $this->trans('Enabled', array(), 'Admin.Global')
				),
				array(
					'id' => 'FRESH_LETTER_active_off',
					'value' => 0,
					'label' => $this->trans('Disabled', array(), 'Admin.Global')
				)
			)
		);

		return $output.$helper->generateForm(array(
			array(
				'form' => array(
					'legend' => array(
						'title' => $this->displayName,
						'icon' => 'icon-share'
					),
					'input' => $fields,
					'submit' => array(
						'title' => $this->trans('Save', array(), 'Admin.Actions')
					)
				)
			)
		));
	}

	public function getConfigFieldsValues()
	{
		$values = array();
		$values['FRESH_LETTER_VISIBLE'] = (int)Tools::getValue('FRESH_LETTER_VISIBLE', Configuration::get('FRESH_LETTER_VISIBLE'));

		return $values;
	}

	public function hookHeader($param){
		$this->context->controller->registerStylesheet('modules-fresh_letter_print', 'modules/'.$this->name.'/css/style.css', ['media' => 'all', 'priority' => 150]);

		$this->context->controller->registerJavascript('modules-fresh_letter_print', 'modules/'.$this->name.'/js/fresh-letter-print.js', ['position' => 'bottom', 'priority' => 150]);
	}

	public function uninstall()
	{
		$this->_clearCache('*');

		return parent::uninstall();
	}

	public function _clearCache($template, $cache_id = null, $compile_id = null)
	{
		parent::_clearCache($this->templateFile);
	}

	public function renderWidget($hookName, array $params)
	{
		if (!$this->isCached($this->templateFile, $this->getCacheId('freshletterprint'))) {
			$this->smarty->assign($this->getWidgetVariables($hookName, $params));
		}

		return $this->fetch($this->templateFile, $this->getCacheId('freshletterprint'));
	}

	public function getWidgetVariables($hookName, array $params)
	{
		return array(
			'visible' => Configuration::get('FRESH_LETTER_VISIBLE')
		);
	}

}

