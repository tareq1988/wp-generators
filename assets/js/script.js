jQuery(function($) {

    $('table').on('click', 'a.add-row', function(event) {
        event.preventDefault();

        var tr = $(this).closest('tr');
        var clone = tr.clone(false, false);

        clone.find('input[type="text"]').val('');
        clone.find('input[type="checkbox"]').prop('checked', false);

        clone.insertAfter( tr );
    });

    $('table').on('click', 'a.remove-row', function(event) {
        event.preventDefault();

        var table = $(this).closest('table');

        if ( table.find('tbody tr').length > 1 ) {
            $(this).closest('tr').remove();
        }
    });

});