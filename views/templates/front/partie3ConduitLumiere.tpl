
<!-- ASSISTANT CONFIGURATEUR -->
<div id="partie-3-1" class="col-md-12" style="display: none">


    <ul class="step stepcdl clearfix" id="order_step">
        <li class="step_current first">
            <span><em>1.</em> Votre projet</span>
        </li>
        <li class="step_todo second">
            <span><em>2.</em> Choix  modèle / nombre</span>
        </li>
        <li class="step_todo third">
            <span><em>3.</em> Choix des options</span>
        </li>
        <li id="step_end" class="step_todo last">
            <span><em>4.</em> Résultat personnalisé</span>
        </li>
    </ul>



    <h3>Découvrez en quelques clics la solution recommandée pour votre projet :</h3>
    <div class="row">
        <div class="col-md-12">

            <p>Ces 6 questions sont nécessaires pour vous proposer votre solution sur-mesure.</p>
            <p>Nature et Confort n'offre que les produits mais l'installation peut facilement être réalisée par un bricoleur grâce à une notice d'installation détaillée,
            par un artisan de votre choix ou par <a href="http://www.natureetconfort.fr/contacts/installateurs-en-france/?location=fr-d22">un artisan du réseau Nature et Confort.</a></p>
            <br />

        </div>
        <div class="col-md-8">

            <h3 class="fleft">1/ Veuillez indiquer le département du projet :</h3>
            <span class="fleft">
                {$titreAide = 'Informations'}
                {$placementAide = 'right'}
                {$contenuAide = "L'ensoleillement diffère selon les départements. C'est pourquoi, afin d'apporter un résultat adapté à votre projet, nous avons besoin de connaitre le département de l'installation."}
                {include file="$tpl_module_dir/bulleAide.tpl"}
            </span>

            <select id="input-departement" name="departement" class="selectDropDown-assistant">
                <option value="">-- Sélectionner --</option>
                <option value="01">01 Ain</option>
                <option value="02">02 Aisne</option>
                <option value="03">03 Allier</option>
                <option value="04">04 Alpes de Haute Provence</option>
                <option value="05">05 Hautes Alpes</option>
                <option value="06">06 Alpes Maritimes</option>
                <option value="07">07 Ardèche</option>
                <option value="08">08 Ardennes</option>
                <option value="09">09 Ariège</option>
                <option value="10">10 Aube</option>
                <option value="11">11 Aude</option>
                <option value="12">12 Aveyron</option>
                <option value="13">13 Bouches du Rhône</option>
                <option value="14">14 Calvados</option>
                <option value="15">15 Cantal</option>
                <option value="16">16 Charente</option>
                <option value="17">17 Charente Maritime</option>
                <option value="18">18 Cher</option>
                <option value="19">19 Corrèze</option>
                <option value="2A">2A Corse du Sud</option>
                <option value="2B">2B Haute-Corse</option>
                <option value="21">21 Côte d'Or</option>
                <option value="22">22 Côtes d'Armor</option>
                <option value="23">23 Creuse</option>
                <option value="24">24 Dordogne</option>
                <option value="25">25 Doubs</option>
                <option value="26">26 Drôme</option>
                <option value="27">27 Eure</option>
                <option value="28">28 Eure et Loir</option>
                <option value="29">29 Finistère</option>
                <option value="30">30 Gard</option>
                <option value="31">31 Haute Garonne</option>
                <option value="32">32 Gers</option>
                <option value="33">33 Gironde</option>
                <option value="34">34 Hérault</option>
                <option value="35">35 Ille et Vilaine</option>
                <option value="36">36 Indre</option>
                <option value="37">37 Indre et Loire</option>
                <option value="38">38 Isère</option>
                <option value="39">39 Jura</option>
                <option value="40">40 Landes</option>
                <option value="41">41 Loir et Cher</option>
                <option value="42">42 Loire</option>
                <option value="43">43 Haute Loire</option>
                <option value="44">44 Loire Atlantique</option>
                <option value="45">45 Loiret</option>
                <option value="46">46 Lot</option>
                <option value="47">47 Lot et Garonne</option>
                <option value="48">48 Lozère</option>
                <option value="49">49 Maine et Loire</option>
                <option value="50">50 Manche</option>
                <option value="51">51 Marne</option>
                <option value="52">52 Haute Marne</option>
                <option value="53">53 Mayenne</option>
                <option value="54">54 Meurthe et Moselle</option>
                <option value="55">55 Meuse</option>
                <option value="56">56 Morbihan</option>
                <option value="57">57 Moselle</option>
                <option value="58">58 Nièvre</option>
                <option value="59">59 Nord</option>
                <option value="60">60 Oise</option>
                <option value="61">61 Orne</option>
                <option value="62">62 Pas de Calais</option>
                <option value="63">63 Puy de Dôme</option>
                <option value="64">64 Pyrénées Atlantiques</option>
                <option value="65">65 Hautes Pyrénées</option>
                <option value="66">66 Pyrénées Orientales</option>
                <option value="67">67 Bas Rhin</option>
                <option value="68">68 Haut Rhin</option>
                <option value="69">69 Rhône</option>
                <option value="70">70 Haute Saône</option>
                <option value="71">71 Saône et Loire</option>
                <option value="72">72 Sarthe</option>
                <option value="73">73 Savoie</option>
                <option value="74">74 Haute Savoie</option>
                <option value="75">75 Paris</option>
                <option value="76">76 Seine Maritime</option>
                <option value="77">77 Seine et Marne</option>
                <option value="78">78 Yvelines</option>
                <option value="79">79 Deux Sèvres</option>
                <option value="80">80 Somme</option>
                <option value="81">81 Tarn</option>
                <option value="82">82 Tarn et Garonne</option>
                <option value="83">83 Var</option>
                <option value="84">84 Vaucluse</option>
                <option value="85">85 Vendée</option>
                <option value="86">86 Vienne</option>
                <option value="87">87 Haute Vienne</option>
                <option value="88">88 Vosges</option>
                <option value="89">89 Yonne</option>
                <option value="90">90 Territoire de Belfort</option>
                <option value="91">91 Essonne</option>
                <option value="92">92 Hauts de Seine</option>
                <option value="93">93 Seine Saint Denis</option>
                <option value="94">94 Val de Marne</option>
                <option value="95">95 Val d'Oise</option>
                <option value="971">971 Guadeloupe</option>
                <option value="972">972 Martinique</option>
                <option value="973">973 Guyane</option>
                <option value="974">974 Réunion</option>
                <option value="975">975 Saint Pierre et Miquelon</option>
                <option value="976">976 Mayotte</option>

            </select>

            <div id="erreur-dpt" style="display: none">
                <p class="alert alert-warning">Veuillez indiquer votre département</p>
            </div>
        </div>
        <div class="col-md-4">
            <br /><br />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p class="col-md-12">Livraison France métropolitaine uniquement</p>
        </div>
    </div>
    <br />

    <div class="row">
        <div class="col-md-8">
            <h3 class="fleft">2/ Puissance lumineuse souhaitée</h3>
            <span class="fleft">
                {$titreAide = 'Choisir votre besoin lumineux'}
                {$placementAide = 'top'}
                {$contenuAide = "Voici quelques exemples de pièce avec un besoin d'éclairage différent : <br /><br /><b>Pièces à vivre et cage d’escalier : </b><br />Salle à manger, lecture, cage d'escalier, dressing, cuisine, chambre, hall d'entrée<br /><br /><b>Pièces de passage et d’eau : </b><br />Salle de bains, WC, couloir, garage, cave"}
                {include file="$tpl_module_dir/bulleAide.tpl"}
            </span>


            <select id="cdl-puissance-lum-souhaitee" name="PuissanceLumSouhaitee" class="selectDropDown-assistant">
                <option value="" data-description="">--</option>
                <option value="Moyen" data-description="">Pièces à vivre et cage d’escalier</option>
                <option value="Faible" data-description="">Pièces de passage et d’eau</option>
            </select>

            <div id="erreur-puissance" style="display: none">
                <p class="alert alert-warning">Veuillez indiquer la puissance lumineuse souhautée</p>
            </div>
        </div>
        <div class="col-sm-4">


        </div>
    </div>
    <br />


    <div class="row">
        <div class="col-md-8">
            <h3 style="float:left">3/ Taille de la surface sombre à éclairer</h3>
            <span class="float:left">
                {$titreAide = 'Informations'}
                {$placementAide = 'right'}
                {$contenuAide = "Les dimensions à entrer sont celles de la surface sombre et non de la pièce totale (voir schéma)"}
                {include file="$tpl_module_dir/bulleAide.tpl"}
            </span>
            <div class="clear">&nbsp;</div>

            <h4>Longueur en mètre de la surface sombre à éclairer</h4>
            <input type="text" id="cdl-longueur" name="cdl-longueur" value="" placeholder="m" class="form-control" />

            <div id="erreur-longueur" style="display: none">
                <p class="alert alert-warning">Veuillez indiquer la longueur de la surface sombre à éclairer</p>
            </div>

            <h4>Largeur en mètre de la surface sombre à éclairer</h4>
            <input type="text" id="cdl-largeur" name="cdl-largeur" value="" placeholder="m" class="form-control" />

            <div id="erreur-largeur" style="display: none">
                <p class="alert alert-warning">Veuillez indiquer la largeur de la surface sombre à éclairer</p>
            </div>


            <h4>Hauteur en mètre maximale sous plafond</h4>
            <input type="text" id="cdl-hauteur-espace-sombre" name="cdl-hauteur-espace-sombre" value="" placeholder="m" class="form-control" />

            <div id="erreur-hauteur" style="display: none">
                <p class="alert alert-warning">Veuillez indiquer la hauteur maximale sous plafond</p>
            </div>
        </div>
        <div class="col-md-4 tcenter">
            <h3>&nbsp;</h3>
            <h4>&nbsp;</h4>
            <a href="{$link->getMediaLink("`$module_dir`views/templates/front/images/cdl/configuration-piece-BIG.jpg")}" class="fancyboxNC">
                <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/cdl/configuration-piece.jpg")}" class="img-responsive img-thumbnail" />
                <br /> Cliquez pour agrandir
            </a>
        </div>
    </div>
    <br />





    <div class="row">
        <div class="col-md-12">
            <h3 class="fleft">4/ Indiquer la longueur totale du parcours du tube en mètre</h3>
             <span class="fleft">
                {$titreAide = 'Informations'}
                 {$placementAide = 'top'}
                 {$contenuAide = "Mesurer la distance  entre votre toit et votre plafond où sera installé le conduit. Celle-ci correspondra à la longueur totale du tube (exemple : traits rouges sur les schémas)"}
                 {include file="$tpl_module_dir/bulleAide.tpl"}
            </span>

            <input type="text" id="cdl-longueur-tube" name="cdl-longueur-tube" value="" placeholder="m" class="form-control" />

            <div id="erreur-longueur-tube" style="display: none">
                <p class="alert alert-warning">Veuillez indiquer la longueur du tube</p>
            </div>
        </div>
    </div>
    <br />


    <div class="row">
        <div class="col-sm-4">
            <a href="{$link->getMediaLink("`$module_dir`views/templates/front/images/cdl/Config1-Tube-Droit-BIG.jpg")}" class="fancyboxNC">
                <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/cdl/Config1-Tube-Droit.jpg")}" class="img-responsive img-thumbnail" />
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{$link->getMediaLink("`$module_dir`views/templates/front/images/cdl/Config2-Etage-BIG.jpg")}" class="fancyboxNC">
                <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/cdl/Config2-Etage.jpg")}" class="img-responsive img-thumbnail" />
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{$link->getMediaLink("`$module_dir`views/templates/front/images/cdl/Config3-Coudes-BIG.jpg")}" class="fancyboxNC">
                <img src="{$link->getMediaLink("`$module_dir`views/templates/front/images/cdl/Config3-Coudes.jpg")}" class="img-responsive img-thumbnail" />
            </a>
        </div>
    </div>
    <br />

    <div class="row">
        <div class="col-md-12">
            <h3>5/ Pente du toit</h3>
            <select id="cdl-pente-toit" name="cdl-pente-toit" class="selectDropDown-assistant">
                <option value="" data-description="">--</option>
                <option value="inf30" data-description="">Inférieure ou égale à 30°</option>
                <option value="sup30" data-description="">Supérieure à 30°</option>
                <option value="plat" data-description="">Plate</option>
            </select>

            <div id="erreur-pente" style="display: none">
                <p class="alert alert-warning">Veuillez indiquer la pente du toit</p>
            </div>
        </div>
    </div>
    <br />

    <div class="row">
        <div class="col-md-12">
            <h3>6/ Type de couverture</h3>
            <select id="cdl-type-couverture" name="cdl-type-couverture" class="selectDropDown-assistant">
                <option value="" data-description="">--</option>
                <option value="canal-mecanique" data-description="">Tuiles canal ou mécaniques</option>
                <option value="ardoise-lauze" data-description="">Ardoises, Lauzes</option>
                <option value="tuiles-plates" data-description="">Tuiles plates sans emboîtement</option>
                <option value="beton" data-description="">Toit terrasse béton</option>
                <option value="autre" data-description="">Autres, nous contacter</option>
            </select>

            <div id="erreur-couverture" style="display: none">
                <p class="alert alert-warning">Veuillez indiquer la couverture du toit</p>
            </div>
        </div>
    </div>
    <br />


    <div class="row bouton-navigation-step">
        <div class="col-xs-4">
            <div id="retour-partie-3-from-assistant" class="btn btn-success btn-lg btn-block"> < Retour</div>
        </div>
        <div class="col-xs-4">&nbsp;</div>
        <div class="col-xs-4">
            <input type="submit" class="btn btn-success btn-lg btn-block" value="Suivant >" id="validate-form-configurateur" />
        </div>
    </div>





    <input type="hidden" id="type-saisie-3" name="type-saisie-3" value="assistant" />

    <div class="marge-bottom-configurateur">&nbsp;</div>

</div>
