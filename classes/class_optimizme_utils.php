<?php
/**
 * Created by PhpStorm.
 * User: clement
 * Date: 07/11/2016
 * Time: 16:25
 */
class OptMeUtils
{
    /**
     * Dump formatted content
     * @param $s
     */
    public static function nice($s){
        echo '<pre>';print_r($s);echo'</pre>';
    }

    /**
     * Affichage des derniers articles du blog
     * @param $feed
     * @param $nbElements
     */
    public static function showNewsRss($feed, $nbElements){
    }

    /**
     * Return list of messages
     * @param $tabMessages
     * @return string
     */
    public static function getListMessages($tabMessages, $list=0){

        $msg = '';
        if (is_array($tabMessages) && count($tabMessages)>0)
        {
            if ($list == 1){
                $msg .= '<ul>';
                foreach ($tabMessages as $message)
                    $msg .= '<li>'. $message .'</li>';
                $msg .= '</ul>';
            }
            else {
                foreach ($tabMessages as $message)
                    $msg .= $message;
            }

        }
        return $msg;
    }

    /**
     * @param $message
     * @param string $statut : updated / error
     */
    public static function showMessageBackoffice($message, $statut='updated'){
        ?>
        <div class="<?php echo $statut ?> notice">
            <p><?php echo $message ?></p>
        </div>
        <?php
    }


    /**
     * Check if media exists in CMS media library
     * @param $urlFile
     * @return bool
     */
    public static function isMediaInLibrary($urlFile){

        if ( !stristr($urlFile, __PS_BASE_URI__) ){

            // different: copy to prestashop
            $basenameFile = basename($urlFile);
            if (file_exists(_PS_IMG_DIR_ .'/cms/'. $basenameFile)){
                return Tools::getHttpHost(true).__PS_BASE_URI__ .'img/cms/'.$basenameFile;
            }
            else{
                return false;
            }
        }
        else {
            // same: image already in prestashop
            return $urlFile;
        }
    }


    /**
     * Add media in library
     * @param $urlFile : URL where to download and copy file
     * @return false|string
     */
    public static function addMediaInLibrary($urlFile){

        $urlMedia = '';

        $nameFile = basename($urlFile);
        $uploaddir = _PS_IMG_DIR_ .'cms';
        $uploadfile = $uploaddir . '/' . $nameFile;

        // write file in media
        try {
            $contents = file_get_contents($urlFile);
            $savefile = fopen($uploadfile, 'w');
            fwrite($savefile, $contents);
            fclose($savefile);
            $newUrl = Tools::getHttpHost(true).__PS_BASE_URI__ .'img/cms/'. $nameFile;
            return $newUrl;
        }
        catch (Exception $e){
            return false;
        }
    }

    /**
     *
     * @param $url
     * @return bool
     */
    public static function isFileMedia($url){

        $infos = pathinfo($url);
        $extensionMediaAutorized = OptMeUtils::getAuthorizedMediaExtension();
        if (is_array($infos) && isset($infos['extension']) && $infos['extension'] != ''){
            // extension found: is it authorized?
            if (in_array($infos['extension'], $extensionMediaAutorized)){
                return true;
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public static function getAuthorizedMediaExtension(){
        $tabExtensions = array( 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg', //Images
            'doc', 'docx', 'rtf', 'pdf', 'xls', 'xlsx', 'ppt', 'pptx', 'odt', 'ots', 'ott', 'odb', 'odg', 'otp', 'otg', 'odf', 'ods', 'odp' // files
        );
        return $tabExtensions;
    }

    /**
     * Get meta description
     * @param $post
     * @return mixed
     */
    public static function getMetaDescription($post){

        $fieldMeta = OptMeUtils::getPostMetaKeyFromType('metadescription');
        $metaDescription = get_post_meta($post->ID, $fieldMeta, true);

        return $metaDescription;
    }


    /**
     * @param $type
     * @return string
     */
    public static function getPostMetaKeyFromType($type)
    {

    }

    /**
     * @param $newMetaValue
     * @param $idPost
     * @param $metaKey
     * @return bool
     */
    public static function doUpdatePostMeta($newMetaValue, $idPost, $metaKey){
        $currentMetaDescription = get_post_meta($idPost, $metaKey, true);
        if ($currentMetaDescription == $newMetaValue)       return false;
        else                                                return true;
    }


    /**
     *
     */
    public static function getMediaFilesCMS(){
        $cmsFolder = _PS_IMG_DIR_ .'/cms/';


    }



    /**
     * Get canonical url
     * @param string $post
     * @return string
     */
    public static function getCanonicalUrl($post=''){

    }

    /**
     * @param $post
     * @return mixed
     */
    public static function getMetaNoIndex($post){

    }

    /**
     * @param $post
     * @return mixed
     */
    public static function getMetaNoFollow($post){

    }


    /**
     * Get Dom from html
     *  and add a "<span>" tag in top
     * @param $doc
     * @param $tag
     * @param $content
     * @return DOMNodeList
     */
    public static function getNodesInDom($doc, $tag, $content){

        // load post content in DOM
        libxml_use_internal_errors(true);
        $doc->loadHTML('<span>'.$content.'</span>');
        libxml_clear_errors();

        // get all images in post content
        $xp = new DOMXPath($doc);
        $nodes = $xp->query('//'.$tag);
        return $nodes;
    }

    /**
     * Get HTML from dom document
     *  and remove "<span>" tag in top
     * @param $doc
     * @return string
     */
    public static function getHtmlFromDom($doc){
        $racine = $doc->getElementsByTagName('span')->item(0);
        $newContent = '';
        if ($racine->hasChildNodes()){
            foreach ($racine->childNodes as $node){
                $newContent .= utf8_decode($doc->saveHTML($node));
            }
        }
        return $newContent;
    }


    /**
     * Clean content before saving
     * @param $content
     * @return mixed
     */
    public static function cleanHtmlFromEasycontent($content){
        $content = str_replace(' easyContentAddRow', '', $content);
        $content = str_replace(' ui-droppable', '', $content);
        $content = str_replace('style=""', '', $content);
        $content = str_replace('class=""', '', $content);

        return trim($content);
    }


    /**
     * Return all languages from the shop
     * @return array
     */
    public static function getPrestashopLanguages(){
        $langs = Language::getLanguages(true);
        return $langs;
    }


    /**
     * Return permalink for a product
     * @param $idProduct
     * @return string
     */
    public static function getProductUrl($idProduct, $idLang){
        $product = new Product($idProduct, false, $idLang);
        $link = new Link();
        $url = $link->getProductLink($product, null, null, null, $idLang);
        return $url;
    }


    /**
     * @param $idElement
     * @param string $id_lang
     * @param $type
     * @param $field
     * @param $value
     * @param $objAction
     * @param int $isRequired
     */
    public static function saveObjField($idElement, $id_lang='', $type, $field, $value, $objAction, $isRequired=0){

        if ( !is_numeric($idElement)){
            // need more data
            array_push($objAction->tabErrors, 'ID product not sent');
        }
        elseif ( $isRequired == 1 && $value == ''){
            // no empty
            array_push($objAction->tabErrors, 'This field is mandatory');
        }
        elseif (!isset($value)){
            // need more data
            array_push($objAction->tabErrors, 'Field '. $field .' missing');
        }
        else{

            // all is ok
            if ($type == 'product')     $obj = new Product($idElement);
            else                        $obj = new Category($idElement);

            if ($id_lang != ''){
                // update field for a specific language
                $tabField = $obj->$field;
                if (is_array($tabField)){
                    $tabField[$id_lang] = $value;
                    $obj->$field = $tabField;
                }
            }
            else{
                // update field
                $obj->$field = $value;
            }

            try {
                $obj->save();
            } catch (Exception $e) {
                // error
                array_push($objAction->tabErrors, 'CATCH '. $e->getMessage());
            }
        }
    }
}