<div id="partie-2-1" class="col-md-12" style="display: none">
    <div class="row">
        <h3>Choix du modèle :</h3>

        <div class="col-md-4">
            <div id="bouton-reflecteur-exterieur" class="text-center">
                <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/reflecteur/reflecteur-exterieur.jpg")}" class="align-center border-gris img-responsive pointer" />
                <h3 class="text-left">Réflecteur extérieur</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div id="bouton-reflecteur-balcon" class="text-center">
                <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/reflecteur/reflecteur-balcon.jpg")}" class="align-center border-gris img-responsive pointer" />
                <h3 class="text-left">Réflecteur balcon</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div id="bouton-reflecteur-interieur" class="text-center">
                <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/reflecteur/reflecteur-interieur.jpg")}" class="align-center border-gris img-responsive pointer" />
                <h3 class="text-left">Réflecteur intérieur</h3>
            </div>
        </div>



        <div class="col-md-4">
            <div id="partie-2-exterieur" style="display: none">
                <h4>Choix des dimensions :</h4>
                <select id="dimension-reflecteur-exterieur" name="dimension-reflecteur-exterieur" class="selectDropDown-2-exterieur">
                    <option value="" data-description="">--</option>
                    <option value="80*25" data-description="">80cm x 25cm</option>
                    <option value="60*25" data-description="">60cm x 25cm</option>
                    <option value="100*25" data-description="">100cm x 25cm</option>
                    <option value="120*25" data-description="">120cm x 25cm</option>
                </select>

                <div id="erreur-dim-refl-ext" style="display: none">
                    <p class="alert alert-warning">Veuillez indiquer les dimensions du réflecteur extérieur</p>
                </div>

                <h4>Quantité :</h4>
                <input type="text"  id="qte-rfl-ext" name="qte-rfl-ext" value="1" placeholder="Quantité (unité)" class="form-control" />

                <input type="submit" class="btn btn-success btn-lg btn-block" value="Valider >" />
            </div>
        </div>

        <div id="" class="col-md-4">
            <div id="partie-2-balcon" style="display: none">
                <h4>Choix des dimensions :</h4>
                <select id="dimension-reflecteur-balcon" name="dimension-reflecteur-balcon" class="selectDropDown-2-balcon">
                    <option value="" data-description="">--</option>
                    <option value="80*25" data-description="">80cm x 25cm</option>
                    <option value="60*25" data-description="">60cm x 25cm</option>
                </select>

                <div id="erreur-dim-refl-balcon" style="display: none">
                    <p class="alert alert-warning">Veuillez indiquer les dimensions du réflecteur balcon</p>
                </div>

                <h4>Quantité :</h4>
                <input type="text"  id="qte-rfl-balcon" name="qte-rfl-balcon" value="1" placeholder="Quantité (unité)" class="form-control" />

                <input type="submit" class="btn btn-success btn-lg btn-block" value="Valider >" />
            </div>
        </div>


        <div  class="col-md-4">
            <div id="partie-2-interieur" style="display: none">
                <h4>Choix des dimensions :</h4>

                <select id="dimension-reflecteur-interieur" name="dimension-reflecteur-interieur" class="selectDropDown-2-interieur">
                    <option value="" data-description="">--</option>
                    <option value="80*20" data-description="">80cm x 20cm</option>
                    <option value="60*20" data-description="">60cm x 20cm</option>
                </select>
                <div id="erreur-dim-refl-int" style="display: none">
                    <p class="alert alert-warning">Veuillez indiquer les dimensions du réflecteur intérieur</p>
                </div>

                <h4>Quantité :</h4>
                <input type="text"  id="qte-rfl-int" name="qte-rfl-int" value="1" placeholder="Quantité (unité)" class="form-control" />

                <input type="submit" class="btn btn-success btn-lg btn-block" value="Valider >" />
            </div>
        </div>
    </div>





    <div class="row bouton-navigation-step">
        <div class="col-md-4">
            <div id="retour-choix-type-produit-from-2" class="btn btn-success btn-lg btn-block"> < Retour</div>
        </div>
    </div>


    <input type="hidden" id="modele-reflecteur" name="modele-reflecteur" value="" />

    <div class="marge-bottom-configurateur">&nbsp;</div>
</div>


