jQuery(document).ready(function($){
    var city = {
        init : function() {
            var active_city=$("#city").val();
            var _array=[];
            $(`#street_list option`).each(function(indx, elem){
                $(elem).hide();
            });
            $(`#street_list option[data-city=${active_city}]`).each(function(indx, elem){
                $(elem).show();
            });
        }
    }

    city.init();
    $("city").on("change",function(){city.init()});
    $("#start").on("click",function(){ $("#form_start").show(); })
})