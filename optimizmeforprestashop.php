<?php
/**
 * 2016 - Optimiz.me
 *
 * SEO Optimization
 */

if (!defined('_PS_VERSION_'))
    exit;


/**
 * Load all required files
 */

$tabFoldersAutoload = array('classes');
foreach ($tabFoldersAutoload as $folder){
    foreach (glob(dirname(__FILE__) ."/". $folder ."/*.php") as $filename){
        require_once($filename);
    }
}

class OptimizmeForPrestashop extends Module
{
    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->name = 'optimizmeforprestashop';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Optimiz.me';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);

        parent::__construct();

        $this->displayName = $this->getTranslator()->trans('Optimiz.me for Prestashop', array(), 'Modules.OptimizMeForPrestashop');
        $this->description = $this->getTranslator()->trans('SEO Optimization by Optimiz.me', array(), 'Modules.OptimizMeForPrestashop');
        $this->confirmUninstall = $this->getTranslator()->trans('Etes-vous sur de désintaller ce module ?', array(), 'Modules.OptimizMeForPrestashop');


		/////////////////////////////////////
		// core ajax request
		/////////////////////////////////////

		$optMeCore = new OptimizMeCore();
		$optMeCore->rootAction();

		/////////////////////////////////////
		// REDIRECTIONS
		//  - if necessary, redirect
		/////////////////////////////////////

		//$optMeRedirect = new OptimizMeRedirections();

		/////////////////////////////////////////
		// FRONT-OFFICE
		//  - add meta description if necessary
		/////////////////////////////////////////

		//$optFo = new OptimizMeFO();

    }



    /**
     * @return bool
     */
    public function install()
    {
        // enregistrement du hook (DESINSTALLER ET REINSTALLER CE MODULE SI CELA CHANGE !)
        // ou (probablement) passer par "Modules et Services >> Positions"
        return (parent::install() && $this->registerHook('displayBeforeBodyClosingTag') && $this->registerHook('header'));
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        if (!parent::uninstall() || !Configuration::deleteByName('OPTIMIZMEFORPRESTASHOP_NAME'))
            return false;
        return true;
    }


    public function hookHeader($params)
    {
        // css
        $this->context->controller->addCSS(($this->_path).'assets/css/optimizme.css', 'all');

        // js
        $this->context->controller->addJs(($this->_path) .'assets/js/optimizme.js', 'all');
    }


    /**
     * Affichage code de tracking (en bas de page)
     *
     * @param $params
     * @return string
     */
    public function hookDisplayBeforeBodyClosingTag ($params)
    {
        $content = '<script type="text/javascript">
                        var codeTracking = "test";
                    </script>';

        return $content;
    }

}
