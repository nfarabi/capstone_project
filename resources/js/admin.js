require("./bootstrap");

// Select2
require("select2");
// bs-custom-file-input
window.bsCustomFileInput = require("bs-custom-file-input/dist/bs-custom-file-input");
// AdminLTE 3
require("admin-lte");
// Summernote WYSIWYG editor
require("summernote/dist/summernote-bs4.min");
// jQuery UI
require("jquery-ui/ui/core.js");
require("jquery-ui/ui/widgets/datepicker");
require("jquery-ui/ui/widgets/sortable");
require("jquery-ui/ui/disable-selection");
// clipboard.js
window.ClipboardJS = require("clipboard");

$(document).ready(function() {
    //---------------------------------------------------------
    // Initialize select2 [BEGIN]
    //---------------------------------------------------------
    var select2Objects = $(".select2");

    if (select2Objects.length) {
        select2Objects.each(function() {
            $(this).select2({
                placeholder: $(this).data("placeholder"),
                allowClear: $(this).data("allowClear")
            });
        });
    }
    //---------------------------------------------------------
    // Initialize select2 [END]
    //---------------------------------------------------------

    //---------------------------------------------------------
    // Initialize bs-custom-file-input [BEGIN]
    //---------------------------------------------------------
    bsCustomFileInput.init();
    //---------------------------------------------------------
    // Initialize bs-custom-file-input [END]
    //---------------------------------------------------------

    //---------------------------------------------------------
    // Initialize ClipboardJS [BEGIN]
    //---------------------------------------------------------
    var clipboard = new ClipboardJS('.clipboard');
    //---------------------------------------------------------
    // Initialize ClipboardJS [END]
    //---------------------------------------------------------

    //---------------------------------------------------------
    // Toggle published / Status form [BEGIN]
    //---------------------------------------------------------
    $(".toggle-model").on("change", "input", function() {
        var $form = $(this).closest("form");

        $.post($form.attr("action"), $form.serialize(), function(response) {
            // console.log(response);
        });
    });
    //---------------------------------------------------------
    // Toggle published / Status form [END]
    //---------------------------------------------------------

    //---------------------------------------------------------
    // Flash messages [BEGIN]
    //---------------------------------------------------------
    // Auto hide messages after 3s
    $("div.alert")
        .not(".alert-important")
        .delay(3000)
        .fadeOut(350);
    // Show modal messages
    $("#flash-overlay-modal").modal();
    //---------------------------------------------------------
    // Flash messages [END]
    //---------------------------------------------------------

    //---------------------------------------------------------
    // Initialize select2 [BEGIN]
    //---------------------------------------------------------
    $(".rich-editor").summernote({
        tabsize: 2,
        height: 200,
        minHeight: 100,
        maxHeight: 300
    });
    //---------------------------------------------------------
    // Initialize select2 [END]
    //---------------------------------------------------------

    //---------------------------------------------------------
    // Switch language [BEGIN]
    //---------------------------------------------------------
    $(".language-switcher .dropdown-item").on("click", function(e) {
        e.preventDefault();

        if ($(this).data("language-code") && $(this).data("language-code").length) {
            window.location.href =
                window.location.origin +
                "/admin/languages/switch?language_code=" +
                $(this).data("language-code");
        }
    });
    //---------------------------------------------------------
    // Switch language [END]
    //---------------------------------------------------------

    //---------------------------------------------------------
    // Turn input into jQuery UI datepicker [BEGIN]
    //---------------------------------------------------------
    var datepickerObjects = $(".datepicker");

    if (datepickerObjects.length) {
        datepickerObjects.each(function() {
            $(this).attr("autocomplete", "off"); // Turn off autocomplete prompt for datepicker

            $(this).datepicker({
                dateFormat: "dd/mm/yy",
                maxDate: $(this).data("max-date")
            });
        });
    }
    //---------------------------------------------------------
    // Turn input into jQuery UI datepicker [END]
    //---------------------------------------------------------
});
