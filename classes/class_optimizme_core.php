<?php
/**
 * Class Optimizme
 */
class OptimizMeCore {
    public $boolNoAction;
    /**
     * OptimizMeCore constructor.
     */
    public function __construct(){
        $this->boolNoAction = 0;
    }
    /**
     * Route action if necessary
     */
    public function rootAction(){
        if (isset($_REQUEST['data_optme']) && $_REQUEST['data_optme'] != '')
        {
            // récupération des données
            $dataOptimizme = json_decode(stripslashes($_REQUEST['data_optme']));
            // action to do
            $optAction = new OptimizMeActions();
            // id post to update, from url
            if (is_numeric($dataOptimizme->url_cible))      $postId = $dataOptimizme->url_cible;
            else                                            $postId = url_to_postid( $dataOptimizme->url_cible );
            if ($dataOptimizme->id_post != ''){
                $postId = $dataOptimizme->id_post;
            }
            /*
            if ($postId == 0)
            {
                // url not found
                $msg = __('URL non trouvée, est-ce bien un article ou une page ?', 'optimizme');
                $optAction->setMsgReturn($msg, 'danger');
            }
            elseif ($dataOptimizme->action == '')
            */
            if ($dataOptimizme->action == '')
            {
                // no action specified
                $msg = __('Aucune action de définie', 'optimizme');
                $optAction->setMsgReturn($msg, 'danger');
            }
            else
            {
                // action to do
                switch ($dataOptimizme->action){
                    // post
                    case 'set_post_title' :             $optAction->updateTitle($postId, $dataOptimizme); break;
                    case 'set_post_content' :           $optAction->updateContent($postId, $dataOptimizme); break;
                    case 'set_post_metadescription' :   $optAction->updateMetaDescription($postId, $dataOptimizme); break;
                    case 'set_post_slug' :              $optAction->updateSlug($postId, $dataOptimizme); break;
                    case 'set_post_canonicalurl' :      $optAction->updateCanonicalUrl($postId, $dataOptimizme); break;
                    case 'set_post_metarobots' :        $optAction->updateMetaRobots($postId, $dataOptimizme); break;
                    case 'set_post_status' :            $optAction->updatePostStatus($postId, $dataOptimizme); break;
                    case 'set_post_imgattributes' :     $optAction->updateAttributesTag($postId, $dataOptimizme, 'img'); break;
                    case 'set_post_hrefattributes' :    $optAction->updateAttributesTag($postId, $dataOptimizme, 'a'); break;
                    // redirections
                    case 'redirection_enable':          $optAction->enableDisableRedirection($dataOptimizme, 0); break;
                    case 'redirection_disable':         $optAction->enableDisableRedirection($dataOptimizme, 1); break;
                    case 'redirection_delete':          $optAction->deleteRedirection($dataOptimizme); break;
                    // load content
                    case 'load_post_content' :          $optAction->loadPostContent($postId, $dataOptimizme); break;
                    case 'load_posts_pages':            $optAction->loadPostsPages($dataOptimizme); break;
                    case 'load_lorem_ipsum':            $optAction->loadLoremIpsum(); break;
                    case 'load_redirections':           $optAction->loadRedirections(); break;
                    case 'load_images_post':            $optAction->loadImagesFromPost($postId, $dataOptimizme); break;
                    case 'load_href_post':              $optAction->loadHrefFromPost($postId, $dataOptimizme); break;
                    case 'load_site_options':           $optAction->loadSiteOptions(); break;
                    // create content
                    case 'set_create_post':             $optAction->createPost($dataOptimizme); break;
                    // blogs
                    case 'set_site_title':              $optAction->setBlogSite($dataOptimizme); break;
                    case 'set_site_description':        $optAction->setBlogDescription($dataOptimizme); break;
                    case 'set_site_blogpublic':         $optAction->setBlogPublicOrPrivate($dataOptimizme); break;
                    default:                            $this->boolNoAction = 1; break;
                }
                // results of action
                if ($this->boolNoAction == 1)
                {
                    // no action done
                    $msg = __('Aucune action trouvée.', 'optimizme');
                    $optAction->setMsgReturn($msg, 'danger');
                }
                else
                {
                    // action done
                    if (is_array($optAction->tabErrors) && count($optAction->tabErrors) > 0)
                    {
                        $optAction->returnResult['result'] = 'danger';
                        $msg = __('Une ou plusieurs erreurs ont été levées : ', 'optimizme');
                        $msg .= OptMeUtils::getListMessages($optAction->tabErrors, 1);
                        $optAction->setMsgReturn($msg, 'danger');
                    }
                    elseif (is_array($optAction->returnAjax) && count($optAction->returnAjax) > 0)
                    {
                        // ajax to return - encode data
                        $optAction->setDataReturn($optAction->returnAjax);
                    }
                    else
                    {
                        // no error, OK !
                        $msg = __('Modification effectuée avec succès.', 'optimizme');
                        $msg .= OptMeUtils::getListMessages($optAction->tabSuccess);
                        $optAction->setMsgReturn($msg);
                    }
                }
            }
            // stop script
            die;
        }
    }
}