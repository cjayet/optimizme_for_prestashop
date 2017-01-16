<?php
use Firebase\JWT\JWT;

/**
 * Class Optimizme
 */
class OptimizMeCore extends Module{

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

        // ACTIONS
        $optAction = new OptimizMeActions();

        if (isset($_REQUEST['data_optme']) && $_REQUEST['data_optme'] != '')
        {
            // is valid request?
            try {
                $decoded = JWT::decode($_REQUEST['data_optme'], OPTIMIZME_JWT_SECRET, array('HS256'));
            }
            catch (Exception $e){// signature not correct
                $msg = $this->getTranslator()->trans('Invalid token, security error', array(), 'Modules.OptimizMeForPrestashop');
                $optAction->setMsgReturn($msg, 'danger');
                die;
            }

            if ($decoded == false){
                // decoded error
                $msg = $this->getTranslator()->trans('Problem decoding JWT, security error', array(), 'Modules.OptimizMeForPrestashop');
                $optAction->setMsgReturn($msg, 'danger');

                // ajax to return - encode data
                $optAction->setDataReturn($optAction->returnAjax);
                die;
            }


            // JWT ok, go on
            $dataOptimizme =  $decoded;

            // post id
            $elementId = '';
            if (is_numeric($dataOptimizme->url_cible))      $elementId = $dataOptimizme->url_cible;
            else {
                if (isset($dataOptimizme->id_post) && $dataOptimizme->id_post != ''){
                    $elementId = $dataOptimizme->id_post;
                }
            }


            if ($dataOptimizme->action == '')
            {
                // no action specified
                $msg = $this->getTranslator()->trans('Aucune action de définie', array(), 'Modules.OptimizMeForPrestashop');
                $optAction->setMsgReturn($msg, 'danger');
            }
            else
            {
                // action to do
                switch ($dataOptimizme->action){

                    // post
                    case 'set_post_title' :                 $optAction->setTitle($elementId, $dataOptimizme); break;
                    case 'set_post_content' :               $optAction->setContent($elementId, $dataOptimizme); break;
                    case 'set_post_shortdescription' :      $optAction->setShortDescription($elementId, $dataOptimizme); break;
                    case 'set_post_metadescription' :       $optAction->setMetaDescription($elementId, $dataOptimizme); break;
                    case 'set_post_metatitle' :             $optAction->setMetaTitle($elementId, $dataOptimizme); break;
                    case 'set_post_slug' :                  $optAction->setProductSlug($elementId, $dataOptimizme); break;
                    case 'set_post_status' :                $optAction->setPostStatus($elementId, $dataOptimizme); break;
                    case 'set_post_imgattributes' :         $optAction->setAttributesTag($elementId, $dataOptimizme, 'img'); break;
                    case 'set_post_hrefattributes' :        $optAction->setAttributesTag($elementId, $dataOptimizme, 'a'); break;

                    // redirections
                    case 'redirection_enable':              $optAction->enableDisableRedirection($dataOptimizme, 0); break;
                    case 'redirection_disable':             $optAction->enableDisableRedirection($dataOptimizme, 1); break;
                    case 'redirection_delete':              $optAction->deleteRedirection($dataOptimizme); break;

                    // load content
                    case 'load_posts_pages':                $optAction->loadPostsPages($dataOptimizme); break;
                    case 'load_post_content' :              $optAction->loadPostContent($elementId, $dataOptimizme); break;
                    case 'load_redirections':               $optAction->loadRedirections(); break;

                    // categories
                    case 'load_categories':                 $optAction->loadCategories($dataOptimizme); break;
                    case 'load_category_content':           $optAction->loadCategoryContent($elementId, $dataOptimizme); break;
                    case 'set_category_name':               $optAction->setCategoryName($elementId, $dataOptimizme); break;
                    case 'set_category_description':        $optAction->setCategoryDescription($elementId, $dataOptimizme); break;
                    case 'set_category_slug':               $optAction->setCategorySlug($elementId, $dataOptimizme); break;
                    case 'set_category_metatitle':          $optAction->setCategoryMetaTitle($elementId, $dataOptimizme); break;
                    case 'set_category_metadescription':    $optAction->setCategoryMetaDescription($elementId, $dataOptimizme); break;

                    default:                                $this->boolNoAction = 1; break;
                }


                // results of action
                if ($this->boolNoAction == 1)
                {
                    // no action done
                    $msg = $this->getTranslator()->trans('Aucune action trouvée', array(), 'Modules.OptimizMeForPrestashop');

                    $optAction->setMsgReturn($msg, 'danger');
                }
                else
                {
                    // action done
                    if (is_array($optAction->tabErrors) && count($optAction->tabErrors) > 0)
                    {
                        $optAction->returnResult['result'] = 'danger';
                        $msg = $this->getTranslator()->trans('Une ou plusieurs erreurs ont été levées : ', array(), 'Modules.OptimizMeForPrestashop');
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
                        $msg = $this->getTranslator()->trans('Modification effectuée avec succès.', array(), 'Modules.OptimizMeForPrestashop');
                        $msg .= OptMeUtils::getListMessages($optAction->tabSuccess);
                        $optAction->setMsgReturn($msg);
                    }
                }
            }

            // stop script - no need to go further
            die;
        }
    }
}
