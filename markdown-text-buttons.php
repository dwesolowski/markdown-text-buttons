<?php
/**
 * Plugin Name: Markdown Text Buttons
 * Plugin URI:
 * Description: Adds Markdown buttons to the default text editor
 * Version:     1.0.0
 * Author:      Daren Wesolowski
 * Author URI:
 * License:     GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * Copyright (C) 2018  Daren Wesolowski
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // exit if accessed directly!
}

class MarkdownTextButtons {

    public function __construct() {

        // Disable the default visual editor
        add_filter( 'get_user_option_rich_editing', '__return_false' );

        add_filter( 'quicktags_settings', array( $this,'removeDefaultQuicktags' ) );
        add_action( 'admin_print_footer_scripts', array( $this,'addInlineScript' ) );
    }

    public function removeDefaultQuicktags( $qtInit ) {

        /* Removing default text editor buttons
         * - Must be set to ","
         */
        $qtInit[ 'buttons' ] = ',';
        return $qtInit;
    }

    public function addInlineScript() {
    ?>
        <script language="javascript" type="text/javascript">
            jQuery( document ).ready( function( $ ) {

                /* Removing fields from the user's profile page
                 * - Remove the Visual Editor field
                 * - Remove the Syntax Highlighting field
                 */
                $( 'form#your-profile tr.user-rich-editing-wrap' ).remove();
                $( 'form#your-profile tr.user-syntax-highlighting-wrap' ).remove();
            });

            /* Adding Markdown Quicktag buttons to the editor WordPress ver. 3.3 and above
             * - Button HTML ID (required)
             * - Button display, value="" attribute (required)
             * - Opening Tag (required)
             * - Closing Tag (required)
             * - Access key, accesskey="" attribute for the button (optional)
             * - Title, title="" attribute (optional)
             * - Priority/position on bar, 1-9 = first, 11-19 = second, 21-29 = third, etc. (optional)
             */
            QTags.addButton( 'md-heading-1', 'H1', '# ' );
            QTags.addButton( 'md-heading-2', 'H2', '## ' );
            QTags.addButton( 'md-heading-3', 'H3', '### ' );
            QTags.addButton( 'md-bold', 'b', '**', '**' );
            QTags.addButton( 'md-italic', 'i', '*', '*' );
            QTags.addButton( 'md-strikethrough', 's', '~~', '~~' );
            QTags.addButton( 'md-blockquote', 'q', '> ' );
            QTags.addButton( 'md-ordered-list', 'ul', '1. ' );
            QTags.addButton( 'md-unordered-list', 'li', '- ' );
            QTags.addButton( 'md-horizontal-rule', 'hr', '---' );
            QTags.addButton( 'md-link', 'link', '[title](https://www.example.com)' );
            QTags.addButton( 'md-image', 'image', '![alt text](image.jpg)' );
            QTags.addButton( 'md-code-inline', 'code inline', '`', '`' );
            QTags.addButton( 'md-code-block', 'code block', '```language\n', '```' );
        </script>
    <?php
    }
}

$markdown_text_buttons = new MarkdownTextButtons();
