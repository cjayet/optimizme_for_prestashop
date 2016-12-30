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
        /* @var $item WP_Post */
        $maxitems = 0;
        $rss_items = array();
        ?>
        <h3><?php _e( 'Articles récents de notre blog : ', 'optimizme' ); ?></h3>

        <?php
        // Get a SimplePie feed object from the specified feed source.
        $rss = fetch_feed( $feed );

        if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

            // Figure out how many total items there are, but limit it to 5.
            $maxitems = $rss->get_item_quantity( $nbElements );

            // Build an array of all the items, starting with element 0 (first element).
            $rss_items = $rss->get_items( 0, $maxitems );

        endif; ?>

        <ul>
            <?php if ( $maxitems == 0 ) : ?>
                <li><?php _e( 'Aucun article trouvé', 'optimizme' ); ?></li>
            <?php else : ?>
                <?php foreach ( $rss_items as $item ) : ?>
                    <li>
                        <a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Posté le %s', 'optimizme' ), $item->get_date('j F Y | g:i a') ); ?>" target="_blank">
                            <?php echo esc_html( $item->get_title() ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <?php
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
    public function getAuthorizedMediaExtension(){
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
        if ($post == '')    global $post;

        if (defined( 'YOAST_ENVIRONMENT' )){
            // yoast seo
            $canonical = get_post_meta($post->ID, '_yoast_wpseo_canonical', true);
        }
        else {
            // optimiz.me
            $canonical          = '';
            $canonical_override = '';

            if ( $post->ID != '' && ($post->post_type == 'post' || $post->post_type == 'page') ) {

                $obj       = get_queried_object();
                $canonical = get_permalink( $obj->ID );

                // get canonical if defined
                $canonical_override = get_post_meta($post->ID, 'optimizme_canonical', true);
                if ($canonical_override == '')
                {
                    // Fix paginated pages canonical, but only if the page is truly paginated.
                    if ( get_query_var( 'page' ) > 1 ) {
                        $num_pages = ( substr_count( $obj->post_content, '<!--nextpage-->' ) + 1 );
                        if ( $num_pages && get_query_var( 'page' ) <= $num_pages ) {
                            if ( ! $GLOBALS['wp_rewrite']->using_permalinks() ) {
                                $canonical = add_query_arg( 'page', get_query_var( 'page' ), $canonical );
                            }
                            else {
                                $canonical = user_trailingslashit( trailingslashit( $canonical ) . get_query_var( 'page' ) );
                            }
                        }
                    }
                }

                if ($canonical == '')       $canonical = get_permalink($post->ID);
            }
            else {
                if ( is_search() ) {
                    $search_query = get_search_query();

                    // Regex catches case when /search/page/N without search term is itself mistaken for search term. R.
                    if ( ! empty( $search_query ) && ! preg_match( '|^page/\d+$|', $search_query ) ) {
                        $canonical = get_search_link();
                    }
                }
                elseif ( is_front_page() ){
                    $canonical = home_url();
                }
                elseif ( is_tax() || is_tag() || is_category() ) {
                    // TODO
                    /*
                    $term = get_queried_object();
                    if ( ! empty( $term ) && ! $this->is_multiple_terms_query() ) {

                        $canonical_override = WPSEO_Taxonomy_Meta::get_term_meta( $term, $term->taxonomy, 'canonical' );
                        $term_link          = get_term_link( $term, $term->taxonomy );

                        if ( ! is_wp_error( $term_link ) ) {
                            $canonical = $term_link;
                        }
                    }
                    */
                }
                elseif ( is_post_type_archive() ) {
                    $post_type = get_query_var( 'post_type' );
                    if ( is_array( $post_type ) ) {
                        $post_type = reset( $post_type );
                    }
                    $canonical = get_post_type_archive_link( $post_type );
                }
                elseif ( is_author() ) {
                    $canonical = get_author_posts_url( get_query_var( 'author' ), get_query_var( 'author_name' ) );
                }
                elseif ( is_archive() ) {
                    if ( is_date() ) {
                        if ( is_day() ) {
                            $canonical = get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
                        }
                        elseif ( is_month() ) {
                            $canonical = get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
                        }
                        elseif ( is_year() ) {
                            $canonical = get_year_link( get_query_var( 'year' ) );
                        }
                    }
                }
            }

            // defined canonical
            if ( $canonical_override != '' ) {
                $canonical = $canonical_override;
            }
        }




        return $canonical;
    }

    /**
     * @param $post
     * @return mixed
     */
    public static function getMetaNoIndex($post){
        $keyMetaNoIndex = OptMeUtils::getPostMetaKeyFromType('noindex');
        $noIndex = get_post_meta($post->ID, $keyMetaNoIndex, true);
        return $noIndex;
    }

    /**
     * @param $post
     * @return mixed
     */
    public static function getMetaNoFollow($post){
        $keyMetaNoFollow = OptMeUtils::getPostMetaKeyFromType('nofollow');
        $noFollow = get_post_meta($post->ID, $keyMetaNoFollow, true);
        return $noFollow;
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
    public static function getProductUrl($idProduct){
        //$product = new Product(Tools::getValue('id_product'));
        $product = new Product($idProduct);
        $link = new Link();
        $url = $link->getProductLink($product);
        return $url;
    }


    /**
     * @param $idElement
     * @param $type
     * @param $field
     * @param $value
     * @param $objAction
     * @param int $isRequired
     */
    public static function saveObjField($idElement, $type, $field, $value, $objAction, $isRequired=0){

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
            $obj->$field = $value;

            try {
                $obj->save();
            } catch (Exception $e) {
                // error
                array_push($objAction->tabErrors, 'CATCH '. $e->getMessage());
            }
        }
    }
}