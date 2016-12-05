{capture name=path}{l s='Accueil' mod='descodecalculateurconfigachat'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<form method="post" action="" id="form-global" class="descode-configurateur">

    <div id="configurateur-partie-1">

        <ul class="step stepcdl clearfix" id="order_step">
            <li class="step_todo first">
                <span><em>1.</em> Votre projet</span>
            </li>
            <li class="step_current second">
                <span><em>2.</em> Choix  modèle / nombre</span>
            </li>
            <li class="step_todo third">
                <span><em>3.</em> Choix des options</span>
            </li>
            <li id="step_end" class="step_todo last">
                <span><em>4.</em> Résultat personnalisé</span>
            </li>
        </ul>

        <p style="font-size: 1.1em">Voici la solution recommandée par notre configurateur pour votre projet, cependant vous pouvez changer de modèle ainsi que le nombre si vous le souhaitez.</p>


        <div id="selection-modele" class="row">

            <div class="col-md-6">
                <div class="text-center">
                    <img id="boutonKit160" src="{$link->getMediaLink("`$module_dir`views/templates/front/images/configurateur/brighten_up_160ds.jpg")}" class="align-center border-gris img-responsive boutonChoixProduit {$classeBouton160}" />
                    {if $ModeleConseille == '160 DS'}
                        <p class="cdl-modele-recommande">Modèle recommandé</p>
                    {/if}
                    <div id="contenu-depliage-160" class="contenu-depliage" {$DisplayInput160DS} >
                        <h3 class="text-left fleft">Nombre recommandé</h3>
                        <span class="fleft">
                            {$titreAide = 'Informations'}
                            {$placementAide = 'right'}
                            {$contenuAide = "Voici la solution recommandée par notre configurateur pour votre projet, cependant vous pouvez changer de modèle ainsi que le nombre si vous le souhaitez."}
                            {include file="$tpl_module_dir/bulleAide.tpl"}
                        </span>
                        <input type="text" value="{$NbrKit160}" id="NbrKit160DS" name="NbrKit160DS" class="form-control input-nb-kit" placeholder="" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div  class="text-center">
                    <img id="boutonKit290" src="{$link->getMediaLink("`$module_dir`views/templates/front/images/configurateur/brighten_up_290ds.jpg")}" class="align-center border-gris img-responsive boutonChoixProduit {$classeBouton290}" />
                    {if $ModeleConseille == '290 DS'}
                        <p class="cdl-modele-recommande">Modèle recommandé</p>
                    {/if}
                    <div id="contenu-depliage-290" class="contenu-depliage" {$DisplayInput290DS} >
                        <h3 class="text-left fleft">Nombre recommandé</h3>
                        <span class="fleft">
                            {$titreAide = 'Informations'}
                            {$placementAide = 'right'}
                            {$contenuAide = "Voici la solution recommandée par notre configurateur pour votre projet, cependant vous pouvez changer de modèle ainsi que le nombre si vous le souhaitez."}
                            {include file="$tpl_module_dir/bulleAide.tpl"}
                        </span>
                        <input type="text" value="{$NbrKit290}" id="NbrKit290DS" name="NbrKit290DS" class="form-control input-nb-kit" />
                    </div>
                </div>
            </div>
        </div>

        <div id="formulaire-modele" class="row">
            <div class="col-md-6 align-center hidden-xs">
                <div id="container-cld-explose" class="text-center">
                    <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/configurateur/img_brigthen_up_v2.jpg")}" class="align-center img-responsive" />

                    <div class="container-points-cdl container-points-cdl-1">
                        {$titreAide = 'Dôme de collecte avec prismes'}
                        {$placementAide = 'right'}
                        {$contenuAide = "Constitué d’une  lentille d’écrêtage unique au monde qui limite l’éblouissement et permet de profiter d’un éclairage confortable et uniforme. Dôme breveté, ne jaunissant pas avec le temps, constitué de prismes sur tout le dôme orientant tous les rayons du soleil."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </div>

                    <div class="container-points-cdl container-points-cdl-2">
                        {$titreAide = 'Etanchéité 100% métallique'}
                        {$placementAide = 'right'}
                        {$contenuAide = "Tous nos solins sont en métal afin de bénéficier d’une meilleure durabilité dans le temps."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </div>

                    <div class="container-points-cdl container-points-cdl-3">
                        {$titreAide = 'Anneau du dôme'}
                        {$placementAide = 'right'}
                        {$contenuAide = "Equipé d’un joint, qui améliore l’isolation thermique, et d’orifices grillagés pour l’écoulement de la condensation."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </div>

                    <div class="container-points-cdl container-points-cdl-4">
                        {$titreAide = 'Angle adaptateur supérieur'}
                        {$placementAide = 'right'}
                        {$contenuAide = "Permet de réaliser un angle de 0 à 30° sans pièce supplémentaire."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </div>

                    <div class="container-points-cdl container-points-cdl-5">
                        {$titreAide = 'Tube droit'}
                        {$placementAide = 'right'}
                        {$contenuAide = "Equipé d’un taux de réflexion unique de 99,7% réduisant la perte lumineuse même avec une longueur importante. Des rallonges de 400 ou 600 mm s’emboîtent les unes dans les autres pour s’adapter à votre projet."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </div>

                    <div class="container-points-cdl container-points-cdl-6">
                        {$titreAide = 'Angle adaptateur inférieur'}
                        {$placementAide = 'right'}
                        {$contenuAide = "Permet de réaliser un angle de 0 à 30° sans pièce supplémentaire."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </div>

                    <div class="container-points-cdl container-points-cdl-7">
                        {$titreAide = 'Anneau fixation du diffuseur '}
                        {$placementAide = 'right'}
                        {$contenuAide = "Le tube inférieur se fixe simplement et rapidement avec les clavettes."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </div>

                    <div class="container-points-cdl container-points-cdl-8">
                        {$titreAide = 'Paroi interne'}
                        {$placementAide = 'right'}
                        {$contenuAide = "Joint qui permet de limiter les pertes thermiques."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </div>

                    <div class="container-points-cdl container-points-cdl-9">
                        {$titreAide = 'Diffuseur'}
                        {$placementAide = 'right'}
                        {$contenuAide = "Plusieurs modèles de diffuseurs possibles pour s’adapter à votre intérieur, en verre ou en plastique et sans vis apparentes."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </div>

                </div>
            </div>

            <div class="col-md-6">

                <div class="champs-form row">
                    <div class="col-xs-4">
                        <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/configurateur/img_rehausse.jpg")}" class="img-responsive" />
                    </div>
                    <div class="col-xs-8">
                        <h3 class="fleft w80">Vous souhaitez inclure une rehausse de 100mm ?</h3>
                        <span class="fleft">
                            {$titreAide = 'Informations'}
                            {$placementAide = 'top'}
                            {$contenuAide = "La rehausse s'installe entre l'étanchéité et le dôme. Elle est nécessaire dans les cas suivants :<br /> - Enneigement important de la toiture<br /> - Longueur totale du tube inférieure à 30cm"}
                            {include file="$tpl_module_dir/bulleAide.tpl"}
                        </span>
                        <div class="col-xs-7 row">
                            <select id="nb-rehausses" name="nb-rehausses" class="selectDropDown">
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="champs-form row">
                    <div class="col-xs-4">
                        <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/configurateur/img_coudes.jpg")}" class="img-responsive" />
                    </div>
                    <div class="col-xs-8">
                        <h3 class="fleft w80">Vous souhaitez ajouter un coude ?</h3>
                        <span class="fleft">
                            {$titreAide = 'Informations'}
                            {$placementAide = 'top'}
                            {$contenuAide = "Les tubes adaptateurs supérieur et inférieur sont intégrés par défaut dans le kit de base Solatube. Ils permettent de réaliser un angle jusqu'à 30°. Si vous avez besoin d'un angle plus important, un tube coudé peut être ajouté afin de créer un angle de 0 à 90°. Ces déviations permettent d'éviter des pièces de charpente dans les combles."}
                            {include file="$tpl_module_dir/bulleAide.tpl"}
                        </span>
                        <div class="col-xs-7 row">
                            <select id="nb-coudes" name="nb-coudes" class="selectDropDown">
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="input-diffuseur-160DS" {$DisplayInput160DS}>
                    <h3 class="fleft">Diffuseur à installer</h3>
                    <span class="fleft">
                        {$titreAide = 'Informations'}
                        {$placementAide = 'top'}
                        {$contenuAide = "Plusieurs modèles de diffuseurs possibles pour s’adapter à votre intérieur, en verre ou en plastique et sans vis apparentes."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </span>
                    <select id="diffuseur-classique-160" name="diffuseur-160" class="">
                        <option value="" data-description="">Choisissez votre diffuseur</option>
                        {foreach from=$tabDiffuseurs160 item=diffuseur name=diffuseurs}
                            <option value="{$diffuseur->reference}" data-image="{$diffuseur->imgCover}" data-description="">{$diffuseur->name[1]|escape:'html':'UTF-8'}</option>
                        {/foreach}
                    </select>
                    <div id="erreur-diffuseur-160" style="display: none">
                        <p class="alert alert-warning">Veuillez choisir un diffuseur pour votre kit 160 DS</p>
                    </div>
                </div>

                <div id="input-diffuseur-290DS" {$DisplayInput290DS}>
                    <h3 class="fleft">Diffuseur à installer</h3>
                    <span class="fleft">
                        {$titreAide = 'Informations'}
                        {$placementAide = 'top'}
                        {$contenuAide = "Plusieurs modèles de diffuseurs possibles pour s’adapter à votre intérieur, en verre ou en plastique et sans vis apparentes"}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </span>
                    <select id="diffuseur-classique-290" name="diffuseur-290" class="">
                        <option value="" data-description="">Choisissez votre diffuseur</option>
                        {foreach from=$tabDiffuseurs290 item=diffuseur name=diffuseurs}
                            <option value="{$diffuseur->reference}" data-image="{$diffuseur->imgCover}" data-description="">{$diffuseur->name[1]|escape:'html':'UTF-8'}</option>
                        {/foreach}
                    </select>
                    <div id="erreur-diffuseur-290" style="display: none">
                        <p class="alert alert-warning">Veuillez choisir un diffuseur pour votre kit 290 DS</p>
                    </div>
                </div>


                <div class="champs-form col-xs-12">
                    <button type="button" class="btn btn-success btn-lg btn-block btn-config-go-part-2">Continuer ></button>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div id="configurateur-partie-2" style="display: none">

        <ul class="step stepcdl clearfix" id="order_step">
            <li class="step_todo first">
                <span><em>1.</em> Votre projet</span>
            </li>
            <li class="step_todo second">
                <span><em>2.</em> Choix  modèle / nombre</span>
            </li>
            <li class="step_current third">
                <span><em>3.</em> Choix des options</span>
            </li>
            <li id="step_end" class="step_todo last">
                <span><em>4.</em> Résultat personnalisé</span>
            </li>
        </ul>


        <div class="row">

            {include file="$tpl_module_dir/produitsOptionnelsConfigurateur.tpl"}
        </div>

        <div class="row bouton-navigation-step">

            <div class="col-xs-4">
                <button type="button" class="btn btn-success btn-lg btn-block btn-config-go-part-1">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    Retour  configuration
                </button>
            </div>
            <div class="col-xs-4">&nbsp;</div>
            <div class="col-xs-4">
                <input type="submit" value="Calculer votre configuration >" class="btn btn-success btn-lg btn-block" />
            </div>

        </div>

        <hr>
    </div>



	<input type="hidden" id="type-kit" name="type-kit" value="{$ModeleConseille}" />
	<input type="hidden" id="longueur-tube" name="longueur-tube" value="{$longueurTube}" />
	<input type="hidden" id="type-couverture" name="type-couverture" value="{$typeCouverture}" />
	<input type="hidden" id="pente-toit" name="pente-toit" value="{$penteToit}" />

    <input type="hidden" name="envoi-calculateur" value="1" />

</form>