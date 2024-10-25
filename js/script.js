jQuery(document).ready(function ($) {

    const theme_index = $('.ps-create-note-nav').data('theme');

    const noteThemes = [
        {
            header: "#f39c12",
            body: "#f1c40f"
        },
        {
            header: "#f5f5f5",
            body: "#FEFEFE"
        },
        {
            header: "#d4cdf3",
            body: "#DDD9FE"
        },
        {
            header: "#f1c3f1",
            body: "#F5D2F5"
        },
        {
            header: "#c5f7c1",
            body: "#D1FECB"
        },
        {
            header: "#c9ecf8",
            body: "#D8F2FA"
        },
        {
            header: "#fbac5f",
            body: "#F7BD84"
        },
        {
            header: "#7f7f7f",
            body: "#9F9F9F"
        }
    ];    

    var theme = noteThemes[theme_index];

    var note_body_color = theme.body

    var note_header_color = theme.header

    const plugin_dir = wp_info.pluginDir;
    const note = `<div class="ps-note-wrap">
    <div class="ps-note-header" style= background-color:${note_header_color}>
      <div class="ps-save-wrap">
        <span class="ps-remove-btn"><img src="${plugin_dir}/js/window-close.png"></span>
        <button class="ps-save-note">Save</button>
      </div>
    </div>
    <div class="ps-note-aria" style= background-color:${note_body_color}>
        <div contenteditable class="ps-content-field"></div>
    </div>
    </div>`;

    $('body').on("click", '.ps-create-note-nav', function (e) {
        e.preventDefault();

        const mouseX = e.pageX;
        const mouseY = e.pageY;

        const $note = $(note);
        $("body").append($note);

        $note.css({
            position: 'absolute',
            left: mouseX,
            top: mouseY
        });

        $note.draggable({
            handle: '.ps-note-header',
        });
    });

    $('body').on("click", '.ps-save-note', function (e) {
        const note_wrap = $(this).closest('.ps-note-wrap');
        const note_content = note_wrap.find('.ps-content-field').text();

        const user_id = wp_info.userId;

        if(note_content !== ""){
            $.ajax({
                url: wp_info.ajaxUrl,
                method: 'POST',
                data: {
                    action: 'save_note',
                    note: note_content,
                    user_id: user_id,
                },
                success: function(response) {
                    if (response.success) {
                        $(note_wrap).fadeOut(300, function () {
                            $(this).remove();
                        });
        
                    } else {
                        alert('Error saving note: ' + response.data);
                    }
                },
                error: function() {
                    alert('An error occurred while saving the note.');
                }
            });
        }else{
            alert("Note content is empty.");
        }
    });
    
    $('body').on('click', '.ps-remove-btn', function () {
        if (confirm("Are you sure you want to delete this?")) {
            $(this).closest('.ps-note-wrap').remove();
        }
    });
});



