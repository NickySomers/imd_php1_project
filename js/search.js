$(document).ready(function(){
    $('input.typeahead').typeahead({
        name: 'typeahead',
        remote:'searchLoad.php?key=%QUERY',
        limit : 10
    });
});