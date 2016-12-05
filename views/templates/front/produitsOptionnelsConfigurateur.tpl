
{if $page_name == 'index'}

    <div class="col-xs-12">
        <h2>Choisissez vos options</h2>

        <div id="options-proposees">

            <div class="row container-options">
                <div class="accordion-toggle col-sm-12 pointer"  data-toggle="collapse" data-target="#blocOpt1">
                    <h3 style="float:left">
                        Kit lumière
                    </h3>
                    <span class="blocInfobulle">
                        {$titreAide = "Informations"}
                        {$placementAide = 'right'}
                        {$contenuAide = "Vous souhaitez avoir la lumière jour et nuit ? L’option kit lumière vous permet d’installer à l'intérieur du conduit de lumière un éclairage complémentaire électrique. Idéal lorsque le diffuseur du conduit de lumière s'installe à la place d’un luminaire existant."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </span>
                    <div class="clear"></div>
                    <i class="iconToggle fa fa-plus-circle fa-2x" aria-hidden="true"></i>
                </div>

                <div id="blocOpt1" class="collapse liste-options">
                    {foreach from=$tabOptions1 item=option1 name=option1}

                        <hr />
                        <div class="row ligne-option">
                            <div id="bloc-option-{$option1['id_option']}" class="col-sm-4 bloc-option">
                                <img src="{$link->getMediaLink("`$module_dir``$option1['url_image']`")}" class="align-center border-gris img-responsive img-option" />
                            </div>
                            <div class="col-sm-8">
                                <h4>
                                    {$option1['libelle']|escape:'html':'UTF-8'}

                                    {$titreAide = $option1['infobulle_titre']}
                                    {$placementAide = 'right'}
                                    {$contenuAide = $option1['infobulle_contenu']}
                                    {include file="$tpl_module_dir/bulleAide.tpl"}

                                </h4>

                                <div id="qte-option-{$option1['id_option']}">
                                    <input type="text" name="option-cdl-{$option1['id_option']}" value="" placeholder="Qté" class="check-kit-qte" />
                                    <div style="display: none">
                                        <p class="alert alert-warning">Attention, vous commandez plus d'éléments que vous n'avez de kit de base </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    {/foreach}

                </div>
            </div>


            <div class="row container-options">
                <div class="accordion-toggle col-sm-12 pointer"  data-toggle="collapse" data-target="#blocOpt2">
                    <h3 style="float:left;">
                        Volet régulateur d'intensité lumineuse
                    </h3>
                    <span class="blocInfobulle">
                        {$titreAide = "Informations"}
                        {$placementAide = 'right'}
                        {$contenuAide = "Vous souhaitez varier la lumière ? Le volet régulateur d'intensité lumineuse permet de réguler pas-à-pas la luminosité de la pièce. Attention, il doit y avoir au minimum 50 cm entre la toiture et le plafond pour installer le volet régulateur."}
                        {include file="$tpl_module_dir/bulleAide.tpl"}
                    </span>
                    <div class="clear"></div>
                    <i class="iconToggle fa fa-plus-circle fa-2x" aria-hidden="true"></i>

                </div>

                <div id="blocOpt2" class="collapse liste-options">
                    {foreach from=$tabOptions2 item=option2 name=option2}

                        <hr />
                        <div class="row ligne-option">
                            <div id="bloc-option-{$option2['id_option']}" class="col-sm-4 bloc-option">
                                <img src="{$link->getMediaLink("`$module_dir``$option2['url_image']`")}" class="align-center border-gris img-responsive img-option" />
                            </div>
                            <div class="col-sm-8">
                                <h4>
                                    {$option2['libelle']|escape:'html':'UTF-8'}

                                    {$titreAide = $option2['infobulle_titre']}
                                    {$placementAide = 'right'}
                                    {$contenuAide = $option2['infobulle_contenu']}
                                    {include file="$tpl_module_dir/bulleAide.tpl"}

                                </h4>
                                <input type="text" name="option-cdl-{$option2['id_option']}" value="" placeholder="Qté" class="check-kit-qte" />
                                <div style="display: none">
                                    <p class="alert alert-warning">Attention, vous commandez plus d'éléments que vous n'avez de kit de base </p>
                                </div>
                            </div>
                        </div>

                    {/foreach}

                </div>
            </div>




            <div id="option-kit-ventil-160DS" {$DisplayInput160DS}>

                <div class="row container-options">
                    <div class="accordion-toggle col-sm-12 pointer"  data-toggle="collapse" data-target="#blocOpt4">
                        <h3 style="float: left">
                            Kit de ventilation
                        </h3>
                        <span class="blocInfobulle">
                            {$titreAide = "Informations"}
                            {$placementAide = 'right'}
                            {$contenuAide = "Vous souhaitez ajouter une ventilation au diffuseur ? Ce système 2 en 1 permet d’associer, par une même ouverture, l’éclairage naturel à la ventilation. Deux options à choisir : avec ou sans moteur. (Uniquement disponible pour le modèle Solatube 160DS)"}
                            {include file="$tpl_module_dir/bulleAide.tpl"}
                        </span>
                        <div class="clear"></div>
                        <i class="iconToggle fa fa-plus-circle fa-2x" aria-hidden="true"></i>

                    </div>

                    <div id="blocOpt4" class="collapse liste-options">
                        {foreach from=$tabOptions3 item=option3 name=option3}

                            <hr />
                            <div class="row ligne-option">
                                <div id="bloc-option-{$option3['id_option']}" class="col-sm-4 bloc-option">
                                    <img src="{$link->getMediaLink("`$module_dir``$option3['url_image']`")}" class="align-center border-gris img-responsive img-option" />
                                </div>
                                <div class="col-sm-8">
                                    <h4>
                                        {$option3['libelle']|escape:'html':'UTF-8'}

                                        {$titreAide = $option3['infobulle_titre']}
                                        {$placementAide = 'right'}
                                        {$contenuAide = $option3['infobulle_contenu']}
                                        {include file="$tpl_module_dir/bulleAide.tpl"}

                                    </h4>
                                    <input type="text" name="option-cdl-{$option3['id_option']}" value="" placeholder="Qté" class="check-kit-qte" />
                                    <div style="display: none">
                                        <p class="alert alert-warning">Attention, vous commandez plus d'éléments que vous n'avez de kit de base </p>
                                    </div>
                                </div>
                            </div>

                        {/foreach}

                    </div>
                </div>

            </div>

        </div>
    </div>

{/if}