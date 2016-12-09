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

    /**
     * @param $idPost
     * @param $objData
     */
    public function updateTitle($idPost, $objData){
        OptMeUtils::saveProductField($idPost, 'name', $objData->new_title, $this, 1);
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function updateContent($idPost, $objData){

        //$images = Image::getImages(1, $idPost);
        //OptMeUtils::nice($images); die;

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
                    if(!(strpos($urlFile, 'http') === 0)){
                        $urlFile = 'http://localhost'. $urlFile;        // TODO enlever localhost
                    }

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
            OptMeUtils::saveProductField($idPost, 'description', $newContent, $this);

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
    public function updateShortDescription($idPost, $objData){
        OptMeUtils::saveProductField($idPost, 'description_short', $objData->new_short_description, $this);
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function updateAttributesTag($idProduct, $objData, $tag){

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
                $nodes = OptMeUtils::getNodesInDom($doc, $tag, $product->description[1]);
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
    public function updateMetaDescription($idPost, $objData){
        OptMeUtils::saveProductField($idPost, 'meta_description', $objData->meta_description, $this);
    }


    /**
     * @param $idPost
     * @param $objData
     */
    public function updateMetaTitle($idPost, $objData){
        OptMeUtils::saveProductField($idPost, 'meta_title', $objData->meta_title, $this);
    }




    /**
     * @param $idPost
     * @param $objData
     */
    public function updateCanonicalUrl($idPost, $objData)
    {
        if (defined( 'YOAST_ENVIRONMENT' )){
            // update with "YOAST SEO"

            $metaKey = '_yoast_wpseo_canonical';
            if (OptMeUtils::doUpdatePostMeta($objData->canonical_url, $idPost, $metaKey)){
                $resUpdate = update_post_meta($idPost, $metaKey, $objData->canonical_url);
                if ($resUpdate == false){
                    array_push($this->tabErrors, __('Erreur lors de la sauvegarde url canonical pour YOAST', 'optimizme'));
                }
            }
        }
        else {
            // update canonical url with "Optimiz.me"
            $urlCanonical = esc_url_raw( $objData->canonical_url, array('http', 'https') );

            $metaKey = 'optimizme_canonical';
            if (OptMeUtils::doUpdatePostMeta($objData->canonical_url, $idPost, $metaKey)){
                $resUpdate = update_post_meta($idPost, $metaKey, $objData->canonical_url);
                if ($resUpdate == false){
                    array_push($this->tabErrors, __('Erreur lors de la sauvegarde url canonical', 'optimizme'));
                }
                else {
                    // OK
                    array_push($this->tabSuccess, 'URL : ' . $urlCanonical);
                }
            }
        }
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function updateMetaRobots($idPost, $objData){
        if ($idPost != ''){
            $post = get_post($idPost);

            if ($post->ID != ''){

                // meta keys
                $keyMetaNoIndex = OptMeUtils::getPostMetaKeyFromType('noindex');
                $keyMetaNoFollow = OptMeUtils::getPostMetaKeyFromType('nofollow');

                // update index/noindex
                if ($objData->noindex == 1)             update_post_meta($idPost, $keyMetaNoIndex, 1);
                else                                    delete_post_meta($idPost, $keyMetaNoIndex);

                // update follow/nofollow
                if ($objData->nofollow == 1)            update_post_meta($idPost, $keyMetaNoFollow, 1);
                else                                    delete_post_meta($idPost, $keyMetaNoFollow);

            }
            else {
                array_push($this->tabErrors, __('Erreur lors du chargement du post', 'optimizme'));
            }
        }
        else {
            array_push($this->tabErrors, __('Aucun id de post', 'optimizme'));
        }
    }

    /**
     * @param $idPost
     * @param $objData
     */
    public function updatePostStatus($idPost, $objData){
        if ( !isset($objData->is_publish) )         $objData->is_publish = 0;
        OptMeUtils::saveProductField($idPost, 'active', $objData->is_publish, $this);
    }



    /**
     * Change permalink of a post
     * and add a redirection
     * @param $idPost
     * @param $objData
     */
    public function updateSlug($idPost, $objData){
        if ($idPost == ''){
            array_push($this->tabErrors, 'Produit non trouvé.');
        }
        elseif (!isset($objData->new_slug) || $objData->new_slug == ''){
            // need more data
            array_push($this->tabErrors, 'Veuillez saisir le slug');
        }
        else
        {
            $product = new Product($idPost);
            $slugPropre = Tools::str2url($objData->new_slug);
            $product->link_rewrite = $slugPropre;

            try {
                $product->save();

                $this->returnAjax['url'] = OptMeUtils::getProductUrl($idPost);
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

        $product = new Product($idPost);
        if ($product->id != ''){

            // check si le contenu est bien compris dans une balise "row" pour qu'il soit bien inclus dans l'éditeur
            if (trim($product->description[1]) != ''){
                if (!stristr($product->description[1], '<div class="row')){
                    $product->description[1] = '<div class="row ui-droppable"><div class="col-md-12 col-sm-12 col-xs-12 column"><div class="ge-content ge-content-type-tinymce" data-ge-content-type="tinymce">'. $product->description[1] .'</div></div></div>';
                }
            }

            // load and return product data
            $this->returnAjax['title'] = $product->name[1];                             // TODO pourquoi 1 ?
            $this->returnAjax['short_description'] = $product->description_short[1];    // TODO pourquoi 1 ?
            $this->returnAjax['content'] = $product->description[1];                    // TODO pourquoi 1 ?
            $this->returnAjax['slug'] = $product->link_rewrite[1];                      // TODO pourquoi 1 ?
            $this->returnAjax['url'] = OptMeUtils::getProductUrl($product->id);
            $this->returnAjax['publish'] = $product->active;
            $this->returnAjax['meta_description'] = $product->meta_description[1];      // TODO pourquoi 1 ?
            $this->returnAjax['meta_title'] = $product->meta_title[1];                  // TODO pourquoi 1 ?
            $this->returnAjax['url_canonical'] = 'todo';                                // TODO gestion url canonique
            $this->returnAjax['noindex'] = 'todo';                                      // TODO gestion noindex
            $this->returnAjax['nofollow'] = 'todo';                                     // TODO gestion nofollow
            $this->returnAjax['blog_public'] = 1;
        }
    }


    /**
     * Load posts/pages
     */
    public function loadPostsPages($objData){
        $productsReturn = array();
        $tabResults = array();

        // get languages in shop
        $langs = OptMeUtils::getPrestashopLanguages();

        if (is_array($langs) && count($langs)>0){
            foreach ($langs as $lang){

                // get products by lang
                $allProducts = Product::getProducts($lang['id_lang'], 0, -1, 'name', 'ASC');
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
            }
        }

        $tabResults['posts'] = $productsReturn;
        $this->returnAjax['arborescence'] = $tabResults;
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



    /**
     * Add errors to the object
     * @param $id_update
     */
    public function logWpObjectErrors($id_update){
        if (is_wp_error($id_update)) {
            $errors = $id_update->get_error_messages();
            foreach ($errors as $error) {
                array_push($this->tabErrors, $error);
            }
        }
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
        echo json_encode($this->returnResult);
    }

    /**
     * @param $msg
     * @param string $typeResult : success, info, warning, danger
     */
    public function setDataReturn($tabData, $typeResult='success'){
        $this->returnResult['result'] = $typeResult;

        if (is_array($tabData) && count($tabData)>0){
            foreach ($tabData as $key => $value){
                $this->returnResult[$key] = $value;
            }
        }

        // return results
        echo json_encode($this->returnResult);
    }


    /**
     * @param $idPost
     */
    public function loadImagesFromPost($idPost){

        $tabImages = array();
        if ($idPost != '') {
            $post = get_post($idPost);

            if ($post->ID != '') {

                // load nodes
                $doc = new DOMDocument;
                $nodes = OptMeUtils::getNodesInDom($doc, 'img', $post->post_content);
                if ($nodes->length > 0){
                    foreach ($nodes as $node) {
                        array_push($tabImages,
                            array(
                                'src' => $node->getAttribute('src'),
                                'alt' => utf8_decode($node->getAttribute('alt')),
                                'title' => utf8_decode($node->getAttribute('title'))
                            ));
                    }
                }

                $this->returnAjax['images'] = $tabImages;
            }
        }
    }


    /**
     * @param $idPost
     */
    public function loadHrefFromPost($idPost){

        $tabLiens = array();
        if ($idPost != '') {
            $post = get_post($idPost);

            if ($post->ID != '') {

                // load nodes
                $doc = new DOMDocument;
                $nodes = OptMeUtils::getNodesInDom($doc, 'a', $post->post_content);
                if ($nodes->length > 0){
                    foreach ($nodes as $node) {
                        array_push($tabLiens,
                            array(
                                'href' => $node->getAttribute('href'),
                                'rel' => $node->getAttribute('rel'),
                                'target' => $node->getAttribute('target')
                            ));
                    }
                }

                $this->returnAjax['liens'] = $tabLiens;
            }
        }
    }




    /**
     * Création d'un post
     * @param $objData
     */
    public function createPost($objData){
        $flagError = 0;
        if (!isset($objData->post_type) || $objData->post_type == ''){
            // need more data
            array_push($this->tabErrors, __('Type de contenu non défini (article ou page)', 'optimizme'));
            $flagError = 1;
        }

        if (!isset($objData->title) || $objData->title == ''){
            // need more data
            array_push($this->tabErrors, __('Veuillez indiquer un titre', 'optimizme'));
            $flagError = 1;
        }

        if (!isset($objData->post_status) || $objData->post_status == ''){
            array_push($this->tabErrors, __('Veuillez indiquer un état', 'optimizme'));
            $flagError = 1;
        }

        if ($flagError == 0)
        {
            $args = array(
                'post_type' => $objData->post_type,
                'post_title' => $objData->title,
                'post_status' => $objData->post_status
            );
            if (isset($objData->parent) && $objData->parent != ''){
                $args['post_parent'] = $objData->parent;
            }

            $idPostCreate = wp_insert_post($args);
            if ($idPostCreate){
                $permalink = get_permalink($idPostCreate);

                // load and return post data
                $this->returnAjax['title'] = $objData->title;
                $this->returnAjax['permalink'] = $permalink;
                $this->returnAjax['message'] = __('Création terminée avec succès : ', 'optimizme') .'<a href="'. $permalink .'">'. $permalink .'</a>';
            }
            else {
                // error creation
                array_push($this->tabErrors, __('Erreur création post', 'optimizme'));
            }
        }
    }


    /**
     * @param $objData
     */
    public function setBlogPublicOrPrivate($objData){
        if (isset($objData->nosearchengine) || $objData->nosearchengine == 1)       $valueBlogPublic = 0;
        else                                                                        $valueBlogPublic = 1;

        update_option('blog_public', $valueBlogPublic);

        $this->returnAjax['blog_public'] = $valueBlogPublic;
        $this->returnAjax['message'] = __('Information enregistrée.', 'optimizme');
    }


    /**
     * Load options from site
     */
    public function loadSiteOptions(){
        $this->returnAjax['site_title'] = get_option('blogname');
        $this->returnAjax['site_description'] = get_option('blogdescription');
        $this->returnAjax['site_is_public'] = get_option('blog_public');
    }


    /**
     * Set blog name
     * @param $objData
     */
    public function setBlogTitle($objData){
        if (!isset($objData->site_title) || $objData->site_title == ''){
            // need more data
            array_push($this->tabErrors, __('Veuillez saisir le titre du site', 'optimizme'));
        }
        else {
            update_option('blogname', $objData->site_title);
        }
    }

    /**
     * Set blog name
     * @param $objData
     */
    public function setBlogDescription($objData){
        update_option('blogdescription', $objData->site_description);
    }

}