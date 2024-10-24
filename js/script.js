jQuery(document).ready(function ($) {
    const plugin_dir = wp_info.pluginDir;
    const note = `<div class="ps-note-wrap">
    <div class="ps-note-header">
      <div class="ps-save-wrap">
        <span class="ps-remove-btn"><img src="${plugin_dir}/js/window-close.png"></span>
        <button class="ps-save-note">Save</button>
      </div>
    </div>
    <div class="ps-note-aria">
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
        $(this).closest('.ps-note-wrap').fadeOut(300, function () {
            $(this).remove();
        });
    });

    $('body').on('click', '.ps-remove-btn', function () {
        if (confirm("Are you sure you want to delete this?")) {
            $(this).closest('.ps-note-wrap').remove();
        }
    });
});
