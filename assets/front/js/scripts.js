jQuery(document).ready(function ($) {

    $(function () {
        $(".sortable").sortable({
            handle: '.move',
            revert: true,
        });

        $('.user_profile_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });



    /* --- */
    /* User Profile Read more click action
    /* --- */

    $(document).on('click', '.list-items .single .post-view-more', function () {

        post_id = $(this).parent().attr('post-id');

        $.ajax({
            type: 'POST',
            context: this,
            url: user_profile_ajax.user_profile_ajaxurl,
            data: {
                "action": "user_profile_ajax_get_post_content",
                "post_id": post_id,
            },
            success: function (response) {

                var data = JSON.parse(response);

                $('#single-' + post_id).find('.excerpt').hide().html( data.html ).fadeIn();
                $('html, body').animate({
                    scrollTop: $('#single-' + post_id).offset().top - 50,
                }, 500);

                $(this).fadeOut();
            }
        });



    })


    /* --- */
    /* User Profile add post reaction
    /* --- */

    $(document).on('click', '.post-reactions .reactions.emos .emo', function () {

        post_id = $(this).parent().attr('post-id');
        reaction = $(this).attr('reaction');

        __HTML__ = $(this).parent().parent().find('.reaction_count').html();
        $(this).parent().parent().find('.reaction_count').html('<i class="icofont icofont-star icofont-spin"></i>');

        $.ajax({
            type: 'POST',
            context: this,
            url: user_profile_ajax.user_profile_ajaxurl,
            data: {
                "action": "user_profile_ajax_add_post_reaction",
                "post_id": post_id,
                "reaction": reaction,
            },
            success: function (response) {

                console.log(response);

                var data = JSON.parse(response);

                if (!data.status) {

                    $(this).parent().parent().find('.reaction_count').html(__HTML__);
                    $(this).parent().parent().find('.reaction_notice').hide().html(data.html).fadeIn();
                    return;
                }

                $('.user-profile .feed-items .single-' + post_id).hide().replaceWith(data.html).fadeIn();

            }
        });
    })



    /* --- */
    /* User Profile Change status from front end
    /* --- */

    $(document).on('change', '.post-status-box', function () {

        post_id = $(this).attr('post_id');
        $(this).parent().find('.icofont').addClass('icofont-spin');

        $.ajax({
            type: 'POST',
            context: this,
            url: user_profile_ajax.user_profile_ajaxurl,
            data: {
                "action": "user_profile_ajax_change_post_status",
                "post_id": post_id,
                "post_status": $(this).val(),
            },
            success: function (response) {

                var data = JSON.parse(response);

                $('.user-profile .feed-items .single-' + post_id).hide().replaceWith(data.html).fadeIn();

                $(this).parent().find('.icofont').removeClass('icofont-spin');

            }
        });
    })



    $(document).on('change', '.user_profile_checkbox', function () {

        if ($(this).is(":checked")) $(this).parent().find('.end_date').prop('disabled', true);
        else $(this).parent().find('.end_date').prop('disabled', false);
    })



    /* --- */
    /* User Profile @user_profile_refresh_feed */
    /* --- */

    $(document).on('click', '.user-profile .user-feed .feed-load-more', function () {

        paged = $(this).data("paged");
        paged = typeof paged === 'undefined' ? 1 : paged;

        postsperpage = $(this).data("postsperpage");
        postsperpage = typeof postsperpage === 'undefined' ? 10 : postsperpage;

        feedforuser = $(this).data("feedforuser");
        feedforuser = typeof feedforuser === 'undefined' ? "" : feedforuser;

        $("#user_profile_loader").fadeIn();

        $.ajax({
            type: 'POST',
            context: this,
            url: user_profile_ajax.user_profile_ajaxurl,
            data: {
                "action": "user_profile_ajax_feed_load_more",
                "paged": paged,
                "postsperpage": postsperpage,
                "feedforuser": feedforuser,
            },
            success: function (response) {

                var data = JSON.parse(response);

                if (!data.status) return;

                var div_to_append = $(this).parent().parent().find('.list-items');

                $('#list-items').append(data.html);
                $(this).data('paged', data.paged);

                scroll_size = $('#list-items').prop("scrollHeight");
                $('html, body').animate({
                    scrollTop: scroll_size
                }, 500);
            }
        });

    })

    $(document).on('user_profile_refresh_feed', function () {

        $.ajax({
            type: 'POST',
            context: this,
            url: user_profile_ajax.user_profile_ajaxurl,
            data: {
                "action": "user_profile_ajax_feed_refresh",
            },
            success: function (response) {

                var data = JSON.parse(response);

                if (!data.status) return;
                $('#list-items').html(data.html);

                $('.user_profile_feed_loader').fadeOut();
            }
        });

    })

    /* --- */
    /* User Profile @click .publish-post */
    /* --- */

    $(document).on('click', '.user-feed .post-panel .publish-post', function () {

        $('.user_profile_feed_loader').fadeIn();
        var form_data = $('.user-feed .feed-new-post').serialize();

        $.ajax({
            type: 'POST',
            context: this,
            url: user_profile_ajax.user_profile_ajaxurl,
            data: {
                "action": "user_profile_ajax_new_feed_post",
                "form_data": form_data,
            },
            success: function (response) {

                console.log( response );
                var data = JSON.parse(response);

                if (data.status) {

                    $('.user-feed .feed-new-post').trigger("reset");
                    $(document.body).trigger('user_profile_refresh_feed');
                    $('.uploaded_photos').html('');
                } else {

                    $('.toast').html(data.message);
                    $('.toast').stop().fadeIn(400).delay(3000).fadeOut(400);
                    $('.user_profile_feed_loader').fadeOut();
                }
            }
        });

    })

    /* --- */
    /* User Profile @click .publish-photo */
    /* --- */

    $(document).on('click', '.publish-photo', function () {

        var target = $(this).data('target');
        var customUploader = wp.media({
            title: $(this).data('title'),
            button: {
                text: $(this).data('buttontext'),
            },
            multiple: true
        });

        customUploader.open();

        customUploader.on('select', function () {

            attachments = customUploader.state().get('selection').toJSON();
            $.each(attachments, function (key, attachment) {

                html = "<div class='single'>";
                html += "<span class='remove'>x</span>";
                html += "<img src='" + attachment.url + "'>";
                html += "<input type='hidden' name='post_image[]' value='" + attachment.id + "' >";
                html += "</div>";

                $(target).append(html);
            });
        });

    })

    $(document).on('keyup', '.user-feed .feed-new-post textarea', function (e) {

        if (e.keyCode != 13 && e.keyCode != 8 && e.keyCode != 46) return;

        var l_count = $(this).val().split("\n").length;
        height = l_count * 18;

        $(this).attr('style', 'height: ' + height + 'px;');
    })

    $(document).on('click', '.uploaded_photos .single .remove', function () {

        $(this).parent().remove();
    })

    $(document).on('change', '.user-profile-edit form', function () {

        //alert(form_id);
        form_id = $(this).attr('id');
        console.log(form_id);

        //alert(form_id);

        //
    })








    $(document).on('click', '.user-profile-edit .remove', function () {

        $(this).parent().remove();

    })


    // is solved 	
    $(document).on('click', '.follow', function () {

        var user_id = $(this).attr('user_id');


        //alert('Hello');

        $.ajax({
            type: 'POST',
            context: this,
            url: user_profile_ajax.user_profile_ajaxurl,
            data: {
                "action": "user_profile_ajax_follow",
                "user_id": user_id,
            },
            success: function (data) {

                var html = JSON.parse(data)

                //$(this).html( html['html'] );

                toast_html = html['toast_html'];
                action = html['action'];

                if (action == 'unfollow') {

                    if ($(this).hasClass('following')) {

                        $(this).removeClass('following');

                    }
                    $(this).text('Follow');
                    $(this).addClass(action);

                } else if (action == 'following') {

                    if ($(this).hasClass('unfollow')) {

                        $(this).removeClass('unfollow');

                    }
                    $(this).html('<i class="icofont icofont-tick-mark"></i> Following');

                    $(this).addClass(action);
                } else {

                }





                console.log(html);

                $('.toast').html(toast_html);
                $('.toast').stop().fadeIn(400).delay(3000).fadeOut(400);

            }
        });
    })



});