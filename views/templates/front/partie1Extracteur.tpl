<div id="partie-1-1" class="col-md-12" style="display: none">
    <div class="row">

        <h3>Choix de la puissance d'extraction : </h3>

        <div class="col-md-6">
            <div id="bouton-rm1600">
                <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/extracteur/rm1600-22w.jpg")}" class="align-center border-gris img-responsive pointer" />
                <h3 class="text-left fleft">RM 1600 - 22 W</h3>

            <span class="fleft">
                {$titreAide = 'Informations'}
                {$placementAide = 'right'}
                {$contenuAide = "Pour aérer un grenier d'une surface > 100 m², installez le modèle RM 1600 équipé d'un panneau solaire de 22W"}
                {include file="$tpl_module_dir/bulleAide.tpl"}
            </span>


            </div>
            <input type="hidden" id="rm160022w" name="rm160022w" value="0" />
        </div>

        <div class="col-md-6">
            <div id="bouton-rm1200">
                <img  src="{$link->getMediaLink("`$module_dir`views/templates/front/images/extracteur/rm1200-10w.jpg")}" class="align-center border-gris img-responsive pointer" />
                <h3 class="text-left fleft">RM 1200 - 10 W</h3>

            <span class="fleft">
                {$titreAide = 'Informations'}
                {$placementAide = 'right'}
                {$contenuAide = "Pour aérer un grenier d'une surface inférieure à 100m², optez pour le modèle Solar Star RM 1200 équipé d'un panneau solaire de 10W"}
                {include file="$tpl_module_dir/bulleAide.tpl"}
            </span>


            </div>
            <input type="hidden" id="rm120010w" name="rm120010w" value="0" />
        </div>
    </div>


    <div class="row bouton-navigation-step">
        <div class="col-md-4">
            <div id="retour-choix-type-produit-from-1" class="btn btn-success btn-lg btn-block"> < Retour</div>
        </div>
    </div>

    <div class="marge-bottom-configurateur">&nbsp;</div>
</div>



<div id="partie-1-2" class="col-md-12" style="display: none">

    <div class="row">
        <h3>Configuration / Caractéristiques du toit :</h3>

        <h4>Pente du toit</h4>
        <select id="extracteur-pente-toit" name="extracteur-pente-toit" class="selectDropDown-1-2">
            <option value="" data-description="">--</option>
            <option value="inf30" data-description="">Inférieure ou égale à 30°</option>
            <option value="sup30" data-description="">Supérieure à 30°</option>
            <option value="plat" data-description="">Plate</option>
        </select>
        <div id="erreur-extr-pente" style="display: none">
            <p class="alert alert-warning">Veuillez indiquer la pente de votre toit</p>
        </div>


        <h4>Type de couverture</h4>
        <select id="type-couverture" name="type-couverture" class="selectDropDown-1-2">
            <option value="" data-description="">--</option>
            <option value="canal-mecanique" data-description="">Tuiles canal ou mécaniques</option>
            <option value="ardoise-lauze" data-description="">Ardoises, Lauzes</option>
            <option value="tuiles-plates" data-description="">Tuiles plates sans emboîtement</option>
            <option value="beton" data-description="">Toit terrasse béton</option>
            <option value="autre" data-description="">Autres, nous contacter</option>
        </select>
        <div id="erreur-extr-couverture" style="display: none">
            <p class="alert alert-warning">Veuillez indiquer votre type de couverture</p>
        </div>



        <div class="col-md-12">
            <h4 class="fleft">Switch thermique</h4>
            <span class="fleft">
                {$titreAide = 'Informations'}
                {$placementAide = 'right'}
                {$contenuAide = "Le switch thermique est un interrupteur qui permet au Solar Star de se mettre en fonctionnement lorsque la température des combles atteint 29° et de se couper lorsque la température est inférieure à 18°."}
                {include file="$tpl_module_dir/bulleAide.tpl"}
            </span>

            <div class="clear"></div>

            <div class="containerRadio">
                <input type="radio" name="switch-thermique" value="1" class="" checked="checked" /> Oui
                <input type="radio" name="switch-thermique" value="0" class="" /> Non
            </div>

        </div>
    </div>


    <div class="row bouton-navigation-step">
        <div class="col-md-4">
            <div id="retour-choix-modele-1" class="btn btn-success btn-lg btn-block"> < Retour</div>
        </div>
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-4">
            <input type="submit" class="btn btn-success btn-lg btn-block" value="Valider >" />
        </div>

    </div>





    <div class="marge-bottom-configurateur">&nbsp;</div>
</div>

