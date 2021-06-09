require(
    [
        'Magento_Ui/js/lib/validation/validator',
        'jquery',
        'jquery/ui',
        'uiRegistry',
        'mage/translate',
        'domReady!'
    ], function (validator, $, ui, reg) {

        reg.get([
            "customer_form.areas.customer.customer.telephone"
        ], function (
            validatePhoneEle
        ) {
            validator.addRule(
                'validate-phone',

                function (value) {
                    return /^0[0-9]{1,9}$/.test(value);
                }
                , $.mage.__('Please enter the correct phone format')
            );
            validatePhoneEle.setValidation('validate-phone', true);

        });
    }
)

