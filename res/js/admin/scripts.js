/**
 * Created by Michael on 08.03.2016.
 */
jQuery(document).ready(function () {

    jQuery('[data-toggle="tooltip"]').tooltip();

    function showTooltip(elem, msg) {
        elem.setAttribute('class', 'btn tooltipped tooltipped-s');
        elem.setAttribute('aria-label', msg);
    }

    var clipboard = new Clipboard('.form-btn');

    clipboard.on('success', function (e) {
        e.clearSelection();

    });


});
