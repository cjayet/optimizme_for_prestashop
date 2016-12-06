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
     * Check if media exists in media library (search by title)
     * @param $urlFile
     * @return bool
     */
    public static function isMediaInLibrary($urlFile){
        $basenameFile = basename($urlFile);
        $media = get_page_by_title( $basenameFile, 'OBJECT', 'attachment' );

        if ($media && $media->ID != '')     return wp_get_attachment_url($media->ID);
        else                                return false;
    }


    /**
     * Add media in library
     * @param $urlFile : URL where to download and copy file
     * @return false|string
     */
    public static function addMediaInLibrary($urlFile){

        $nameFile = basename($urlFile);

        $uploaddir = wp_upload_dir();
        $uploadfile = $uploaddir['path'] . '/' . $nameFile;

        // write file in media
        $contents = file_get_contents($urlFile);
        $savefile = fopen($uploadfile, 'w');
        fwrite($savefile, $contents);
        fclose($savefile);

        // add media in database
        $wp_filetype = wp_check_filetype($nameFile, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => $nameFile,
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $uploadfile );
        $urlMediaWordpress = wp_get_attachment_url($attach_id);

        // add metadata
        $imagenew = get_post( $attach_id );
        $fullsizepath = get_attached_file( $imagenew->ID );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $fullsizepath );
        wp_update_attachment_metadata( $attach_id, $attach_data );

        return $urlMediaWordpress;
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
        $metakey = '';

        if (defined( 'YOAST_ENVIRONMENT' ))
        {
            // YOAST
            if ($type == 'noindex')                 $metakey= '_yoast_wpseo_meta-robots-noindex';
            elseif ($type == 'nofollow')            $metakey= '_yoast_wpseo_meta-robots-nofollow';
            elseif ($type == 'metadescription')     $metakey= '_yoast_wpseo_metadesc';
        }
        else
        {
            // Optimiz.me
            if ($type == 'noindex')                 $metakey= 'optimizme_meta-robots-noindex';
            elseif ($type == 'nofollow')            $metakey= 'optimizme_meta-robots-nofollow';
            elseif ($type == 'metadescription')     $metakey= 'optimizme_metadesc';
        }

        return $metakey;
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

        return $content;
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
}