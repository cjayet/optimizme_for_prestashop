<?php

/**
 * Created by PhpStorm.
 * User: clement
 * Date: 09/11/2016
 * Time: 15:00
 */
class OptimizMeActions
{
    public $returnResult;
    public $tabErrors;
    public $tabSuccess;
    public $returnAjax;

    /**
     * OptimizMeActions constructor.
     */
    public function __construct()
    {
        $this->returnResult = array();
        $this->tabErrors = array();
        $this->tabSuccess = array();
        $this->returnAjax = array();
    }


    ////////////////////////////////////////////////
    //              PRODUCTS
    ////////////////////////////////////////////////

    /**
     * Load posts/pages
     */
    public function loadPostsPages($objData){
        $productsReturn = array();
        $tabResults = array();

        if (isset($objData->id_lang) && is_numeric($objData->id_lang)){
            // langs already loaded and available
            $lang = $objData->id_lang;
        }
        else {
            // langs not loaded
            $tabLangs = $this->getListLang();
            $this->returnAjax['langs'] = $tabLangs;
            $lang = $tabLangs[0]['id_lang'];
        }


        // get products by lang
        $allProducts = Product::getProducts($lang, 0, -1, 'name', 'ASC');
        if (is_array($allProducts) && count($allProducts)>0){
            foreach ($allProducts as $product){
                if ($product['name'] != ''){
                    if ($product['active'] == 1)        $status = 'En ligne';
                    else                                $status = 'Hors ligne';
                    $prodReturn = array(
                        'ID' => $product['id_product'],
                        'post_title' => $product['name'],
                        'post_status' => $status
                    );
                    array_push($productsReturn, $prodReturn);
                }

            }
        }

        $tabResults['posts'] = $productsReturn;
        $this->returnAjax['arborescence'] = $tabResults;

    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function setTitle($idPost, $objData){
        OptMeUtils::saveObjField($idPost, $objData->id_lang, 'product', 'name', $objData->new_title, $this, 1);
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function setContent($idPost, $objData){

        // no clean for grid editor
        Configuration::updateValue('PS_USE_HTMLPURIFIER', 0);

        if (!isset($objData->new_content))
        {
            // need more data
            array_push($this->tabErrors, 'Contenu non trouvé.');
        }
        else{

            // copy media files to prestashop img cms
            $doc = new DOMDocument;
            libxml_use_internal_errors(true);
            $doc->loadHTML('<span>'.$objData->new_content.'</span>');
            libxml_clear_errors();

            // get all images in post content
            $xp = new DOMXPath($doc);

            // tags to parse and attributes to transform
            $tabParseScript = array(
                'img' => 'src',
                'a' => 'href',
                'video' => 'src',
                'source' => 'src'
            );

            foreach ($tabParseScript as $tag => $attr)
            {
                foreach ($xp->query('//'.$tag) as $node)
                {
                    // url media in easycontent
                    $urlFile = $node->getAttribute($attr);
                    /*
                    if(!(strpos($urlFile, 'http') === 0)){
                        $urlFile = 'http://localhost'. $urlFile;        // TODO enlever localhost
                    }
                    */

                    // check if already in media library
                    if (OptMeUtils::isFileMedia($urlFile)){
                        $urlMediaPrestashop = OptMeUtils::isMediaInLibrary($urlFile);
                        if (!$urlMediaPrestashop){
                            $resAddImage = OptMeUtils::addMediaInLibrary($urlFile);
                             if ( !$resAddImage ){
                                 array_push($this->tabErrors, 'Erreur lors de la copie de l\'image.');
                             }
                             else {
                                 $urlMediaPrestashop = $resAddImage;
                             }
                        }

                        // change HTML source: URI form Prestashop media library for this media
                        $node->setAttribute($attr, $urlMediaPrestashop);
                        $node->removeAttribute('data-mce-src');
                    }
                }
            }

            // span racine to enlever
            $newContent = OptMeUtils::getHtmlFromDom($doc);
            $newContent = OptMeUtils::cleanHtmlFromEasycontent($newContent);

            // save product content
            OptMeUtils::saveObjField($idPost, $objData->id_lang, 'product', 'description', $newContent, $this);

            if (count($this->tabErrors) == 0){
                $this->returnAjax['message'] = 'Contenu enregistré avec succès';
                $this->returnAjax['id_post'] = $idPost;
                $this->returnAjax['content'] = $newContent;
            }
        }
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function setShortDescription($idPost, $objData){
        OptMeUtils::saveObjField($idPost, $objData->id_lang, 'product', 'description_short', $objData->new_short_description, $this);
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function setAttributesTag($idProduct, $objData, $tag){

        $boolModified = 0;
        if ( !is_numeric($idProduct)){
            // need more data
            array_push($this->tabErrors, 'ID du produit non transmis');
        }
        if ($objData->url_reference == ''){
            // need more data
            array_push($this->tabErrors, 'Aucun lien de référence trouvé, action annulée.');
        }
        else
        {
            $product = new Product($idProduct);
            if ($product->id != '')
            {
                // load nodes
                $doc = new DOMDocument;
                $nodes = OptMeUtils::getNodesInDom($doc, $tag, $product->description[1]);       // TODO pourquoi 1 ?
                if ($nodes->length > 0) {
                    foreach ($nodes as $node) {

                        if ($tag == 'img'){
                            if ($node->getAttribute('src') == $objData->url_reference) {
                                // image found in source: update (force utf8)
                                $boolModified = 1;

                                if ($objData->alt_image != '')      $node->setAttribute('alt', utf8_encode($objData->alt_image));
                                else                                $node->removeAttribute('alt');

                                if ($objData->title_image != '')    $node->setAttribute('title', utf8_encode($objData->title_image));
                                else                                $node->removeAttribute('title');
                            }
                        }
                        elseif ($tag == 'a'){
                            if ($node->getAttribute('href') == $objData->url_reference){
                                // href found in source: update (force utf8)
                                $boolModified = 1;

                                if ($objData->rel_lien != '')       $node->setAttribute('rel', utf8_encode($objData->rel_lien));
                                else                                $node->removeAttribute('rel');

                                if ($objData->target_lien != '')    $node->setAttribute('target', utf8_encode($objData->target_lien));
                                else                                $node->removeAttribute('target');
                            }
                        }
                    }
                }

                if ($boolModified == 1){
                    // action done: save new content
                    // span racine to enlever
                    $newContent = OptMeUtils::getHtmlFromDom($doc);

                    // update
                    $product->description = $newContent;
                    try {
                        $product->save();
                    }
                    catch (Exception $e){
                        array_push($this->tabErrors, "Erreur optimisation tag : ". $e->getMessage());
                    }
                }
                else {
                    // nothing done
                    array_push($this->tabErrors, 'Aucun changement effectué.');
                }
            }
        }
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function setMetaDescription($idPost, $objData){
        OptMeUtils::saveObjField($idPost, $objData->id_lang, 'product', 'meta_description', $objData->meta_description, $this);
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function setMetaTitle($idPost, $objData){
        OptMeUtils::saveObjField($idPost, $objData->id_lang, 'product', 'meta_title', $objData->meta_title, $this);
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function setCanonicalUrl($idPost, $objData){
        // TODO
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function setMetaRobots($idPost, $objData){
        // TODO
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function setPostStatus($idPost, $objData){
        if ( !isset($objData->is_publish) )         $objData->is_publish = 0;
        OptMeUtils::saveObjField($idPost, '', 'product', 'active', $objData->is_publish, $this);
    }

    /**
     * Change permalink of a post
     * and add a redirection
     * @param $idPost
     * @param $objData
     */
    public function setProductSlug($idPost, $objData){
        if ($idPost == ''){
            array_push($this->tabErrors, 'Produit non trouvé.');
        }
        elseif (!isset($objData->id_lang) || !is_numeric($objData->id_lang)){
            array_push($this->tabErrors, 'Lang not set.');
        }
        elseif (!isset($objData->new_slug) || $objData->new_slug == ''){
            // need more data
            array_push($this->tabErrors, 'Veuillez saisir le slug');
        }
        else
        {
            $product = new Product($idPost, false, $objData->id_lang);
            $slugPropre = Tools::str2url($objData->new_slug);
            $product->link_rewrite = $slugPropre;

            try {
                $product->save();

                $this->returnAjax['url'] = OptMeUtils::getProductUrl($idPost, $objData->id_lang);
                $this->returnAjax['message'] = 'Slug changé avec succès';
                $this->returnAjax['new_slug'] = $slugPropre;

            } catch (Exception $e) {
                array_push($this->tabErrors, "Erreur lors de l'enregistrement du slug : ". $e->getMessage());
            }
        }
    }

    /**
     * Return content from a post
     * @param $idPost
     * @param $objData
     */
    public function loadPostContent($idPost, $objData){

        $product = new Product($idPost, false, $objData->id_lang);
        if ($product->id != ''){

            // check si le contenu est bien compris dans une balise "row" pour qu'il soit bien inclus dans l'éditeur
            if (trim($product->description) != ''){
                if (!stristr($product->description, '<div class="row')){
                    $product->description = '<div class="row ui-droppable"><div class="col-md-12 col-sm-12 col-xs-12 column"><div class="ge-content ge-content-type-tinymce" data-ge-content-type="tinymce">'. $product->description .'</div></div></div>';
                }
            }

            // load and return product data
            $this->returnAjax['title'] = $product->name;
            $this->returnAjax['short_description'] = $product->description_short;
            $this->returnAjax['content'] = $product->description;
            $this->returnAjax['slug'] = $product->link_rewrite;
            $this->returnAjax['url'] = OptMeUtils::getProductUrl($product->id, $objData->id_lang);
            $this->returnAjax['publish'] = $product->active;
            $this->returnAjax['meta_description'] = $product->meta_description;
            $this->returnAjax['meta_title'] = $product->meta_title;
            $this->returnAjax['url_canonical'] = 'todo';                                // TODO gestion url canonique
            $this->returnAjax['noindex'] = 'todo';                                      // TODO gestion noindex
            $this->returnAjax['nofollow'] = 'todo';                                     // TODO gestion nofollow
            $this->returnAjax['blog_public'] = 1;
        }
    }



    ////////////////////////////////////////////////
    //              CATEGORIES
    ////////////////////////////////////////////////

    /**
     * Load all categories
     */
    public function loadCategories($objData){

        $tabResults = array();

        if (isset($objData->id_lang) && is_numeric($objData->id_lang)){
            // langs loaded
            $lang = $objData->id_lang;
        }
        else {
            // langs not loaded
            $tabLangs = $this->getListLang();
            $this->returnAjax['langs'] = $tabLangs;
            $lang = $tabLangs[0]['id_lang'];
        }

        // get languages in shop
        if (!isset($objData->id_lang) || !is_numeric($objData->id_lang))        $langCategories = false;
        else                                                                    $langCategories = $objData->id_lang;

        // don't get root category
        $categories = Category::getCategories($langCategories, true, false, ' AND id_parent > 0 ');

        if (is_array($categories) && count($categories)){
            foreach ($categories as $categoryLoop){

                $categoryInfos = array(
                    'id' => $categoryLoop['id_category'],
                    'name' => $categoryLoop['name'],
                    'description' => $categoryLoop['description'],
                    'slug' => $categoryLoop['link_rewrite'],
                    'publish' => $categoryLoop['active'],
                    'id_shop' => $categoryLoop['id_shop'],
                    'id_lang' => $categoryLoop['id_lang'],
                );

                array_push($tabResults, $categoryInfos);
            }
        }

        $this->returnAjax['categories'] = $tabResults;
    }

    /**
     * @param $elementId
     * @param $objData
     */
    public function loadCategoryContent($elementId, $objData){
        $tabCategory = array();

        // get requested language, or default language
        $lang = OptMeUtils::getIdLanguage($objData->id_lang);

        $category = new Category($elementId, $lang);
        if ($category->id_category && $category->id_category != ''){
            $tabCategory['id'] = $category->id_category;
            $tabCategory['name'] = $category->name;
            $tabCategory['description'] = $category->description;
            $tabCategory['url'] = $category->getLink(null, $lang);
            $tabCategory['slug'] = $category->link_rewrite;
        }

        $this->returnAjax['message'] = 'Category loaded';
        $this->returnAjax['category'] = $tabCategory;
    }

    /**
     * @param $id
     * @param $objData
     */
    public function setCategoryName($id, $objData){
        OptMeUtils::saveObjField($id, $objData->id_lang, 'category', 'name', $objData->new_name, $this);
    }

    /**
     * @param $id
     * @param $objData
     */
    public function setCategoryDescription($id, $objData){
        OptMeUtils::saveObjField($id, $objData->id_lang, 'category', 'description', $objData->description, $this);
    }

    /**
     * @param $id
     * @param $objData
     */
    public function setCategorySlug($id, $objData){

        $lang = OptMeUtils::getIdLanguage($objData->id_lang);
        if (OptMeUtils::saveObjField($id, $lang, 'category', 'link_rewrite', $objData->new_slug, $this)){
            $categoryUpdated = new Category($id);

            // return informations
            $this->returnAjax['message'] = 'URL changed';
            $this->returnAjax['url'] = $categoryUpdated->getLink(null, $lang);
            $this->returnAjax['new_slug'] = $categoryUpdated->link_rewrite[$lang];
        }
    }


    ////////////////////////////////////////////////
    //              REDIRECTIONS
    ////////////////////////////////////////////////

    /**
     * load list of redirections
     */
    public function loadRedirections(){
        $this->returnAjax['redirections'] = OptimizMeRedirections::getAllRedirections('all');
    }

    /**
     * Enable or disable a redirection
     * @param $objData
     * @param int $flagDisabled
     */
    public function enableDisableRedirection($objData, $flagDisabled=0){
        if (!isset($objData->id_redirection) || $objData->id_redirection == ''){
            // need more data
            array_push($this->tabErrors, __('Redirection non trouvée', 'optimizme'));
        }
        else {
            $redirection = new OptimizMeRedirections();
            if ($flagDisabled == 0)     $redirection->enableRedirection($objData->id_redirection);
            else                        $redirection->disableRedirection($objData->id_redirection);
        }
    }

    /**
     * @param $objData
     */
    public function deleteRedirection($objData){
        if (!isset($objData->id_redirection) || $objData->id_redirection == ''){
            // need more data
            array_push($this->tabErrors, __('Redirection non trouvée', 'optimizme'));
        }
        else {
            $redirection = new OptimizMeRedirections();
            $redirection->deleteRedirection($objData->id_redirection);
        }
    }


    ////////////////////////////////////////////////
    //              UTILS
    ////////////////////////////////////////////////

    /**
     * Get list of available languages
     */
    public function getListLang(){
        return Language::getLanguages();
    }

    /**
     * Load false content
     */
    public function loadLoremIpsum(){
        $nbParagraphes = rand(2,4);
        $content = file_get_contents('http://loripsum.net/api/'.$nbParagraphes.'/short/decorate/');
        $this->returnAjax['content'] = $content;
    }

    /**
     * Check if has error or not
     * @return bool
     */
    public function hasErrors(){
        if (is_array($this->tabErrors) && count($this->tabErrors)>0){
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @param $msg
     * @param string $typeResult : success, info, warning, danger
     */
    public function setMsgReturn($msg, $typeResult='success'){
        $this->returnResult['result'] = $typeResult;
        $this->returnResult['message'] = $msg;

        // return results
        header("Access-Control-Allow-Origin: *");
        echo json_encode($this->returnResult);
    }

    /**
     * @param $tabData
     * @param string $typeResult: success, info, warning, danger
     */
    public function setDataReturn($tabData, $typeResult='success'){
        $this->returnResult['result'] = $typeResult;

        if (is_array($tabData) && count($tabData)>0){
            foreach ($tabData as $key => $value){
                $this->returnResult[$key] = $value;
            }
        }

        // return results
        header("Access-Control-Allow-Origin: *");
        echo json_encode($this->returnResult);
    }

}