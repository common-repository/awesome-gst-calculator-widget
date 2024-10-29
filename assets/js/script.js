let js = jQuery.noConflict();

js(document).ready(function(){

    getGstRates(js("#country").val()); //get data on document ready

    js("#GSTexclusive").on('keyup',function(){
        let GSTexclusive = js(this).val();
        let GSTpercentage = js("#GSTpercentage").val();
       
        let totalGST = Math.round((GSTexclusive*GSTpercentage)/100);
        let GSTinclusive = parseInt(GSTexclusive) + parseInt(totalGST);

        //set values
        js("#GST").val(totalGST);
        js("#GSTinclusive").val(Math.round(GSTinclusive));

    });

    js("#GSTinclusive").on('keyup',function(){
        let GSTinclusive = js(this).val();
        let GSTpercentage = js("#GSTpercentage").val();

        let GSTexclusive = GSTinclusive / ((GSTpercentage / 100) + 1); //reverse calculation farmula
        let totalGST = Math.round(parseFloat(GSTinclusive) - parseFloat(GSTexclusive));

        //set values
        js("#GST").val(totalGST);
        js("#GSTexclusive").val(Math.round(GSTexclusive));




    });


    js("#country").on('change',function(){
        getGstRates(js(this).val());
    });


    js("#gstrate").on('change',function(){
        var gstVal = js(this).val();
        js("#GSTpercentage").val(gstVal);
        js("#GSTLabel").html('GST('+gstVal+'%)');

        resetFields();
        
    });
});

function getGstRates(gst_val){
    jQuery.ajax({
        type: "post",
        dataType: "json",
        url: wpgstcal_ajax_object.ajax_url,
        data: {"country":gst_val,"action":"wpgstcal_get_gst"},
        success: function(response){
            let perentageArr = response.perentage;
            let html = "";
            for(let i=0;i<perentageArr.length;i++){
                html+='<option value="'+perentageArr[i]+'">'+perentageArr[i]+'%</option>'
            }
            js("#gstrate").html(html);

            if(perentageArr.length>1){
                js("#gstrate").prop("disabled",false);
            }else{
                js("#gstrate").prop("disabled",true);
            }
            js("#GSTpercentage").val(perentageArr[0]);

            js("#GSTLabel").html('GST('+perentageArr[0]+'%)');
            

            js("span.currency").html(response.currency);
            resetFields();
        }
    });
}

function resetFields(){
    js("#GSTexclusive").val("");
    js("#GSTinclusive").val("");
    js("#GST").val("");  
}