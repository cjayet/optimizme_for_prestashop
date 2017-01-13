<?php

/**
 * Class OptimizMeFO
 * Front-office
 */
class OptimizMeRedirections
{

    /**
     * OptimizMeRedirections constructor.
     */
    public function __construct() {
        if (get_class(Context::getContext()->controller) == 'PageNotFoundController'){
            // 404 error spotted
            $this->optimizme_redirect_404();
        }
    }


    /**
     * if 404, check if redirections set in optimizme_redirections table
     */
    public function optimizme_redirect_404() {
        $objRedirection = $this->getRedirection( $_SERVER['REQUEST_URI'], 0 );
        if ($objRedirection){
            Tools::redirectLink('http://www.google.fr');
            exit;
        }
    }


    /** add a redirection in optimizme_redirections */
    public function addRedirection($oldUrl, $newUrl){
        $now = date('Y-m-d h:i:s');
        $values = array(
            'url_base' => $oldUrl,
            'url_redirect' => $newUrl,
            'is_disabled' => 0,
            'created_at' => $now,
            'updated_at' => $now
        );
        return Db::getInstance()->insert('optimizme_redirections', $values);
    }


    /**
     * Edit redirection
     */
    public function editRedirection($id, $field, $value){
        // value to update
        $values  = array(
            $field => $value,
        );

        // execute
        return Db::getInstance()->update(
            'optimizme_redirections',
            $values,
            '`id`='.(int) $id
            , 1
        );
    }

    /**
     * Delete redirection
     * @param $id
     */
    public function deleteRedirection($id){
        Db::getInstance()->delete(
            'optimizme_redirections',
            '`id` = '.(int) $id
        );
    }

    /**
     * @param $id
     */
    public function disableRedirection($id){
        $this->editRedirection($id, 'is_disabled', 1);
    }

    /**
     * @param $id
     */
    public function enableRedirection($id){
        $this->editRedirection($id, 'is_disabled', 0);
    }


    /**
     * oad all saved redirections
     * @param string $statut
     * @return array|null|object
     */
    public static function getAllRedirections($statut='active'){

        if ($statut == 'disabled')      $complementSQL = ' WHERE is_disabled="1" ';
        elseif ($statut == 'all')       $complementSQL = ' ';
        else                            $complementSQL = ' WHERE is_disabled="0" ';

        $sql = 'SELECT *
                FROM '. _DB_PREFIX_ .'optimizme_redirections 
                '. $complementSQL .'
                ORDER BY id';
        $redirections = Db::getInstance()->executeS($sql);

        return $redirections;

    }

    /**
     * @param $oldUrl
     * @return array|null|object|void
     */
    public function getRedirection($oldUrl, $isDisabled=0){

        $sql = 'SELECT * 
                FROM `'._DB_PREFIX_.'optimizme_redirections` as optr
				WHERE `url_base` LIKE "%'. $oldUrl .'"
				AND is_disabled="'. $isDisabled .'"';
        $objRedirect = Db::getInstance()->getRow($sql);

        return $objRedirect;
    }


    /**
     * Purge double redirections
     *  ex: link1 redirect to link2
     *      link2 redirect to link3
     *      => link1 redirect to link3
     */
    public function checkAndPurgeUrlIfDoubleRedirections(){
        $sql = 'SELECT r1.id as r1id, r1.url_base as r1url_base, r1.url_redirect as r1url_redirect,
                      r2.id as r2id, r2.url_redirect as r2url_redirect
                FROM '. _DB_PREFIX_ .'optimizme_redirections r1
                JOIN '. _DB_PREFIX_ .'optimizme_redirections r2 on r1.id != r2.id
                WHERE r2.url_base = r1.url_redirect';
        $results = Db::getInstance()->executeS($sql);

        if (is_array($results) && count($results)>0){
            foreach ($results as $doubleRedirection){
                $this->editRedirection($doubleRedirection['r1id'], 'url_redirect', $doubleRedirection['r2url_redirect']);
            }
        }
    }
}