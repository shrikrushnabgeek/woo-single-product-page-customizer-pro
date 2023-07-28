jQuery(document).ready(function () {

    var ajax_add_nonce = jQuery(".wsppcp_ajax_add_nonce").val();
    var ajax_edit_nonce = jQuery(".wsppcp_ajax_edit_nonce").val();
    var ajax_remove_nonce = jQuery(".wsppcp_ajax_remove_nonce").val();


    /**
     * Returns the configuration object for Select2 AJAX handler.
     * @param {string} action - The AJAX action.
     * @returns {object} The Select2 AJAX configuration object.
     */
    function select2AjaxHandler(action) {
        return {
            ajax: {
                type: 'POST',
                url: custom_call.ajaxurl,
                dataType: 'json',
                delay: 250,
                data: (params) => {
                    return {
                        'action': action,
                        'search': params.term,
                        'security': ajax_add_nonce
                    };
                },
                processResults: (data, params) => {
                    const results = data.map(item => {
                        return {
                            id: item.id,
                            text: item.title,
                        };
                    });
                    return {
                        results: results,
                    };
                },
            },
            minimumInputLength: 3,
        };
    }

    if (jQuery('.wsppcp_tab').children().length == 0) {
        jQuery(".wsppcp_tab").addClass("empty");
    }

    jQuery(".wsppcp-position-map-accordion").on("click", function () {
        if (jQuery(this).hasClass('wsppcp-active-map-img')) {
            jQuery(this).removeClass('wsppcp-active-map-img');
            jQuery(".wsppcp-woo-single-page-position-map-img").fadeOut();
        } else {
            jQuery(this).addClass('wsppcp-active-map-img');
            jQuery(".wsppcp-woo-single-page-position-map-img").fadeIn();

        }
    });

    jQuery('.wsppcp_add_global_position').click(function () {
        var $curr = jQuery(this);

        $curr.next().css("display", "inline");

        var main_li = jQuery(this).parent().parent();
        jQuery.ajax({
            url: custom_call.ajaxurl,
            type: 'post',
            data: {
                action: 'wsppcp_get_edit_form',
                form_action: 'add_form',
                security: ajax_add_nonce,

            },
            success: function (response) {
                jQuery(".wsppcp_add_hook_form").html(response);

                wp.editor.initialize("content_", {
                    mediaButtons: true,
                    tinymce: {

                        theme: 'modern',
                        skin: 'lightgray',
                        language: 'en',
                        formats: {
                            alignleft: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'left' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'alignleft' }
                            ],
                            aligncenter: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'center' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'aligncenter' }
                            ],
                            alignright: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'right' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'alignright' }
                            ],
                            strikethrough: { inline: 'del' }
                        },
                        relative_urls: false,
                        remove_script_host: false,
                        convert_urls: false,

                        entities: '38, amp, 60, lt, 62, gt ',
                        entity_encoding: 'raw',
                        keep_styles: false,
                        paste_webkit_styles: 'font-weight font-style color',
                        preview_styles: 'font-family font-size font-weight font-style text-decoration text-transform',
                        tabfocus_elements: ': prev ,: next',
                        plugins: 'charmap, hr, media, paste, tabfocus, textcolor, fullscreen, wordpress, wpeditimage, wpgallery, wplink, wpdialogs, wpview',
                        resize: 'vertical',
                        menubar: false,
                        indent: false,
                        toolbar1: 'bold, italic, strikethrough, bullist, numlist, blockquote, hr, alignleft, aligncenter, alignright, link, unlink, wp_more, spellchecker, fullscreen, wp_adv',
                        toolbar2: 'formatselect, underline, alignjustify, forecolor, pastetext, removeformat, charmap, outdent, indent, undo, redo, wp_help',
                        toolbar3: '',
                        toolbar4: '',
                        body_class: 'id post-type-post-status-publish post-format-standard',
                        wpeditimage_disable_captions: false,
                        wpeditimage_html5_captions: true

                    },
                    quicktags: true
                });
                jQuery(".wsppcp_add_global_position").hide();
                $curr.next().css("display", "none");


                // Initialize Select2 for "#wsppcp_exclude_post" element
                jQuery(".wsppcp_add_hook_form").find('#wsppcp_exclude_post').select2(
                    select2AjaxHandler('wsppcp_exclude_post')
                );

                // Initialize Select2 for "#wsppcp_exclude_category" element
                jQuery(".wsppcp_add_hook_form").find('#wsppcp_exclude_category').select2(
                    select2AjaxHandler('wsppcp_exclude_category')
                );
            }
        });

        if (jQuery('.wsppcp_tab').children().length == 0) {
            jQuery(".wsppcp_tab").addClass("empty");
        }
    });

    jQuery('.wsppcp_add_single_product_position').click(function () {
        var $curr = jQuery(this);
        var product_id = jQuery(this).attr('data-product-id');
        var current_page = jQuery(this).attr('data-page');

        $curr.next().css("display", "inline");

        var main_li = jQuery(this).parent().parent();
        jQuery.ajax({
            url: custom_call.ajaxurl,
            type: 'post',
            data: {
                action: 'wsppcp_single_product_add_form',
                form_action: 'add_form',
                security: ajax_add_nonce,
                product_id: product_id,
                current_page: current_page

            },
            success: function (response) {
                jQuery(".wsppcp_add_hook_form").html(response);
                wp.editor.initialize("content_", {
                    mediaButtons: true,
                    tinymce: {

                        theme: 'modern',
                        skin: 'lightgray',
                        language: 'en',
                        formats: {
                            alignleft: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'left' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'alignleft' }
                            ],
                            aligncenter: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'center' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'aligncenter' }
                            ],
                            alignright: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'right' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'alignright' }
                            ],
                            strikethrough: { inline: 'del' }
                        },
                        relative_urls: false,
                        remove_script_host: false,
                        convert_urls: false,

                        entities: '38, amp, 60, lt, 62, gt ',
                        entity_encoding: 'raw',
                        keep_styles: false,
                        paste_webkit_styles: 'font-weight font-style color',
                        preview_styles: 'font-family font-size font-weight font-style text-decoration text-transform',
                        tabfocus_elements: ': prev ,: next',
                        plugins: 'charmap, hr, media, paste, tabfocus, textcolor, fullscreen, wordpress, wpeditimage, wpgallery, wplink, wpdialogs, wpview',
                        resize: 'vertical',
                        menubar: false,
                        indent: false,
                        toolbar1: 'bold, italic, strikethrough, bullist, numlist, blockquote, hr, alignleft, aligncenter, alignright, link, unlink, wp_more, spellchecker, fullscreen, wp_adv',
                        toolbar2: 'formatselect, underline, alignjustify, forecolor, pastetext, removeformat, charmap, outdent, indent, undo, redo, wp_help',
                        toolbar3: '',
                        toolbar4: '',
                        body_class: 'id post-type-post-status-publish post-format-standard',
                        wpeditimage_disable_captions: false,
                        wpeditimage_html5_captions: true

                    },
                    quicktags: true
                });
                jQuery(".wsppcp_add_single_product_position").hide();
                $curr.next().css("display", "none");
            }
        });

        if (jQuery('.wsppcp_tab').children().length == 0) {
            jQuery(".wsppcp_tab").addClass("empty");
        }
    });

    jQuery('.wsppcp_edit_global_hook').click(function () {
        var main_li = jQuery(this).parent().parent();
        var hook_name = jQuery(this).attr('data-hook');
        jQuery(this).hide();
        var $curr = jQuery(this);
        $curr.siblings('.wsppcp_ajax_loader').css("display", "inline");
        jQuery.ajax({
            url: custom_call.ajaxurl,
            type: 'post',
            data: {
                action: 'wsppcp_get_edit_form',
                form_action: 'edit_form',
                security: ajax_edit_nonce,
                hook_name: hook_name
            },

            success: function (response) {

                tinymce.remove(".wsppcp_toggle .wsppcp_content");
                main_li.find(".wsppcphook_details").html(response);
                jQuery('.wsppcphook_details').hide();
                main_li.find(".wsppcphook_details").show();

                main_li.siblings().find('.wsppcp_edit_global_hook').show();

                wp.editor.initialize("content_" + hook_name, {
                    mediaButtons: true,
                    tinymce: {

                        theme: 'modern',
                        skin: 'lightgray',
                        language: 'en',
                        formats: {
                            alignleft: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'left' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'alignleft' }
                            ],
                            aligncenter: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'center' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'aligncenter' }
                            ],
                            alignright: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'right' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'alignright' }
                            ],
                            strikethrough: { inline: 'del' }
                        },
                        relative_urls: false,
                        remove_script_host: false,
                        convert_urls: false,

                        entities: '38, amp, 60, lt, 62, gt ',
                        entity_encoding: 'raw',
                        keep_styles: false,
                        paste_webkit_styles: 'font-weight font-style color',
                        preview_styles: 'font-family font-size font-weight font-style text-decoration text-transform',
                        tabfocus_elements: ': prev ,: next',
                        plugins: 'charmap, hr, media, paste, tabfocus, textcolor, fullscreen, wordpress, wpeditimage, wpgallery, wplink, wpdialogs, wpview',
                        resize: 'vertical',
                        menubar: false,
                        indent: false,
                        toolbar1: 'bold, italic, strikethrough, bullist, numlist, blockquote, hr, alignleft, aligncenter, alignright, link, unlink, wp_more, spellchecker, fullscreen, wp_adv',
                        toolbar2: 'formatselect, underline, alignjustify, forecolor, pastetext, removeformat, charmap, outdent, indent, undo, redo, wp_help',
                        toolbar3: '',
                        toolbar4: '',
                        body_class: 'id post-type-post-status-publish post-format-standard',
                        wpeditimage_disable_captions: false,
                        wpeditimage_html5_captions: true

                    },
                    quicktags: true
                });
                $curr.prev().css("display", "none");
                $curr.closest(".edit_ajax_loader").css("display", "none");
                jQuery(".edit_ajax_loader").closest(".edit_ajax_loader").addClass("demo_class");

                // Initialize Select2 for "#wsppcp_exclude_post" element
                jQuery(".wsppcphook_details").find('#wsppcp_exclude_post').select2(
                    select2AjaxHandler('wsppcp_exclude_post')
                );

                // Initialize Select2 for "#wsppcp_exclude_category" element
                jQuery(".wsppcphook_details").find('#wsppcp_exclude_category').select2(
                    select2AjaxHandler('wsppcp_exclude_category')
                );
            }
        });
    });

    jQuery('.wsppcp_edit_single_product_hook').click(function () {
        var main_li = jQuery(this).parent().parent();
        var hook_name = jQuery(this).attr('data-hook');
        var product_id = jQuery(this).attr('data-product-id');
        var current_page = jQuery(this).attr('data-page');
        jQuery(this).hide();

        var $curr = jQuery(this);
        $curr.siblings('.wsppcp_ajax_loader').css("display", "inline");

        jQuery.ajax({
            url: custom_call.ajaxurl,
            type: 'post',
            data: {
                action: 'wsppcp_single_product_add_form',
                form_action: 'edit_form',
                security: ajax_edit_nonce,
                hook_name: hook_name,
                product_id: product_id,
                current_page: current_page
            },
            success: function (response) {


                tinymce.remove(".wsppcp_toggle .wsppcp_content");
                main_li.find(".wsppcphook_details").html(response);
                jQuery('.wsppcphook_details').hide();
                main_li.find(".wsppcphook_details").show();

                main_li.siblings().find('.wsppcp_edit_single_product_hook').show();

                wp.editor.initialize("content_" + hook_name, {
                    mediaButtons: true,
                    tinymce: {

                        theme: 'modern',
                        skin: 'lightgray',
                        language: 'en',
                        formats: {
                            alignleft: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'left' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'alignleft' }
                            ],
                            aligncenter: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'center' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'aligncenter' }
                            ],
                            alignright: [
                                { selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li', styles: { textAlign: 'right' } },
                                { selector: 'img, table, dl.wp-caption', classes: 'alignright' }
                            ],
                            strikethrough: { inline: 'del' }
                        },
                        relative_urls: false,
                        remove_script_host: false,
                        convert_urls: false,

                        entities: '38, amp, 60, lt, 62, gt ',
                        entity_encoding: 'raw',
                        keep_styles: false,
                        paste_webkit_styles: 'font-weight font-style color',
                        preview_styles: 'font-family font-size font-weight font-style text-decoration text-transform',
                        tabfocus_elements: ': prev ,: next',
                        plugins: 'charmap, hr, media, paste, tabfocus, textcolor, fullscreen, wordpress, wpeditimage, wpgallery, wplink, wpdialogs, wpview',
                        resize: 'vertical',
                        menubar: false,
                        indent: false,
                        toolbar1: 'bold, italic, strikethrough, bullist, numlist, blockquote, hr, alignleft, aligncenter, alignright, link, unlink, wp_more, spellchecker, fullscreen, wp_adv',
                        toolbar2: 'formatselect, underline, alignjustify, forecolor, pastetext, removeformat, charmap, outdent, indent, undo, redo, wp_help',
                        toolbar3: '',
                        toolbar4: '',
                        body_class: 'id post-type-post-status-publish post-format-standard',
                        wpeditimage_disable_captions: false,
                        wpeditimage_html5_captions: true

                    },
                    quicktags: true
                });
                $curr.prev().css("display", "none");
                $curr.closest(".edit_ajax_loader").css("display", "none");
                jQuery(".edit_ajax_loader").closest(".edit_ajax_loader").addClass("demo_class");
            }
        });
    });

    jQuery('.wsppcp_remove_global_hook').click(function () {
        if (!confirm('Are you sure remove this hook?')) {
            return false;
        }
        var $curr = jQuery(this);
        $curr.siblings('.wsppcp_ajax_loader').css("display", "inline");

        var hook_name = jQuery(this).attr('data-hook');
        var main_li = jQuery(this).parent().parent();
        jQuery.ajax({
            url: custom_call.ajaxurl,
            type: 'post',
            data: {
                action: 'wsppcp_remove_global_hook',
                hook_name: hook_name,
                security: ajax_remove_nonce

            },
            success: function (response) {
                if (response == true) {
                    main_li.remove();
                }

                if (jQuery('.wsppcp_hooks_list li').length == 0) {
                    jQuery('#wsppcp_clear_all').hide();
                }
                $curr.prev().css("display", "none");

                // jQuery(".wsppcp_add_hook_form").html(response);				 
            }
        });

    });

    jQuery('.wsppcp_remove_single_product_hook').click(function () {
        if (!confirm('Are you sure remove this hook?')) return false;

        var $curr = jQuery(this);
        var product_id = jQuery(this).attr('data-product-id');
        var hook_name = jQuery(this).attr('data-hook');
        var main_li = jQuery(this).parent().parent();
        var current_page = jQuery(this).attr('data-page');
        $curr.siblings('.wsppcp_ajax_loader').css("display", "inline");

        jQuery.ajax({
            url: custom_call.ajaxurl,
            type: 'post',
            data: {
                action: 'wsppcp_remove_single_product_hook',
                hook_name: hook_name,
                security: ajax_remove_nonce,
                product_id: product_id,
                current_page: current_page
            },
            success: function (response) {
                if (response == true) {
                    main_li.remove();
                }
                if (jQuery('.wsppcp_hooks_list li').length == 0) {
                    jQuery('#wsppcp_clear_all').hide();
                }

                $curr.closest("li").css("display", "none");
            }
        });

    });

    /** Admin Panel Clear All Form START */
    jQuery('#wsppcp_clear_all').click(function () {
        if (!confirm('Are You Sure You Want to Remove All?')) return false;
        if (jQuery('.wsppcp_hooks_list li').length == 0) return false

        var $curr = jQuery(this);
        $curr.prev().css("display", "inline");

        var product_id = current_page = null;
        product_id = jQuery(this).attr('data-product-id');
        current_page = jQuery(this).attr('data-page');

        var data = {
            action: 'wsppcp_clear_all',
            security: ajax_remove_nonce
        }

        if (product_id !== null) data.product_id = product_id;
        if (current_page !== null) data.current_page = current_page;

        jQuery.ajax({
            url: custom_call.ajaxurl,
            type: 'post',
            data: data,
            success: function (response) {
                if (response == true) {
                    $curr.prev().css("display", "none");
                    jQuery('.wsppcp_hooks_list li').remove();
                    $curr.hide();
                }
            }
        });
    });
    /** Admin Panel Clear All Form END */


    /** Remove Content Tab JS Strat */
    jQuery("#wsppcp_single_page").click(function () {
        jQuery("input:checkbox[name='wsppcp_single_checkbox[]']").not(this).prop('checked', this.checked);
    });
    /** Remove Content Tab JS End */

});

