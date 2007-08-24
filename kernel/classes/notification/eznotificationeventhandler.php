<?php
//
// Definition of eZNotificationEventHandler class
//
// Created on: <09-May-2003 16:06:26 sp>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ publish
// SOFTWARE RELEASE: 3.10.x
// COPYRIGHT NOTICE: Copyright (C) 1999-2006 eZ systems AS
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

/*! \file eznotificationeventhandler.php
*/

/*!
  \class eZNotificationEventHandler eznotificationeventhandler.php
  \brief The class eZNotificationEventHandler does

*/

define( 'EZ_NOTIFICATIONEVENTHANDLER_EVENT_HANDLED', 0 );
define( 'EZ_NOTIFICATIONEVENTHANDLER_EVENT_SKIPPED', 1 );
define( 'EZ_NOTIFICATIONEVENTHANDLER_EVENT_UNKNOWN', 2 );
define( 'EZ_NOTIFICATIONEVENTHANDLER_EVENT_ERROR', 3 );

include_once( 'kernel/classes/notification/eznotificationtransport.php' );

class eZNotificationEventHandler
{
    /*!
     Constructor
    */
    function eZNotificationEventHandler( $idString, $name )
    {
        $this->IDString = $idString;
        $this->Name = $name;
    }

    function attributes()
    {
        return array( 'id_string',
                      'name' );
    }

    function hasAttribute( $attr )
    {
        return in_array( $attr, $this->attributes() );
    }

    function attribute( $attr )
    {
        if ( $attr == 'id_string' )
        {
            return $this->IDString;
        }
        else if ( $attr == 'name' )
        {
            return $this->Name;
        }

        eZDebug::writeError( "Attribute '$attr' does not exist", 'eZNotificationEventHandler::attribute' );
        return null;
    }

    function handle( $event )
    {
        return true;
    }

    /*!
     Cleanup any specific tables or other resources.
    */
    function cleanup()
    {
    }

    function fetchHttpInput( $http, $module )
    {
        return true;
    }

    function storeSettings( $http, $module )
    {
        return true;
    }

    public $IDString = false;
    public $Name = false;
}

?>
