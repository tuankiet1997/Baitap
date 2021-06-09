require(["jquery", "jquery/ui", "mage/calendar"], function (jq) {
    jq(function(){
        function bindDatePicker() {
            setTimeout(function() {
                jq('div[data-index="product_from_date"]').datetimepicker( { dateFormat: "mm/dd/yy", changeMonth: true, changeYear: true, beforeShowDay: function(d) {
                    console.log("in"+d.getDate());
                       if (d.getDate() == 8 || d.getDate() == 9 || d.getDate() == 10 || d.getDate() == 11 || d.getDate() == 12) {
                         return [true, "" ];
                       } else {
                          return [false, "" ];
                       }
                    }});
            }, 50);
        }
    });  
});