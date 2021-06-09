require(
    [
        'Magento_Ui/js/lib/validation/validator',
        'jquery',
        'jquery/ui',
        'uiRegistry',
        'mage/translate',
        'domReady!'
    ], function (validator, $, ui, reg) {
        // $("#purple").on('click',function(){
        //     console.log('xxx');
        //     $('body').css("background-color", "#9683ec");
        // });

        $('#color_setting').on('change', function () {
            var selectVal = $("#color_setting option:selected").val();
            $('body').css("background-color", selectVal);
       });
    }
)