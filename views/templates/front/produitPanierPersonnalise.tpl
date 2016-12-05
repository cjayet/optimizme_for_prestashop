<div class="apercu-produit row" rel="{$product->id}" data-reference="{$product->reference}">
    <div class="image col-md-3">
        <div class="text-center">
            <img src="{$product->imgCover}" class="img-responsive border-gris img-produit" alt="cover" />
        </div>
    </div>
    <div class="col-md-9">
        <h4>{$product->name[1]|escape:'html':'UTF-8'}</h4>
        <p></p>
        <div class="prix">
            {convertPrice price=$product->getPrice(true, $smarty.const.NULL)} TTC
        </div>
        {hook h="displayProductPriceBlock" product=$product type="price"}
        <span id="pretaxe_price"><span id="pretaxe_price_display"></span></span>

        <div class="ligne-quantite">
            <div class="bouton-quantite">

                {if $flagPossibiliteModifierQuantite == '1'}
                    <div class="minus">
                        <a class="btn btn-default button-minus product_quantity_down_descode nc-refresh-price" data-field-qty="addpanier_produit_{$product->id}" href="#">
                            -
                        </a>
                    </div>
                {/if}

                <div class="quantite">
                    <input type="text" name="addpanier_produit_{$product->id}" value="{$product->quantite}" placeholder="Qté" class="quantite-produit-unite" {if $flagPossibiliteModifierQuantite ==0} disabled="disabled" {/if} />
                </div>

                {if $flagPossibiliteModifierQuantite == '1'}
                    <div class="plus">
                        <a class="btn btn-default button-plus product_quantity_up nc-refresh-price" data-field-qty="addpanier_produit_{$product->id}" href="#">
                            +
                        </a>
                    </div>
                {/if}
            </div>

            <div class="proportionnalite-prix">
                x
                <span class="prix-produit-unite" rel="{$product->getPrice(true)}">
                    {convertPrice price=$product->getPrice(true, $smarty.const.NULL)}
                </span>
                    =
                <span class="vert prix-produit-ligne">
                    {$product->prixSelonQuantite}€
                </span>
            </div>

        </div>

        <!-- <a href="{$product->lienPageProduit|escape:'html':'UTF-8'}" class="btn btn-warning btn-lg">Afficher le détail</a> -->

        {if isset($product->description[1]) & !empty($product->description[1])}
        <div class="btn-detail-produit btn btn-warning btn-lg">Afficher le détail</div>
        <div class="detail-produit" style="display: none">
            <p>{$product->description[1]}</p>
        </div>
        {/if}

    </div>
</div>