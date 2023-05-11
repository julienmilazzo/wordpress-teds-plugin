jQuery( document ).ready(function() {
    jQuery('.teds-search-wrapper .teds-search-field').on('keyup', function() {
        let el = jQuery(this);
        let liveSearch = el.parent().data('liveSearch');
        let liveSearchKey = el.parent().data('liveSearchKey');
        if ('yes' === liveSearch) {
            if (el.val().length >= liveSearchKey) {
                search(el);
            } else {
                resetSearch(el);
            }
        }
    });
    jQuery('.teds-search-wrapper .search-button').on('click', function() {
        search(jQuery(this).prev().prev());
    });
    jQuery('.teds-search-wrapper .reset-button').on('click', function() {
        let el = jQuery(this).prev();
        el.val('');
        resetSearch(el);
    });
});

function search(el) {
    let currentVal = el.val();
    let searchClass = el.parent().data('searchClass');
    let searchEls = jQuery('.' + searchClass);
    let searchDisplayClass = el.parent().data('searchDisplayClass');
    if (searchClass && searchEls.length) {
        jQuery('.reset-button').show();
        searchEls.each(function( index ) {
            let currentSearchEl = jQuery(searchEls[index]);
            if (-1 !== currentSearchEl.text().toLowerCase().indexOf(currentVal.toLowerCase())) {
                currentSearchEl.closest('.' + searchDisplayClass).show();
            } else {
                currentSearchEl.closest('.' + searchDisplayClass).hide();
            }
        });
    }
}
function resetSearch(el) {
    let searchDisplayClass = el.parent().data('searchDisplayClass');
    jQuery('.' + searchDisplayClass).show();
    jQuery('.reset-button').hide();
}
