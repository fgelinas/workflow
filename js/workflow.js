/*
 * workflow.js
 * The script that power the worjflow page
 * Francois Gelinas - January 2012
 */


// the jquery element of the card being edited
var $edited_card = null;

$(document).ready(function() {

    $('ul.column').sortable({
        connectWith: 'ul.column',
        start: drag_start,
        stop: drag_stop,
        update: save_reorder,
        helper: 'clone',
        opacity: 0.7
    });



    $('#add_card_button').button({
        icons: { primary: "ui-icon-plus" }
    }).bind('click', card_add_to_first_column);

    $('#trash').droppable({
        accept: 'li.card',
        drop: card_remove
    });

    $('div.column .add_card_button').click(card_add);

    attach_card_events();
});

function drag_start()
{
    $('#trash').show();
}

function drag_stop()
{
    $('#trash').hide();
}

function attach_card_events()
{
    $('li.card')
        .unbind()
        .disableSelection()
        .click(card_clicked)
    ;
}

function save_reorder()
{
    var card_ids = {  };
    $('ul.column').each(function (i, e) {
        var column_id = $(e).data('id');
        $(e).find('li.card').each(function( i, e) {
            card_ids [ $(e).data('id') ] = {
                'order': i,
                'column_id': column_id
            };
        });
    });

    var data = {
        'card_ids': card_ids
    }

    $.ajax({
        url: '?action=save_reorder',
        data: data,
        type: 'POST',
        dataType: 'json'
    })
}

function card_clicked()
{
    $card = $(this);
    card_edit ($card);
}

function card_edit($card)
{
    var $edit_container = $card.find('.edit_container');
    var $edit_box = $card.find('.edit_box');



    if ($edited_card != null) {
        if ($edited_card.data('id') == $card.data('id') ) {
            return false;
        }
        card_edit_done();
        return false; // already editing
    }

    $edited_card = $card;

    $card.find('.card_content').hide();
    $edit_box.data('original_value', $edit_box.val() );
    $edit_container.show();
    $edit_box.focus()
        .unbind()
        .bind('blur', card_edit_done)
        .bind('keydown' , card_edit_keydown)
        .bind('keyup' , card_edit_adjust_height);

    card_edit_adjust_height(); // must be after show;
}

function card_edit_keydown(e)
{
    switch (e.which) {
        case 27:
            card_edit_undo();
            return false;

        case 13:
            if (e.ctrlKey) {
                var $edit_box = $edited_card.find('.edit_box');

                var sel_start = $edit_box[0].selectionStart;
                $edit_box.val(
                    $edit_box.val().substring(0, sel_start)
                        + "\n"
                        + $edit_box.val().substring( $edit_box[0].selectionEnd, $edit_box.val().length )
                );
                $edit_box[0].selectionStart = sel_start + 1;
                $edit_box[0].selectionEnd = sel_start + 1;
                return false;
            }

            card_edit_done();
            return false;
    }

}

function card_edit_done()
{
    var $card = $edited_card;
    var $edit_box = $card.find('.edit_box:first');
    $edit_box.unbind(); // remove events to prevent another call to edit_done

    var data = {
        'id': $card.data('id'),
        'content': $edit_box.val()
    };
    $.ajax({
        url: '?action=update_card',
        data: data,
        type: 'POST',
        success: function(data) {
            $card.replaceWith(data.card_html);
            attach_card_events();
            $edited_card = null;
        },
        dataType: 'json'
    });

}

function card_edit_undo()
{
    $edited_card.find('.edit_container').hide();
    $edited_card.find('.edit_box').val( $edited_card.find('.edit_box').data('original_value') );
    $edited_card.find('.card_content').show();
    $edited_card = null;
}

function card_edit_adjust_height()
{
    var $div = $('#auto_height');
    var $edit_box = $edited_card.find('.edit_box:first');

    $div.css( 'font-size', $edit_box.css( 'font-size' ) );
    $div.css( 'font-family', $edit_box.css ('font-family') );
    $div.html( $edit_box.val().replace( /\n/g, '<br>' ) + '<br>' );
    $div.css( 'width' , $edit_box.width() );
    $edit_box.css('height' , $div.height() + 20);

}

function card_add_to_first_column()
{
    $column = $('div.column:first').find('ul.column');
    $.ajax({
        url: '?action=card_add&column_id=' + $column.data('id'),
        type: 'GET',
        success: function(data) {
            $column.prepend(data);
            attach_card_events();
            card_edit ($column.find('li.card:first') );
        },
        dataType: 'html'

    })
}

function card_add()
{
    $column = $(this).parents('div.column').find('ul.column');
    $.ajax({
        url: '?action=card_add&column_id=' + $column.data('id'),
        type: 'GET',
        success: function(data) {
            $column.prepend(data);
            attach_card_events();
            card_edit ($column.find('li.card:first') );
        },
        dataType: 'html'

    })
}

function card_remove(e, ui)
{
    var card_id = $(ui.draggable).data('id');

    $.ajax({
        url: '?action=remove_card',
        data: { 'card_id': card_id },
        type: 'POST',
        dataType: 'html'

    });

    $(ui.draggable).remove();

}