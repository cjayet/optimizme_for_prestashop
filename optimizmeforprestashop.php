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
        return (parent::install() && $this->registerHook('displayTopColumn') && $this->registerHook('header'));
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
     * Affichage du configurateur dans la page d'accueil
     *
     * @param $params
     * @return string
     */
    public function hookDisplayTopColumn($params)
    {
        $content = 'test';

        /*
        $content = '';
        $tabProduits = array();
        $tabProduitsResultat = array();
        $tabOptionsProposees = array();
        $prixTotalIndicatif = 0;
        $flagAfficheFormulaireChoixGeneral = 1;
        $flagPossibiliteModifierQuantite = 1;


        $this->context->smarty->assign(
            array(
                'tpl_module_dir' => dirname(__FILE__).'/views/templates/front/'
            )
        );


        // récupération des variables prestashop
        $context = Context::getContext();

        // get cart id if exists
        if ($context->cookie->id_cart)
        {
            $cart = new Cart($this->context->cookie->id_cart);
        }

        // create new cart if needed
        if (!isset($cart) OR !$cart->id)
        {
            $cart = new Cart();
            $cart->id_customer = (int)($this->context->cookie->id_customer);
            $cart->id_address_delivery = (int)  (Address::getFirstCustomerAddressId($cart->id_customer));
            $cart->id_address_invoice = $cart->id_address_delivery;
            $cart->id_lang = (int)($this->context->cookie->id_lang);
            $cart->id_currency = (int)($this->context->cookie->id_currency);
            $cart->id_carrier = 1;
            $cart->recyclable = 0;
            $cart->gift = 0;
            $cart->add();
            $this->context->cookie->id_cart = (int)($cart->id);
            $cart->update();
        }


        /////////////////////////////////////////////
        //  Ajout des articles au panier
        /////////////////////////////////////////////


        if (isset($_POST['ajouterArticlesPanier']) && $_POST['ajouterArticlesPanier'] == 1)
        {
            // l'utilisateur souhaite ajouter dans son panier les articles prescrits par le configurateur;
            foreach ($_POST as $postEntree => $quantite)
            {
                if (strstr($postEntree, 'addpanier_produit_'))
                {
                    // récupération de l'id du produit
                    $idProduitAdd = str_replace('addpanier_produit_', '', $postEntree);

                    // ajout dans le panier
                    //$cart->updateQty((int)$quantite, (int)$idProduitAdd);
                    $cart->updateQty((int)$quantite, (int)$idProduitAdd, $id_product_attribute = null, $id_customization = false, $operator = 'up', $id_address_delivery = 0, $shop = null, $auto_add_cart_rule = true);
                }

                // enregistrement du panier
                $cart->update();
                $cart->save();

            }

            $content .= '<div class="alert alert-success" style="clear: both" rel="no-follow">
                            Articles ajoutés au panier
                        </div>';
        }



        /////////////////////////////////////////////
        //  envoi depuis la saisie directe
        /////////////////////////////////////////////



        if (isset($_POST['envoi-calculateur']) && $_POST['envoi-calculateur'] == 1)
        {
            // s'assure que les quantités soient bien des nombres entiers
            $_POST['NbrKit160DS'] = NatureConfortConfigurateur::inputValueSanitize($_POST['NbrKit160DS'], 1);
            $_POST['NbrKit290DS'] = NatureConfortConfigurateur::inputValueSanitize($_POST['NbrKit290DS'], 1);
            $_POST['option-cdl-1'] = NatureConfortConfigurateur::inputValueSanitize($_POST['option-cdl-1'], 1);
            $_POST['option-cdl-2'] = NatureConfortConfigurateur::inputValueSanitize($_POST['option-cdl-2'], 1);
            $_POST['option-cdl-3'] = NatureConfortConfigurateur::inputValueSanitize($_POST['option-cdl-3'], 1);
            $_POST['option-cdl-4'] = NatureConfortConfigurateur::inputValueSanitize($_POST['option-cdl-4'], 1);
            $_POST['option-cdl-5'] = NatureConfortConfigurateur::inputValueSanitize($_POST['option-cdl-5'], 1);
            $_POST['option-cdl-6'] = NatureConfortConfigurateur::inputValueSanitize($_POST['option-cdl-6'], 1);
            $_POST['option-cdl-7'] = NatureConfortConfigurateur::inputValueSanitize($_POST['option-cdl-7'], 1);
            $_POST['option-cdl-8'] = NatureConfortConfigurateur::inputValueSanitize($_POST['option-cdl-8'], 1);


            // pour ce type de configuration, on interdit à l'utilisateur de modifier les quantités
            $flagPossibiliteModifierQuantite = 0;

            //echo "RESULTAT POST";
            //p($_POST);

            // récupération et settage des variables
            if (isset($_POST['type-kit']) && $_POST['type-kit'] != '')                      $typeKit = $_POST['type-kit'];
            if (isset($_POST['type-couverture']) && $_POST['type-couverture'] != '')        $typeCouverture = $_POST['type-couverture'];
            if (isset($_POST['pente-toit']) && $_POST['pente-toit'] != '')                  $penteToit = $_POST['pente-toit'];

            if (isset($_POST['NbrKit160DS']) && is_numeric($_POST['NbrKit160DS']) )         $NbrKit160DS =  $_POST['NbrKit160DS'];
            else                                                                            $NbrKit160DS = 0;

            if (isset($_POST['NbrKit290DS']) && is_numeric($_POST['NbrKit290DS']) )         $NbrKit290DS =  $_POST['NbrKit290DS'];
            else                                                                            $NbrKit290DS = 0;

            if ($typeKit == '160 DS')                                                       $nbKits = $_POST['NbrKit160DS'];
            elseif ($typeKit == '290 DS')                                                   $nbKits = $_POST['NbrKit290DS'];

            if (isset($_POST['longueur-tube']) && is_numeric($_POST['longueur-tube']) )     $longTub =  $_POST['longueur-tube'];
            else                                                                            $longTub = 0;

            if (isset($_POST['nb-coudes']) && is_numeric($_POST['nb-coudes']) )             $nbCoudes =  $_POST['nb-coudes'];
            else                                                                            $nbCoudes = 0;

            if (isset($_POST['nb-rehausses']) && is_numeric($_POST['nb-rehausses']) )       $nbRehausses =  $_POST['nb-rehausses'];
            else                                                                            $nbRehausses = 0;


            // calculateur envoyé :
            // 1 : on récupère les infos saisies
            if (isset($typeKit) && $typeKit != '')
            {
				if ($typeKit == '160 DS')
                {
                    $nbKit160Calcul = $NbrKit160DS;
                    $nbKit290Calcul = 0;
                }
                else
                {
                    $nbKit160Calcul = 0;
                    $nbKit290Calcul = $NbrKit290DS;
                }

                // set les données pour le calculateur
                $donnees = array(   'NbrKit160DS' => $nbKit160Calcul,
                                    'NbrKit290DS' => $nbKit290Calcul,
                                    'LongTub' => $longTub,
                                    'NbrRehausses' => $nbRehausses,
                                    'NbrCoude' => $nbCoudes);

                //echo "PARAMETRES POUR CALCUL : ";
                //p($donnees);
                $tabResultats = calculFormConfigAchat($donnees);

                // récupération du kit de base
                $idProduitDeBase = NatureConfortConfigurateur::getRefKitBaseFromCDL($typeKit);

                // récupération du produit "Etanchéité" correspondant
                $idProduitEtancheite = NatureConfortConfigurateur::getRefEtancheiteFromCDL($typeKit, $penteToit, $typeCouverture);


                if ($typeKit == '160 DS')
                {
                    // rallonge 40cm
                    $refRallonges40 = NatureConfortConfigurateur::getReferenceDivers('rallonges-40', '160DS');
                    $idProduitRallonge40 = NatureConfortConfigurateur::getIdProductFromReference($refRallonges40);

                    // rallonge 60cm
                    $refRallonges60 = NatureConfortConfigurateur::getReferenceDivers('rallonges-60', '160DS');
                    $idProduitRallonge60 = NatureConfortConfigurateur::getIdProductFromReference($refRallonges60);

                    // rouleaux adhesifs
                    $refRouleauxAdhesifs = NatureConfortConfigurateur::getReferenceDivers('rouleaux-adhesif', '160DS');
                    $idProduitRouleauxAdhesif = NatureConfortConfigurateur::getIdProductFromReference($refRouleauxAdhesifs);

                    // rehausses
                    $refRehausse = NatureConfortConfigurateur::getReferenceDivers('rehausse', '160DS');
                    $idProduitRehausses = NatureConfortConfigurateur::getIdProductFromReference($refRehausse);

                    // coudes
                    $refCoudes = NatureConfortConfigurateur::getReferenceDivers('coudes', '160DS');
                    $idProduitCoudes = NatureConfortConfigurateur::getIdProductFromReference($refCoudes);

                    // diffuseur + paroi interne (obligatoire)
                    $idProduitDiffuseur = NatureConfortConfigurateur::getIdProductFromReference($_POST['diffuseur-160']);

                    $refParoiInterne = NatureConfortConfigurateur::getReferenceDivers('paroi-interne', '160DS');
                    $idParoiInterne = NatureConfortConfigurateur::getIdProductFromReference($refParoiInterne);
                }
                elseif ($typeKit == '290 DS')
                {
                    // rallonge 40cm
                    $refRallonges40 = NatureConfortConfigurateur::getReferenceDivers('rallonges-40', '290DS');
                    $idProduitRallonge40 = NatureConfortConfigurateur::getIdProductFromReference($refRallonges40);

                    // rallonge 60cm
                    $refRallonges60 = NatureConfortConfigurateur::getReferenceDivers('rallonges-60', '290DS');
                    $idProduitRallonge60 = NatureConfortConfigurateur::getIdProductFromReference($refRallonges60);

                    // rouleaux adhesifs
                    $refRouleauxAdhesifs = NatureConfortConfigurateur::getReferenceDivers('rouleaux-adhesif', '290DS');
                    $idProduitRouleauxAdhesif = NatureConfortConfigurateur::getIdProductFromReference($refRouleauxAdhesifs);

                    // rehausses
                    $refRehausse = NatureConfortConfigurateur::getReferenceDivers('rehausse', '290DS');
                    $idProduitRehausses = NatureConfortConfigurateur::getIdProductFromReference($refRehausse);

                    // coudes
                    $refCoudes = NatureConfortConfigurateur::getReferenceDivers('coudes', '290DS');
                    $idProduitCoudes = NatureConfortConfigurateur::getIdProductFromReference($refCoudes);

                    // diffuseur + paroi interne (obligatoire)
                    $idProduitDiffuseur = NatureConfortConfigurateur::getIdProductFromReference($_POST['diffuseur-290']);

                    $refParoiInterne = NatureConfortConfigurateur::getReferenceDivers('paroi-interne', '290DS');
                    $idParoiInterne = NatureConfortConfigurateur::getIdProductFromReference($refParoiInterne);
                }


                ////////////////////////////////////////////////
                //      TABLEAU DES PRODUITS FINAUX - CDL
                ////////////////////////////////////////////////

                // kits de base
                $tabProduits[] = array($idProduitDeBase, $nbKits);

                // Etanchéité
                if (is_numeric($idProduitEtancheite) && $idProduitEtancheite != '')
                    $tabProduits[] = array($idProduitEtancheite, $nbKits);

                // Diffuseur
                if ( is_numeric($idProduitDiffuseur) && $idProduitDiffuseur != '')
                    $tabProduits[] = array($idProduitDiffuseur, $nbKits);

                // paroi interne
                if (is_numeric($idParoiInterne) && $idParoiInterne != '')
                    $tabProduits[] = array($idParoiInterne, $nbKits);

                // rallonge de 40cm
                if (is_numeric($tabResultats['NbrL40']) && $tabResultats['NbrL40'] > 0)
                    $tabProduits[] = array($idProduitRallonge40, $tabResultats['NbrL40']);

                // rallonge de 60cm
                if (is_numeric($tabResultats['NbrL60']) && $tabResultats['NbrL60'] > 0)
                    $tabProduits[] = array($idProduitRallonge60, $tabResultats['NbrL60']);

                // rouleaux adhesifs
                if (is_numeric($tabResultats['NbrRouleau']) && $tabResultats['NbrRouleau'] > 0)
                    $tabProduits[] = array($idProduitRouleauxAdhesif, $tabResultats['NbrRouleau']);

                // nombre de réhausses
                if (is_numeric($nbRehausses) && $nbRehausses > 0)
                    $tabProduits[] = array($idProduitRehausses, $nbRehausses);

                // nombre de coudes
                if (is_numeric($nbCoudes) && $nbCoudes > 0)
                    $tabProduits[] = array($idProduitCoudes, $nbCoudes);



                ///////////////////////////////////////////////////////////////
                //      OPTIONS
                ///////////////////////////////////////////////////////////////

                // récupération des options (en fonction du type de kit)
                //$tabOptionsProposees = NatureConfortConfigurateur::getOptionsFromFormulaireCDL($typeKit);

                $tabOptionsProposees = NatureConfortConfigurateur::getOptionsFromFormulaireCDLv2($typeKit);

            }
            else
            {
                echo "ERREUR : TYPE DE KIT ABSENT";
            }



        }


        //////////////////////////////////////////////////
        //  FORMULAIRE CONFIGURATEUR POSTÉ :
        //  RECUPERATION DES PRODUITS CORRESPONDANTS
        //////////////////////////////////////////////////

        // variables
        if (isset($_POST['type-formulaire-accueil']) && $_POST['type-formulaire-accueil'] != '')
        {
            if ($_POST['type-formulaire-accueil'] == 1)
            {
                ////////////////////////////
                //      EXTRACTEUR
                ////////////////////////////

                $tabProduitsExtracteur = NatureConfortConfigurateur::getIdProduitsFromCouvertureAndPenteToit($_POST);
                if (is_array($tabProduitsExtracteur) && count($tabProduitsExtracteur)>0)
                {
                    foreach ($tabProduitsExtracteur as $idProduitBoucle)
                    {
                        //  1 exemplaire de chaque produit
                        array_push($tabProduits, array($idProduitBoucle, 1) );
                    }
                }
                else
                {
                    // saisie avec incohérence
                    echo '<p class="alert alert-danger">Cette configuration d\'installation n\'existe pas, merci de vérifier les choix saisis.</p>';
                }

            }
            elseif ($_POST['type-formulaire-accueil'] == 2)
            {
                ////////////////////////////
                //      REFLECTEUR
                ////////////////////////////

                // on s'assure que les quantités envoyées soient des integer
                $_POST['qte-rfl-ext'] = NatureConfortConfigurateur::inputValueSanitize($_POST['qte-rfl-ext'], 1);
                $_POST['qte-rfl-balcon'] = NatureConfortConfigurateur::inputValueSanitize($_POST['qte-rfl-balcon'], 1);
                $_POST['qte-rfl-int'] = NatureConfortConfigurateur::inputValueSanitize($_POST['qte-rfl-int'], 1);


                $tabProduitReflecteur = NatureConfortConfigurateur::getProduitsFromModeleReflecteurAndDimensions($_POST);
                if (is_array($tabProduitReflecteur))
                {
                    if (is_numeric($tabProduitReflecteur['id_produit']) && is_numeric($tabProduitReflecteur['quantite']) && $tabProduitReflecteur['id_produit'] != 0)
                        array_push($tabProduits, array($tabProduitReflecteur['id_produit'], $tabProduitReflecteur['quantite']) );
                    else
                        echo '<p class="alert alert-danger">Une erreur est survenue lors de la récupération de vos produits.</p>';
                }

            }
            elseif ($_POST['type-formulaire-accueil'] == 3)
            {
                ///////////////////////////////
                //      CONDUIT DE LUMIERE
                ///////////////////////////////

                if (isset($_POST['type-saisie-3']) && $_POST['type-saisie-3'] == 'assistant' && isset($_POST['cdl-longueur']) && $_POST['cdl-longueur'] != 0)
                {
                    // transforme les valeurs saisies en float pour des calculs corrects
                    $_POST['cdl-longueur'] = NatureConfortConfigurateur::inputValueSanitize($_POST['cdl-longueur']);
                    $_POST['cdl-largeur'] = NatureConfortConfigurateur::inputValueSanitize($_POST['cdl-largeur']);
                    $_POST['cdl-hauteur-espace-sombre'] = NatureConfortConfigurateur::inputValueSanitize($_POST['cdl-hauteur-espace-sombre']);
                    $_POST['cdl-longueur-tube'] = NatureConfortConfigurateur::inputValueSanitize($_POST['cdl-longueur-tube']);


                    // garde en session pour le récap final
                    $this->context->cookie->__set('cookieDepartement', $_POST['departement']); ;
                    $this->context->cookie->__set('cookiePuissanceLumSouhaitee', $_POST['PuissanceLumSouhaitee']);
                    $this->context->cookie->__set('cookieCdlLongueur', $_POST['cdl-longueur']);
                    $this->context->cookie->__set('cookieCdlLargeur', $_POST['cdl-largeur']);
                    $this->context->cookie->__set('cookieCdlHauteurEspaceSombre', $_POST['cdl-hauteur-espace-sombre']);
                    $this->context->cookie->__set('cookieCdlLongueurTube', $_POST['cdl-longueur-tube']);

                    if ($_POST['cdl-pente-toit'] == 'inf30')        $libellePenteToit = 'Inférieure ou égale à 30°';
                    elseif ($_POST['cdl-pente-toit'] == 'sup30')    $libellePenteToit = 'Supérieure à 30°';
                    else                                            $libellePenteToit = 'Plate';
                    $this->context->cookie->__set('cookieCdlPenteToit', $libellePenteToit);

                    if ($_POST['cdl-type-couverture'] == 'canal-mecanique')             $libelleCouverteToit = 'Tuiles canal ou mécaniques';
                    elseif ($_POST['cdl-type-couverture'] == 'ardoise-lauze')           $libelleCouverteToit = 'Ardoises, Lauzes';
                    elseif ($_POST['cdl-type-couverture'] == 'tuiles-plates')           $libelleCouverteToit = 'Tuiles plates sans emboîtement';
                    elseif ($_POST['cdl-type-couverture'] == 'beton')                   $libelleCouverteToit = 'Toit terrasse béton';
                    else                                                                $libelleCouverteToit = 'Autre';
                    $this->context->cookie->__set('cookieCdlTypeCouverture', $libelleCouverteToit);

                    $flagAfficheFormulaireChoixGeneral = 0;


                    // ASSISTANT
                    $tabResultats = calculFromAssistant($_POST);


                    if (is_array($tabResultats) && count($tabResultats)>0)
                    {
                        // récupération des diffuseurs
                        $tabDiffuseursDS160 = NatureConfortConfigurateur::getDiffuseurs('160DS');
                        $tabDiffuseursDS290 = NatureConfortConfigurateur::getDiffuseurs('290DS');

                        $classeBouton160 = '';
                        $classeBouton290 = '';

                        // formatage des donnés avant l'envoi au template
                        $DisplayInput160DS = '';
                        $DisplayInput290DS = '';
                        if ($tabResultats['ModeleConseille'] == '160 DS')
                        {
                            $classeBouton160 = 'selected';
                            $DisplayInput290DS = ' style="display:none" ';
                        }
                        else
                        {
                            $classeBouton290 = 'selected';
                            $DisplayInput160DS = ' style="display:none" ';
                        }



                        // récupération des options
                        $tabOptions1 = NatureConfortConfigurateur::getOptionsForSelect(1);
                        $tabOptions2 = NatureConfortConfigurateur::getOptionsForSelect(2);
                        $tabOptions3 = NatureConfortConfigurateur::getOptionsForSelect(3);
                        $tabOptions4 = NatureConfortConfigurateur::getOptionsForSelect(4);
                        $tabOptions5 = NatureConfortConfigurateur::getOptionsForSelect(5);


                        ////////////////////////////////////////////
                        //  Assignation des valeurs au template
                        ////////////////////////////////////////////

                        $tabAssignTemplate =  array(
                            'ModeleConseille' => $tabResultats['ModeleConseille'],
                            'NbrKit160' => $tabResultats['NbrKit160'],
                            'NbrKit290' => $tabResultats['NbrKit290'],

                            'classeBouton160' => $classeBouton160,
                            'classeBouton290' => $classeBouton290,
                            'DisplayInput160DS' => $DisplayInput160DS,
                            'DisplayInput290DS' => $DisplayInput290DS,

                            'tabDiffuseurs160' => $tabDiffuseursDS160,
                            'tabDiffuseurs290' => $tabDiffuseursDS290,

                            'longueurTube' => $_POST['cdl-longueur-tube'],
                            'typeCouverture' => $_POST['cdl-type-couverture'],
                            'penteToit' => $_POST['cdl-pente-toit'],

                            'tabOptions1' => $tabOptions1,
                            'tabOptions2' => $tabOptions2,
                            'tabOptions3' => $tabOptions3,
                            'tabOptions4' => $tabOptions4,
                            'tabOptions5' => $tabOptions5
                        );

                        $this->context->smarty->assign($tabAssignTemplate);
                        $content .=  $this->display(__FILE__, 'views/templates/front/formulaireConfigurateur.tpl');
                    }


                }

            }

        }


        /////////////////////////////////////////////////////////////////////////////
        //  BOUCLE RECUPERANT LE DETAIL DE CHAQUE PRODUIT CORRESPONDANT A LA DEMANDE
        /////////////////////////////////////////////////////////////////////////////


        if (is_array($tabProduits) && count($tabProduits)>0)
        {
            $flagAfficheFormulaireChoixGeneral = 0;

            foreach ($tabProduits as $tabProduit)
            {
                // récupération ID produit et quantité
                $idProduitBoucle = $tabProduit[0];
                $quantite = $tabProduit[1];

                // chargement du produit
                $produitBoucle = NatureConfortConfigurateur::chargeProduitComplet($idProduitBoucle, $quantite);

                // ajout dans le tableau global des produits
                array_push($tabProduitsResultat, $produitBoucle);

                // ajoute le prix au total du panier
                $prixTotalIndicatif += $produitBoucle->getPrice(true, null, 2) * $quantite;
            }



            // ajoute le prix des options au total du panier
            if (is_array($tabOptionsProposees) && count($tabOptionsProposees)>0)
            {
                foreach ($tabOptionsProposees as $produitOption)
                {
                    $prixOption = $produitOption->getPrice(true, null, 2) * $produitOption->quantite;
                    $prixTotalIndicatif += $prixOption;
                }
            }



            //////////////////////////////////////////
            // assignation des variables au template
            //////////////////////////////////////////

            if ($flagPossibiliteModifierQuantite == 0)      $largeurCol = 'col-md-9';
            else                                            $largeurCol = 'col-md-12';

            $this->context->smarty->assign(
                array(
                    'tabProduitsResultat' => $tabProduitsResultat,
                    'tabProduitsOption' => $tabOptionsProposees,
                    'prixTotalIndicatif' => $prixTotalIndicatif,
                    'flagPossibiliteModifierQuantite' => $flagPossibiliteModifierQuantite,

                    'largeurCol' => $largeurCol,
                    'departement' => $this->context->cookie->cookieDepartement,
                    'puissanceLumSouhaitee' => $this->context->cookie->cookiePuissanceLumSouhaitee,
                    'cdlLongueur' => $this->context->cookie->cookieCdlLongueur,
                    'cdlLargeur' => $this->context->cookie->cookieCdlLargeur,
                    'cdlHauteur' => $this->context->cookie->cookieCdlHauteurEspaceSombre,
                    'cdlLongueurTube' => $this->context->cookie->cookieCdlLongueurTube,
                    'cdlPenteToit' => $this->context->cookie->cookieCdlPenteToit,
                    'cdlTypeCouverture' => $this->context->cookie->cookieCdlTypeCouverture
                )
            );


            ////////////////////////////////////////////////////////////////////////////////////////
            // retourne le template permettant d'ajouter dans le panier les items correspondants
            ////////////////////////////////////////////////////////////////////////////////////////

            $content .=  $this->display(__FILE__, 'views/templates/front/produitsCorrespondantsConfigurateur.tpl');

        }


        if ($flagAfficheFormulaireChoixGeneral == 1)
        {
            // on affiche le point d'entrée du gros formulaire de configuration
            $content .=  $this->display(__FILE__, 'views/templates/front/point-entree.tpl');
        }

        */

        return $content;
    }

}
