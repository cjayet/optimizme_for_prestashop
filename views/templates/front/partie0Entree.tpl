{capture name=path}{l s='Accueil' mod='descodecalculateurconfigachat'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<div id="choix-type-produit">
    <h3>Choisissez votre type de produit</h3>

    <div class="col-md-4">
        <div id="bouton-partie-3" class="text-center">
            <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/choix-type/choix-cdl.jpg")}" class="align-center border-gris img-responsive pointer" />
            <h3 class="text-left">Conduit de lumière</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div id="bouton-partie-2" class="text-center">
            <img  src="{$link->getMediaLink("`$module_dir`views/templates/front/images/choix-type/choix-reflecteur.jpg")}" class="align-center border-gris img-responsive pointer" />
            <h3 class="text-left">Réflecteur</h3>
        </div>
    </div>

    <div class="col-md-4">
        <div id="bouton-partie-1" class="text-center">
            <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/choix-type/choix-extracteur.jpg")}" class="align-center border-gris img-responsive pointer" />
            <h3 class="text-left">Extracteur d'air Solaire</h3>
        </div>
    </div>

    <input type="hidden" id="type-formulaire-accueil" name="type-formulaire-accueil" value="" />

    <div class="marge-bottom-configurateur">&nbsp;</div>
</div>

