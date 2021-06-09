require(["jquery", "Magento_Ui/js/modal/modal"],function($, modal) {
    let arrayChair = [];
    let chair = {};
    $(document).on('click','.room li',function(){
        let chairId = $(this).attr('data-id');
        let type = $(this).parents('ul').attr('class');
        let price = parseFloat($(this).attr('data-price')), total = 0;
        let dataChari = window.data;
        chair.numChair = chairId;
        chair.typeChair = type;
        chair.price = price;
        let itemNeedRemove;
        let current = $(this);
        if (arrayChair.length !== 0) {
            $.each(arrayChair,function(index , item) {
                if(item.numChair == chair.numChair) {
                    current.css('background','#fff')
                    itemNeedRemove = item;
                }
            })
        }
        console.log(arrayChair);
        if(!itemNeedRemove) {
            if(type.indexOf('1') != -1) {
                $(this).css('background','#72bf72')
            }
            if(type.indexOf('2') != -1) {
                $(this).css('background','#ff0000')
            }
            if(type.indexOf('3') != -1) {
                $(this).css('background','#e66f97')
            }
            
            arrayChair.push({...chair});
        }else{
            arrayChair.splice($.inArray(itemNeedRemove, arrayChair), 1 );
        }
        console.log(arrayChair);
        if (arrayChair.length !== 0) {
            $.each(arrayChair,function(index , item) {
                total += item.price;
            })
        }
        $('.result .price').text(total + 'đ');
        $('.submit-value').attr('data-chair',JSON.stringify(arrayChair));
    });

    $(document).on('click','.submit-value',function(){
        console.log($(this).attr('data-chair'));
        let url = window.url;
        data = JSON.parse($(this).attr('data-chair'));
        $.ajax({
            url: url,
            data: {data:data},
            type: 'post',
            dataType: 'json',
            showLoader: true,
            beforeSend: function () {
            },
            success: function (res) {
                console.log(res);
                var options = {
                    type: 'popup',
                    responsive: true,
                    title: 'Success',
                    buttons: [{ 
                        text: $.mage.__('Close'),
                        class: 'modal-close',
                        click: function () {
                            this.closeModal();
                        }
                    }]
                };
                var popup = modal(options, $('#messgean'));
                
                $('#messgean').modal('openModal');
            }
        })
            
    })
});