<div id="navbar">
    <div id="header-logo">
        {if $ui_context_edit}
            <span title="eZ Publish {fetch( 'setup', 'version' )}">&nbsp;</span>
        {else}
            <a href="{ezini('SiteSettings', 'DefaultPage', 'site.ini')|ezurl( 'no' )}" title="eZ Publish {fetch( 'setup', 'version' )}">
            </a>
        {/if}
    </div>
    <div id="header-search">
        {include uri='design:page_search.tpl'}
    </div>
    <div class="navbar-icon">&#9776;</div>
    <ul class="navbar-menu">
        {foreach topmenu($ui_context, true() ) as $menu}
            {include uri='design:page_topmenuitem.tpl' menu_item=$menu navigationpart_identifier=$navigation_part.identifier}
        {/foreach}
        <li>
            {if $ui_context_edit}
                <a href='#' title="{'Logout from the system.'|i18n( 'design/admin/pagelayout' )}" id="header-usermenu-logout" class="disabled">{'Logout: '|i18n( 'design/admin/pagelayout' )}</a>
            {else}
                <a href={'/user/logout'|ezurl} title="{'Logout from the system.'|i18n( 'design/admin/pagelayout' )}" id="header-usermenu-logout">{'Logout: '|i18n( 'design/admin/pagelayout' )}</a>
            {/if}
        </li>
    </ul>
</div>

<script type="text/javascript">
    {literal}
    // jQuery( '#header-topmenu ul li' ).click(function(){ jQuery(this).addClass('active'); });
    jQuery( '#navbar ul li a' ).click(function(){ jQuery(this).addClass('active'); });
    $(document).ready(function() {
        $('.navbar-icon').click(function() {
            $('.navbar-menu').slideToggle();
        });
    });
    {/literal}

</script>
 