/*global jQuery, document, redux*/

(function( $ ) {
    "use strict";

    redux.field_objects = redux.field_objects || {};
    redux.field_objects.ace_editor = redux.field_objects.ace_editor || {};

    $( document ).ready(
        function() {
            //redux.field_objects.ace_editor.init();
        }
    );


    redux.field_objects.ace_editor.init = function( selector ) {
        if ( !selector ) {
            selector = $( document ).find( '.redux-container-ace_editor' );
        }

        $( selector ).each(
            function() {
                var el = $( this );
                var parent = el;
                if ( !el.hasClass( 'redux-field-container' ) ) {
                    parent = el.parents( '.redux-field-container:first' );
                }
                if ( parent.hasClass( 'redux-field-init' ) ) {
                    parent.removeClass( 'redux-field-init' );
                } else {
                    return;
                }
                el.find( '.ace-editor' ).each(
                    function( index, element ) {
                        var area = element;
                        var editor = $( element ).attr( 'data-editor' );

                        var aceeditor = ace.edit( editor );
                        aceeditor.setTheme( "ace/theme/" + jQuery( element ).attr( 'data-theme' ) );
                        aceeditor.getSession().setMode( "ace/mode/" + $( element ).attr( 'data-mode' ) );
                        var parent = '';
                        if ( el.hasClass( 'redux-field-container' ) ) {
                            parent = el.attr( 'data-id' );
                        } else {
                            parent = el.parents( '.redux-field-container:first' ).attr( 'data-id' );
                        }

                        aceeditor.setOptions( redux.ace_editor[parent] );
                        aceeditor.on(
                            'change', function( e ) {
                                $( '#' + area.id ).val( aceeditor.getSession().getValue() );
                                redux_change( $( element ) );
                                aceeditor.resize();
                            }
                        );
                    }
                );
            }
        );
    };
})( jQuery );