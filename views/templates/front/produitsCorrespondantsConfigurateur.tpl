{if $page_name == 'index'}

    {capture name=path}{l s='Accueil' mod='descodecalculateurconfigachat'}{/capture}
    {include file="$tpl_dir./breadcrumb.tpl"}

    <ul class="step stepcdl clearfix" id="order_step">
        <li class="step_todo first">
            <span><em>1.</em> Votre projet</span>
        </li>
        <li class="step_todo second">
            <span><em>2.</em> Choix  modèle / nombre</span>
        </li>
        <li class="step_todo third">
            <span><em>3.</em> Choix des options</span>
        </li>
        <li id="step_end" class="step_current last">
            <span><em>4.</em> Résultat personnalisé</span>
        </li>
    </ul>

    <form action="" method="post" class="descode-configurateur">

        <div class="col-xs-12">
            <h2>La Configuration de votre projet</h2>
        </div>
        <div class="{$largeurCol}">

            {foreach from=$tabProduitsResultat item=product name=products}
                {include file="$tpl_module_dir/produitPanierPersonnalise.tpl"}
            {/foreach}
            <hr />

            {if $tabProduitsOption|@count gt 0}
                <h2>Options</h2>
                {$flagPossibiliteModifierQuantite = 1}
                {foreach from=$tabProduitsOption item=product name=products}
                        {include file="$tpl_module_dir/produitPanierPersonnalise.tpl"}
                {/foreach}
                <hr />
            {/if}

            <div id="recalcul-configurateur"></div>

            <div id="total-produit" class="row marge-bottom-configurateur">
                <div class="col-md-4">
                    <div class="titre-total">Total de votre configuration</div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div id="nc-configurateur-prix-total" class="prix">{$prixTotalIndicatif}€ TTC</div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <!-- <button type="button" class="btn btn-warning btn-lg btn-block">Ajouter au panier</button> -->
                    <!-- <input type="submit" class="btn btn-warning btn-lg btn-block" value="Ajouter au panier" /> -->
                    <button type="button" class="btn btn-warning btn-lg btn-block add-all-panier-ajax">Ajouter au panier</button>
                    <input type="hidden" name="ajouterArticlesPanier" value="1" />
                </div>
            </div>
        </div>

        {if $flagPossibiliteModifierQuantite == 0}
            <div class="col-sm-3">
                <div id="bloc-recap-infos-cdl">
                    <h4>Votre projet</h4>
                    <div class="ligne">
                        <div class="libelle">Département du projet : </div>
                        <div class="valeur">{$departement}</div>
                    </div>
                    <div class="ligne">
                        <div class="libelle">Puissance souhaitée : </div>
                        <div class="valeur">{$puissanceLumSouhaitee}</div>
                    </div>
                    <div class="ligne">
                        <div class="libelle">Volume de la surface sombre à éclairer : </div>
                        <div class="valeur">{$cdlLongueur}x{$cdlLargeur}x{$cdlHauteur}m</div>
                    </div>
                    <div class="ligne">
                        <div class="libelle">Longueur du parcours du tube : </div>
                        <div class="valeur">{$cdlLongueurTube}m</div>
                    </div>
                    <div class="ligne">
                        <div class="libelle">Pente du toit : </div>
                        <div class="valeur">{$cdlPenteToit}</div>
                    </div>
                    <div class="ligne">
                        <div class="libelle">Type de couverture : </div>
                        <div class="valeur">{$cdlTypeCouverture}</div>
                    </div>
                </div>

            </div>
        {/if}
        <hr />
    </form>


{/if}

{addJsDef allowBuyWhenOutOfStock=true|boolval}