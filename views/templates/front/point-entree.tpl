{if $page_name == 'index'}

    <div class="clear" style="clear:both;"></div>
    <form id="form-global" method="post" action="" class="descode-configurateur">

        <div id="point-entree" class="row">
            {include file="$tpl_module_dir/partie0Entree.tpl"}
        </div>

        <div id="partie-1" class="row">
            {include file="$tpl_module_dir/partie1Extracteur.tpl"}
        </div>

        <div id="partie-2" class="row">
            {include file="$tpl_module_dir/partie2Reflecteur.tpl"}
        </div>

        <div id="partie-3" class="row">
            {include file="$tpl_module_dir/partie3ConduitLumiere.tpl"}
        </div>

    </form>

    <div class="clear" style="clear:both;"></div>
    <hr />
    <br /><br />
{/if}

