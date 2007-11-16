<?php
//
// Created on: <14-Nov-2007 11:27:10 dl>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ publish
// SOFTWARE RELEASE: 4.0.x
// COPYRIGHT NOTICE: Copyright (C) 1999-2007 eZ systems AS
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
//   This program is free software; you can redistribute it and/or
//   modify it under the terms of version 2.0  of the GNU General
//   Public License as published by the Free Software Foundation.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU General Public License for more details.
//
//   You should have received a copy of version 2.0 of the GNU General
//   Public License along with this program; if not, write to the Free
//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
//   MA 02110-1301, USA.
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

/*! \file urlalias_wildcard.php
*/
include_once( 'kernel/common/template.php' );
include_once( 'kernel/classes/ezurlwildcard.php' );

$Module =& $Params['Module'];
$http = eZHTTPTool::instance();

$Offset = $Params['Offset'];
if ( $Module->hasActionParameter( 'Offset' ) )
{
    $Offset = $Module->actionParameter( 'Offset' );
}

$tpl = templateInit();
$limit = 20;

$infoCode = 'no-errors'; // This will be modified if info/warning is given to user.
$infoData = array(); // Extra parameters can be added to this array
$wildcardSrcText = false;
$wildcardDstText = false;
$wildcardType = false;

if ( $Module->isCurrentAction( 'RemoveAllWildcards' ) )
{
    eZURLWildcard::removeAll();

    eZURLWildcard::expireCache();

    $infoCode = "feedback-wildcard-removed-all";
}
else if ( $Module->isCurrentAction( 'RemoveWildcard' ) )
{
    if ( $http->hasPostVariable( 'WildcardIDList' ) )
    {
        $wildcardIDs = $http->postVariable( 'WildcardIDList' );

        eZURLWildcard::removeByIDs( $wildcardIDs );

        eZURLWildcard::expireCache();

        $infoCode = "feedback-wildcard-removed";
    }
}
else if ( $Module->isCurrentAction( 'NewWildcard' ) )
{
    $wildcardSrcText = trim( $Module->actionParameter( 'WildcardSourceText' ) );
    $wildcardDstText = trim( $Module->actionParameter( 'WildcardDestinationText' ) );
    $wildcardType = $http->hasPostVariable( 'WildcardType' ) && strlen( trim( $http->postVariable( 'WildcardType' ) ) ) > 0;

    if ( strlen( $wildcardSrcText ) == 0 )
    {
        $infoCode = "error-no-wildcard-text";
    }
    else if ( strlen( $wildcardDstText ) == 0 )
    {
        $infoCode = "error-no-wildcard-destination-text";
    }
    else
    {
        $wildcard = eZURLWildcard::fetchBySourceURL( $wildcardSrcText, false );
        if ( $wildcard )
        {
            $infoCode = "feedback-wildcard-exists";

            $infoData['wildcard_src_url'] = $wildcardSrcText;
            $infoData['wildcard_dst_url'] = $wildcardDstText;
        }
        else
        {
            $row = array(
                'source_url' => $wildcardSrcText,
                'destination_url' => $wildcardDstText,
                'type' => $wildcardType ? eZURLWildcard::EZ_URLWILDCARD_TYPE_FORWARD : eZURLWildcard::EZ_URLWILDCARD_TYPE_DIRECT );

            $wildcard = new eZURLWildcard( $row );
            $wildcard->store();

            eZURLWildcard::expireCache();

            $infoData['wildcard_src_url'] = $wildcardSrcText;
            $infoData['wildcard_dst_url'] = $wildcardDstText;

            $wildcardSrcText = false;
            $wildcardDstText = false;
            $wildcardType = false;

            $infoCode = "feedback-wildcard-created";
        }
    }
}

// User preferences
$limitList = array( array( 'id'    => 1,
                           'value' => 10 ),
                    array( 'id'    => 2,
                           'value' => 25 ),
                    array( 'id'    => 3,
                           'value' => 50 ),
                    array( 'id'    => 4,
                           'value' => 100 ) );
include_once( 'kernel/classes/ezpreferences.php' );
$limitID = eZPreferences::value( 'admin_urlwildcard_list_limit' );
foreach ( $limitList as $limitEntry )
{
    $limitIDs[]                     = $limitEntry['id'];
    $limitValues[$limitEntry['id']] = $limitEntry['value'];
}
if ( !in_array( $limitID, $limitIDs ) )
{
    $limitID = 2;
}

// Fetch wildcads
$wildcardsLimit = $limitValues[$limitID];
$wildcardsCount = eZURLWildcard::fetchListCount();
// check offset, it can be out of range if some wildcards were removed.
if ( $Offset >= $wildcardsCount )
{
    $Offset = 0;
}
$wildcardList = eZURLWildcard::fetchList( $Offset, $wildcardsLimit );

$viewParameters = array( 'offset' => $Offset );


$path = array();
$path[] = array( 'url'  => false,
                 'text' => ezi18n( 'kernel/content/urlalias_wildcard', 'URL wildcard aliases' ) );

$tpl->setVariable( 'wildcard_list', $wildcardList );
$tpl->setVariable( 'wildcards_limit', $wildcardsLimit );
$tpl->setVariable( 'wildcards_count', $wildcardsCount );
$tpl->setVariable( 'info_code', $infoCode );
$tpl->setVariable( 'info_data', $infoData );
$tpl->setVariable( 'wildcardSourceText', $wildcardSrcText );
$tpl->setVariable( 'wildcardDestinationText', $wildcardDstText );
$tpl->setVariable( 'wildcardType', $wildcardType );
$tpl->setVariable( 'limitList', $limitList );
$tpl->setVariable( 'limitID', $limitID );
$tpl->setVariable( 'view_parameters', $viewParameters );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:content/urlalias_wildcard.tpl' );
$Result['path'] = $path;

?>
