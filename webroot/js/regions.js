$(document).ready(function(){
    $('#UserObcina').live('change', function() {
        if($(this).val().length != 0) {
            $.getJSON('/users/get_regions_ajax',
            { 
                countryId: $(this).val()
            },
            function(regionsTMP) {
                if(regionsTMP !== null) {
                    populateRegionsList(regionsTMP);
                } 
            }); 
        }
    });
});

function populateRegionsList(regionsTMP) { 
    var options = '<option value=""></option>';
    $.each(regionsTMP, function(index, carModel) {
        options += '<option value="' + index + '">' + carModel + '</option>';
    });
    $('#UserCityId').html(options);
}




$(document).ready(function(){
    $('#UserCountryId').live('change', function() {
        if($(this).val().length != 0) {
            $.getJSON('/users/getajaxregions',
            {
                regionId: $(this).val()
            },
            function(regionsSTMP) {
                if(regionsSTMP !== null) {
                    populateRegionsSList(regionsSTMP);
                }
            });
        }
    });
});

function populateRegionsSList(regionsSTMP) {
    var options = '<option value=""></option>';
    $.each(regionsSTMP, function(index, carModel) {
        options += '<option value="' + index + '">' + carModel + '</option>';
    });
    $('#UserObcina').html(options);
}