/*
Form: EventFiltersType; template: templates/general/event/filters.form.html.twig
uncheck checkbox when another is checked
*/
$('input#event_filters_homeProduction').on('change', function() {
    $('input#event_filters_externalProduction').prop('checked', false);
    $(this).closest('form').submit();
});
$('input#event_filters_externalProduction').on('change', function() {
    $('input#event_filters_homeProduction').prop('checked', false);
    $(this).closest('form').submit();
});
$('input#event_filters_premiere').on('change', function() {
    $(this).closest('form').submit();
});
