(function ($) {
    "use strict";

    var alllanguage='';
    $.ajax({url: base_url+'assets/js/language.json',
        async: false,
        method:'post',
        dataType: 'json',
        global: false,
        contentType: 'application/json',
        success: function (data) {
            var lngdata = JSON.stringify(data);
            alllanguage = lngdata;
        }
    });
    var display = $.parseJSON(alllanguage);

    $("#add_type").on("change", function(event) {
        event.preventDefault();

        var url         = $(location).attr('href');
        var segmentdata = url.replace(base_url,"");
        var segments    = segmentdata.split( '/' );
        var advert_id   = segments[4];

        $.getJSON(base_url+'internal_api/getadvirtigementdata?id='+advert_id, function(apidata){

            var add_type = $("#add_type").val()|| 0;
            var showimg  = "";
            var empadscript  = " ";
            if(apidata.image!=""){
                showimg = "<img src='"+base_url+apidata.image+"' width='450'>";
            }
            if(apidata.script!=""){
                empadscript = apidata.script;
            }

            if (add_type==='image') {
                $( "#add_content_load").html("<div class='form-group row'><label for='image' class='col-sm-4 col-form-label'>"+display['image'][language]+"</label><div class='col-sm-8'><input name='image' class='form-control image' type='file' id='image'><input type='hidden' name='image_old' value='"+apidata.image+"'>"+showimg+"</div></div><div class='form-group row'><label for='url' class='col-sm-4 col-form-label'>"+display['url'][language]+"</label><div class='col-sm-8'><input name='url' value='"+apidata.url+"' class='form-control' placeholder='"+apidata.url+"' type='text' id='url'></div></div>");
            }
            else if (add_type==='code') {
                $( "#add_content_load").html("<div class='form-group row'><label for='script' class='col-sm-4 col-form-label'>"+display['embed_code'][language]+"<i class='text-danger'>*</i></label><div class='col-sm-8'><textarea  name='script' class='form-control' placeholder='"+display['embed_code'][language]+"' type='text' id='script'>"+empadscript+"</textarea></div></div>");
            }
            else{
                $( "#add_content_load").html("");
            }
        
        });

    });

    $.getJSON(base_url+'internal_api/getsummernoteinformation', function(apidata){
        $.each(apidata, function(key,value) {
            if($('#article1_'+value.iso).length && $.fn.summernote){
                $('#article1_'+value.iso).summernote({
                    height: 200, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: true     // set focus to editable area after initializing summernote
                });
            }
            if($('#article2_'+value.iso).length && $.fn.summernote){
                $('#article2_'+value.iso).summernote({
                    height: 200, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: true     // set focus to editable area after initializing summernote
                });
            }
            if($('#progress_title_'+value.iso).length && $.fn.summernote){
                $('#progress_title_'+value.iso).summernote({
                    height: 200, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: true     // set focus to editable area after initializing summernote
                });
            }
        }); 
    });

    if($("#summernote").length) {
        //summernote
        $('#summernote').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true     // set focus to editable area after initializing summernote
        });
    }
    if($("#summernote1").length) {
        //summernote
        $('#summernote1').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true     // set focus to editable area after initializing summernote
        });
    }
    if($("#summernote2").length) {
        //summernote
        $('#summernote2').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true     // set focus to editable area after initializing summernote
        });
    }
    if($("#summernote3").length) {
        //summernote
        $('#summernote3').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true     // set focus to editable area after initializing summernote
        });
    }

    $('.btn-danger').on('click',function(){
        var title = $(this).attr('title');

        if(title=="Delete"){
            var conf   = confirm(display['are_you_sure_you_want_to_delete_it'][language]);
            if(conf)
                return true;
            else
                return false;
        }
    });

    $("#market_id, #coin_id").on("change", function(event) {
        event.preventDefault();
        var market = $("#market_id").val();
        var coin = $("#coin_id").val();

        if (market == coin) {
            alert(display['please_select_different_coin'][language]);
            $('option:selected', this).remove();
        };
        $("#symbol").val(market+'_'+coin);

    });

    if($('#ajaxcointableform').length){

        var table;

        var ajaxcointableform = JSON.stringify($('#ajaxcointableform').serializeArray());
        var formdata          = $.parseJSON(ajaxcointableform);
        var inputname         = formdata[0]['name'];
        var inputval          = formdata[0]['value'];

        //datatables
        table = $('#ajaxcointable').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],        //Initial no order.
            "pageLength": 10,   // Set Page Length
            "lengthMenu":[[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url+"backend/sto_settings/currency/ajax_list",
                "type": "POST",
                "data": {csrf_test_name:inputval}
            },

            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ 0 ], //first column / numbering column
                "orderable": false, //set not orderable
            },
            ],
           "fnInitComplete": function (oSettings, response) {
            
          }

        });
        $.fn.dataTable.ext.errMode = 'none';
    }

    if($( "#schedule_date" ).length){
        $( "#schedule_date" ).datetimepicker({ dateFormat: 'yy-mm-dd' });
    }

    $(".AjaxModal").click(function(){
      var url = $(this).attr("href");
      var href = url.split("#");  
      jquery_ajax(href[1]);
    });

    function jquery_ajax(id) {
       $.ajax({
            url : base_url+"backend/Ajax_load/user_info_load/" + id,
            type: "GET",
            data: {'id':id},
            dataType: "JSON",
            success: function(data)
            {

                $('#name').text(data.first_name+' '+data.last_name);
                $('#email').text(data.email);
                $('#phone').text(data.phone);
                $('#user_id').text(data.user_id);
              
               
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    $('#url_status').on('change',function(){
        if($(this).val()==1){
            var url = $('#url').val();
                url = url.replace('https','http');
                $('#url').val(url);
        }
        else{
            var url = $('#url').val();
                url = url.replace('http','https');
                $('#url').val(url);
        }
    });

    $('input[type="checkbox"]').each(function(){
        $(this).on('change',function(){
            $(this).val()==1?$(this).val(0):$(this).val(1);
        });
    });

    $("#gatewayname").on("change", function(event) {
        event.preventDefault();
        var gatewayname = $("#gatewayname").val();

        $.getJSON(base_url+'internal_api/getemailsmsgateway', function(sms){

            var host     = "";
            var user     = "";
            var userid   = "";
            var api      = "";
            var password = "";

            if(sms.gatewayname=="budgetsms"){
                host    = sms.host;
                user    = sms.user;
                userid  = sms.userid;
                api     = sms.api;
            }
            if(sms.gatewayname=="infobip"){
                host    = sms.host;
                user    = sms.user;
                password= sms.password;
            }
            if(sms.gatewayname=="smsrank"){
                host    = sms.host;
                user    = sms.user;
                password= sms.password;
            }
            if(sms.gatewayname=="nexmo"){
                api     = sms.api;
                password= sms.password;
            }

            if (gatewayname==='budgetsms') {
                $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'>"+display['host'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='"+display['host'][language]+"' value='"+host+"' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'>"+display['username'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='"+display['username'][language]+"' value='"+user+"' required></div></div><div class='form-group row'><label for='userid' class='col-xs-3 col-form-label'>"+display['user_id'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='userid' type='text' class='form-control' id='userid' placeholder='"+display['user_id'][language]+"' value='"+userid+"' required></div></div><div class='form-group row'><label for='api' class='col-xs-3 col-form-label'>"+display['apikey'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='api' type='text' class='form-control' id='api' placeholder='"+display['apikey'][language]+"' value='"+api+"' required></div></div>");

            }else if(gatewayname==='infobip'){
               $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'>"+display['host'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='"+display['host'][language]+"' value='"+host+"' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'>"+display['username'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='"+display['username'][language]+"' value='"+user+"' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'>"+display['password'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='"+display['password'][language]+"' value='"+password+"' required></div></div>");

            }else if(gatewayname==='smsrank'){
               $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'>"+display['host'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='"+display['host'][language]+"' value='"+host+"' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'>"+display['username'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='"+display['username'][language]+"' value='"+user+"' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'>"+display['password'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='"+display['password'][language]+"' value='"+password+"' required></div></div>");

            }else if(gatewayname==='nexmo'){
               $( "#sms_field").html("<div class='form-group row'><label for='api' class='col-xs-3 col-form-label'>"+display['apikey'][language]+"<i class='text-danger'>*</i></label><div class='col-xs-9'><input name='api' type='text' class='form-control' id='api' placeholder='"+display['apikey'][language]+"' value='"+api+"' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'>"+display['app_secret'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='"+display['password'][language]+"' value='"+password+"' required></div></div>");

            }else if(gatewayname==='twilio'){
                $( "#sms_field").html("<h3><a href='https://www.twilio.com'>Twilio</a> Is On Development</h3>"); 

            }
            else{
                $( "#sms_field").html("<h3>Nothing Found</h3>");

            }

        });
    });

    var gatewayname = $("#gatewayname").val();
    if(gatewayname){
        $.getJSON(base_url+'internal_api/getemailsmsgateway', function(sms){

            var host     = "";
            var user     = "";
            var userid   = "";
            var api      = "";
            var password = "";

            if(sms.gatewayname=="budgetsms"){
                host    = sms.host;
                user    = sms.user;
                userid  = sms.userid;
                api     = sms.api;
            }
            if(sms.gatewayname=="infobip"){
                host    = sms.host;
                user    = sms.user;
                password= sms.password;
            }
            if(sms.gatewayname=="smsrank"){
                host    = sms.host;
                user    = sms.user;
                password= sms.password;
            }
            if(sms.gatewayname=="nexmo"){
                api     = sms.api;
                password= sms.password;
            }

            if (gatewayname==='budgetsms') {
                $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'>"+display['host'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='"+display['host'][language]+"' value='"+host+"' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'>"+display['username'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='"+display['username'][language]+"' value='"+user+"' required></div></div><div class='form-group row'><label for='userid' class='col-xs-3 col-form-label'>"+display['user_id'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='userid' type='text' class='form-control' id='userid' placeholder='"+display['user_id'][language]+"' value='"+userid+"' required></div></div><div class='form-group row'><label for='api' class='col-xs-3 col-form-label'>"+display['apikey'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='api' type='text' class='form-control' id='api' placeholder='"+display['apikey'][language]+"' value='"+api+"' required></div></div>");

            }else if(gatewayname==='infobip'){
               $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'>"+display['host'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='"+display['host'][language]+"' value='"+host+"' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'>"+display['username'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='"+display['username'][language]+"' value='"+user+"' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'>"+display['password'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='"+display['password'][language]+"' value='"+password+"' required></div></div>");

            }else if(gatewayname==='smsrank'){
               $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-form-label'>"+display['host'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='host' type='text' class='form-control' id='host' placeholder='"+display['host'][language]+"' value='"+host+"' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-form-label'>"+display['username'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='user' type='text' class='form-control' id='user' placeholder='"+display['username'][language]+"' value='"+user+"' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'>"+display['password'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='"+display['password'][language]+"' value='"+password+"' required></div></div>");

            }else if(gatewayname==='nexmo'){
               $( "#sms_field").html("<div class='form-group row'><label for='api' class='col-xs-3 col-form-label'>"+display['apikey'][language]+"<i class='text-danger'>*</i></label><div class='col-xs-9'><input name='api' type='text' class='form-control' id='api' placeholder='"+display['apikey'][language]+"' value='"+api+"' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-form-label'>"+display['app_secret'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9'><input name='password' type='password' class='form-control' id='password' placeholder='"+display['password'][language]+"' value='"+password+"' required></div></div>");

            }else if(gatewayname==='twilio'){
                $( "#sms_field").html("<h3><a href='https://www.twilio.com'>Twilio</a> Is On Development</h3>"); 

            }
            else{
                $( "#sms_field").html("<h3>Nothing Found</h3>");

            }
        });
    }

    $('.print').on('click',function(){
        printContent('printableArea');
    });

    //print a div
    function printContent(el){
        var restorepage  = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
        location.reload();
    }

    var info = $('table tbody tr');
    info.click(function() {
        var email    = $(this).children().first().text(); 
        var password = $(this).children().first().next().text();
        var user_role = $(this).attr('data-role');  

        $("input[name=email]").val(email);
        $("input[name=password]").val(password);
        $('select option[value='+user_role+']').attr("selected", "selected"); 
    });

    $.getJSON(base_url+'internal_api/getlinechartdata', function(apidata){
        var ctx = document.getElementById("lineChart");
        if(ctx){
            window.myChart1 = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: apidata.months,
                    datasets: [

                        {
                            label: "Investment",
                            borderColor: "rgba(0,0,0,.09)",
                            borderWidth: "1",
                            backgroundColor: "rgba(55, 160, 0, 0.5)",
                            pointHighlightStroke: "rgba(26,179,148,1)",
                            data: apidata.investamount
                        }

                    ]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    }
                }
            });
        }
    });

    $("#add_facility").on("click", function() {
        var htmlData = '<div class="facilityDifInput"><input name="facility[]" class="form-control facilityInputbox" placeholder="New Facility" type="text" ><span class="removeBtn">×</span></div>';
        $('#add_facility_input').append(htmlData);
    });
    $(document).on('click', '.removeBtn', function() {
        $(this).prev('input').remove()
        .end().prev('br').remove()
        .end().remove();
    });

    $("#facility_type").on("change",function(){

        if($(this).val()==1){
            $('#roi_type').css("display","block");
            $('#other_facilites_type').css("display","none");
        }
        else{
            $('#other_facilites_type').css("display","block");
            $('#roi_type').css("display","none");
        }


    });

    if($('#weekly_roi'.length)){
        var weekly_roi      = parseFloat($("#weekly_roi").val())|| 0;
        if (weekly_roi>0) {
            $( "#weekly_roi" ).prop( "disabled", false);
        }
        var package_price    = parseFloat($("#package_price").val())|| 0;
        if (package_price>0) {
            $( "#weekly_roi" ).prop( "disabled", false);
        }

        $("#package_price").on("keyup", function(event) {
            event.preventDefault();
            var package_price  = parseFloat($("#package_price").val())|| 0;

            if (package_price>0) {

                $( "#weekly_roi" ).prop( "disabled", false);

                var package_price  = parseFloat($("#package_price").val())|| 0;
                var weekly_roi      = parseFloat($("#weekly_roi").val())|| 0;
                var monthly_roi     = parseFloat($("#monthly_roi").val())|| 0;
                var yearly_roi      = parseFloat($("#yearly_roi").val())|| 0;
                var total_percent   = parseFloat($("#total_percent").val())|| 0;

                if (weekly_roi>0) {
                    if (package_price) {
                        monthly_roi     = (365/12)/7*weekly_roi;
                        yearly_roi      = monthly_roi*12;
                        total_percent   = (100*yearly_roi)/package_price;

                        $("#monthly_roi").val(Math.round(monthly_roi));
                        $("#yearly_roi").val(Math.round(yearly_roi));
                        $("#total_percent").val(Math.round(total_percent));

                    }else{
                        alert("Please Enter Package amount!");
                        return false;

                    }
                }else{
                    $("#weekly_roi").val(0);
                    $("#monthly_roi").val(0);
                    $("#yearly_roi").val(0);
                    $("#total_percent").val(0);
                }

            }
            else{
                $( "#weekly_roi" ).prop( "disabled", true);
                
            }

        });
    }

    $("#weekly_roi").on("keyup", function(event) {
        event.preventDefault();
        var package_price   = parseFloat($("#package_price").val())|| 0;
        var weekly_roi      = parseFloat($("#weekly_roi").val())|| 0;
        var monthly_roi     = parseFloat($("#monthly_roi").val())|| 0;
        var yearly_roi      = parseFloat($("#yearly_roi").val())|| 0;
        var total_percent   = parseFloat($("#total_percent").val())|| 0;


        if (package_price) {
            monthly_roi     = (365/12)/7*weekly_roi;
            yearly_roi      = monthly_roi*12;
            total_percent   = (100*yearly_roi)/package_price;

            $("#monthly_roi").val(monthly_roi.toFixed(5));
            $("#yearly_roi").val(yearly_roi.toFixed(5));
            $("#total_percent").val(total_percent.toFixed(5));

        }else{
            alert(display['please_enter_package_amount'][language]);
            return false;
        }

    });

    if($('#ajaxusertableform').length){
        var table;
        var ajaxusertableform = JSON.stringify($('#ajaxusertableform').serializeArray());
        var formdata          = $.parseJSON(ajaxusertableform);
        var inputname         = formdata[0]['name'];
        var inputval          = formdata[0]['value'];
        //datatables
        table = $('#ajaxtable').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],        //Initial no order.
            "pageLength": 10,   // Set Page Length
            "lengthMenu":[[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url+"backend/shareholders/shareholder/ajax_list",
                "type": "POST",
                "data": {csrf_test_name:inputval}
            },

            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ 0 ], //first column / numbering column
                "orderable": false, //set not orderable
            },
            ],
           "fnInitComplete": function (oSettings, response) {
          }

        });

        $.fn.dataTable.ext.errMode = 'none';
    }

    if($('.sto').length){
        var sum = 0;
        $('.sto').each(function(){
            sum += Number($(this).val());
        });
        $('#total_sto').val(sum);
        
        $(document).on('change','.sto',function(){
            var sum = 0;
            $('.sto').each(function(){
                sum += Number($(this).val());
            });
            $('#total_sto').val(sum);
        });
    }

    $(".main_row").each(function(){
        $(this).on('click',function(){
            var id = $(this).attr('column_id');
            var status = $(this).attr('clickstatus');
            if(!status){
                $('.'+id+'_sub_role').slideDown();
                $('#'+id+'_icon').removeClass("fa-plus");
                $('#'+id+'_icon').addClass("fa-minus");
                $(this).attr('clickstatus',0);
            }
            else{
                $('.'+id+'_sub_role').slideUp();
                $('#'+id+'_icon').removeClass("fa-minus");
                $('#'+id+'_icon').addClass("fa-plus");
                $(this).removeAttr('clickstatus');
            }
        });
    });
    $(".allcheck").each(function(){
        $(this).on('click',function(){
            if($(this).prop("checked"))
                $(this).parent().prevAll("td").find("input:checkbox").prop("checked",true)
            else
                $(this).parent().prevAll("td").find("input:checkbox").prop("checked",false)
        });
    });

    if (segment === 'home') {
        $('.home').addClass('active');

    }
    else if (segment === 'team' || segment==='commission') {
        $('.account').addClass('active');

    }
    else if (segment === 'withdraw') {
        $('.finance').addClass('active');
        $('.withdraw').addClass('active');

    }
    else if (segment === 'transfer') {
        $('.finance').addClass('active');
        $('.transfer').addClass('active');

    }
    else if (segment === 'deposit') {
        $('.finance').addClass('active');
        $('.deposit').addClass('active');

    }
    else if (segment === 'transection') {
        $('.transection').addClass('active');

    }
    else if (segment === 'notification') {
        $('.notification').addClass('active');

    }
    else if (segment === 'message') {
        $('.message').addClass('active');

    }
    else if (segment === 'settings') {
        $('.settings').addClass('active');

    }
    else if (segment === 'currency' || segment==='buy' || segment==='sell' || segment==='exchange') {
        $('.exchange').addClass('active');

    }

    $('#confirm_withdraw_btn').on('click',function(){
        var confirm_id = document.forms['verify'].elements['confirm_id'].value;
        withdraw(confirm_id);
    });

    function withdraw(id){

        var code = document.forms['verify'].elements['code'].value;
        var csrf_test_name = document.forms['verify'].elements['csrf_test_name'].value;

        swal({
            title: 'Please Wait......',
            type: 'warning',
            showConfirmButton: false,
            onOpen: function () {
                swal.showLoading()
              }
        });


        $.ajax({
            url: base_url+'shareholder/withdraw/withdraw_verify',
            type: 'POST', //the way you want to send data to your URL
            data: {'id': id,'code':code,'csrf_test_name':csrf_test_name },
            success: function(data) {

                if(data!=''){
                    
                    swal({
                        title: "Good job!",
                        text: display['your_custom_email_send_successfully'][language],
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500,

                    });

                   window.location.href = base_url+"shareholder/withdraw/withdraw_details/"+data;
                    
                } else {

                    swal({
                        title: "Wops!",
                        text: "Wrong verification code",
                        type: "error",
                        showConfirmButton: false,
                        timer: 1500
                    });

                }
                
            }
        });
    }

    $('#deposit_amount').on('keyup',function(){
        Fee();
    });
    $('#method').on('change',function(){
        Fee();
    });

    function Fee(){

        var amount         = document.forms['deposit_form'].elements['deposit_amount'].value;
        var method         = document.forms['deposit_form'].elements['method'].value;
        var level          = document.forms['deposit_form'].elements['level'].value;
        var csrf_test_name = document.forms['deposit_form'].elements['csrf_test_name'].value;

        if (amount!="" || amount==0) {
            $("#method" ).prop("disabled", false);
        }
        if (amount=="" || amount==0) {
            $('#fee').text("Fees is "+0);
        }
        if (amount!="" && method!=""){
            $.ajax({
                'url': base_url+'shareholder/ajaxload/fees_load',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'method': method,'level':level,'amount':amount,'csrf_test_name':csrf_test_name },
                'dataType': "JSON",
                'success': function(data) { 
                    if(data){
                        $('[name="amount"]').val(data.amount);
                        $('[name="fees"]').val(data.fees);
                        $('#fee').text("Fees is "+data.fees);                    
                    } else {
                        alert('Error!');
                    }  
                }
            });
        } 
    }

    $.getJSON(base_url+'internal_api/getdepositgatewaydata', function(apidata){
    
        $("#method").on("change", function(event) {
            event.preventDefault();
            var method = $("#method").val()|| 0;

            if (method=='phone') {
                $( ".payment_info").html("<div class='form-group row'><label for='send_money' class='col-sm-5 col-form-label'>Send Money</label><div class='col-sm-7'><h2><a href='tel:"+apidata.public_key+"'>"+apidata.public_key+"</a></h2></div></div><div class='form-group row'><label for='om_name' class='col-sm-5 col-form-label'>"+display['om_name'][language]+"</label><div class='col-sm-7'><input name='om_name' class='form-control om_name' type='text' id='om_name' autocomplete='off'></div></div><div class='form-group row'><label for='om_mobile' class='col-sm-5 col-form-label'>"+display['om_mobile_no'][language]+"</label><div class='col-sm-7'><input name='om_mobile' class='form-control om_mobile' type='text' id='om_mobile' autocomplete='off'></div></div><div class='form-group row'><label for='transaction_no' class='col-sm-5 col-form-label'>"+display['transaction_no'][language]+"</label><div class='col-sm-7'><input name='transaction_no' class='form-control transaction_no' type='text' id='transaction_no' autocomplete='off'></div></div><div class='form-group row'><label for='idcard_no' class='col-sm-5 col-form-label'>"+display['idcard_no'][language]+"</label><div class='col-sm-7'><input name='idcard_no' class='form-control idcard_no' type='text' id='idcard_no' autocomplete='off'></div></div>");
            }
            else{
                $( ".payment_info").html("<div class='form-group row'><label for='comments' class='col-sm-5 col-form-label'>"+display['comments'][language]+"</label><div class='col-sm-7'><textarea name='comments' class='form-control editor' placeholder='' type='text' id='comments'></textarea></div></div>");
            }
        });
    });

    $.getJSON(base_url+'internal_api/getmenucontrollerinfo', function(apidata){

        if(segment=="package"){
            if(apidata.package==0){
                $('#confirm_order,#package_terms').prop('disabled',true);
            }
            else{
                $('#confirm_order').attr("disabled", "disabled");
                $('#package_terms').change(function(){
                    var terms = $(this).is(":checked");
                    if(terms){
                        $('#confirm_order').removeAttr("disabled");
                    }
                    else{
                        $('#confirm_order').attr("disabled", "disabled");
                    }
                });
            }
        }
        if(segment=="token"){
            if(apidata.isto==0){
                $('#sto_qty,.m-b-5').prop('disabled',true);
            }
        }
        if(segment=="exchange"){
            if(apidata.exchange==0){
                $('#buyqty,#buyrate,.w-md,#sellqty,#sellrate').prop('disabled',true);
            }
        }
    });

    $('#profile_verify_confirm').on('click',function(){

        var url         = $(location).attr('href');
        var segmentdata = url.replace(base_url,"");
        var segments    = segmentdata.split( '/' );
        var id          = segments[3];
        sendEmail(id);

    });

    function sendEmail(id){

        var code           = document.forms['verify'].elements['code'].value;
        var csrf_test_name = document.forms['verify'].elements['csrf_test_name'].value;

        swal({
            title: 'Please Wait......',
            type: 'warning',
            showConfirmButton: false,
            onOpen: function () {
                swal.showLoading()
              }
        });

        $.ajax({
            url: base_url+'shareholder/profile/profile_update',
            type: 'POST', //the way you want to send data to your URL
            data: {'id': id,'code':code,'csrf_test_name':csrf_test_name },
            success: function(data) { 
                
                if(data==1){

                    swal({
                        title: "Good job!",
                        text: display['your_custom_email_send_successfully'][language],
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500,

                    });
                    window.location.href = base_url+"shareholder/profile";
                    
                } else {

                    swal({
                        title: "Wops!",
                        text: "Wrong verification code",
                        type: "error",
                        showConfirmButton: false,
                        timer: 1500
                    });

                }
                
            }
        });
    }

    $.getJSON(base_url+'internal_api/gettokenbuydata', function(apidata){
    
        $("#sto_qty").on("keyup", function(event) {
            event.preventDefault();

            var price    = apidata.coin_price.rate;
            var symbol   = apidata.coininfo.pair_with;
            var sto_qty  = parseFloat($('#sto_qty').val());
            var total    = sto_qty*price;

            if(total>0){
                $("#total").html("<span>" + symbol+" "+ total + "</span>");
            }
            else{
                $("#total").html("<span>" + symbol+" 0.00"+ "</span>");
            }

        });

    });

    $('#receiver_id').on('blur',function(){

        ReciverChack($(this).val());

    });

    function ReciverChack(receiver_id){

        var csrf_test_name = document.forms['transfer_form'].elements['csrf_test_name'].value;

        $.ajax({
            url: base_url+'shareholder/ajaxload/checke_reciver_id',
            type: 'POST', //the way you want to send data to your URL
            data: {'receiver_id': receiver_id,'csrf_test_name':csrf_test_name },
            success: function(data) { 
                
                if(data!=0){
                    $('#receiver_id').css("border","1px green solid");
                    $('.suc').css("border","1px green solid");
                } else {
                     $('#receiver_id').css("border","1px red solid");
                     $('.suc').css("border","1px red solid");
                }  
            },
        });
    }

    $("#verify_type").on("change", function(event) {
        event.preventDefault();
        var verify_type = $("#verify_type").val();

        if (verify_type == 'passport') {

            $("#verify_field").html("<div class='form-group row'><label for='document1' class='col-md-4 col-form-label'>"+display['passport_cover'][language]+"(MAX 2MB) <span><i class='text-danger'>*</i></span></label><div class='col-md-8'><input name='document1' type='file' class='form-control' id='document1' required></div></div><div class='form-group row'><label for='document2' class='col-md-4 col-form-label'>"+display['passport_inner'][language]+"(MAX 2MB)  <span><i class='text-danger'>*</i></span></label><div class='col-md-8'><input name='document2' type='file' class='form-control' id='document2' required></div></div>");

        }else if (verify_type == 'driving_license') {
            $("#verify_field").html("<div class='form-group row'><label for='document1' class='col-md-4 col-form-label'>"+display['driving_license'][language]+"(MAX 2MB)  <span><i class='text-danger'>*</i></span></label><div class='col-md-8'><input name='document1' type='file' class='form-control' id='document1' required></div></div>");
            
        }else if (verify_type == 'nid') {
            $("#verify_field").html("<div class='form-group row'><label for='document1' class='col-md-4 col-form-label'>"+display['nid_with_selfie'][language]+"(MAX 2MB)  <span><i class='text-danger'>*</i></span></label><div class='col-md-8'><input name='document1' type='file' class='form-control' id='document1' required></div></div>");
            
        }else{
            $("#verify_field").html();

        }

    });

    $('#withdrawamount').on('keyup',function(){

        withdrawFee();

    });

    function withdrawFee(){
        var amount = document.forms['withdraw'].elements['amount'].value;
        var level  = document.forms['withdraw'].elements['level'].value;
        var csrf_test_name = document.forms['withdraw'].elements['csrf_test_name'].value;

        if (amount=="" || amount==0) {
            $('#fee').text("Fees is "+0);
        }
        if (amount!=""){
            $.ajax({
                'url': base_url+'shareholder/ajaxload/fees_load',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'level':level,'amount':amount,'csrf_test_name':csrf_test_name },
                'dataType': "JSON",
                'success': function(data) { 
                    if(data){
                        $('#fee').text("Fees is "+data.fees);                    
                    } else {
                        alert('Error!');
                    }  
                }
            });
        } 
    }

    $('#payment_method').on('change',function(){

        WalletId($(this).val());

    });

    function WalletId(method){
        
        var csrf_test_name = document.forms['withdraw'].elements['csrf_test_name'].value;
        if (method=='phone') { method = 'phone'; }

        $.ajax({
            url: base_url+'shareholder/ajaxload/walletid',
            type: 'POST', //the way you want to send data to your URL
            data: {'method': method,'csrf_test_name':csrf_test_name },
            dataType:'JSON',
            success: function(data) { 
               
                if(data){

                    $('[name="walletid"]').val(data.wallet_id);
                    $('button[type=submit]').prop('disabled', false);
                    $('#walletidis').text('Your Wallet Id Is '+data.wallet_id);
                    $('#coinwallet').html("");
                
                } else {

                    if(method=='coinpayment'){
                        $('button[type=submit]').prop('disabled', false);
                        $('#coinwallet').html("<label class='col-sm-4 col-form-label' for='amount'>Your Address<i class='text-danger'>*</i></label><div class='col-sm-8'><input class='form-control' name='walet_address' type='text' id='walet_address' required></div>");
                        $('#walletidis').text('');

                    }else{
                        $('#coinwallet').html("");
                        $('button[type=submit]').prop('disabled', true);
                        $('#walletidis').text('Your have no withdrawal account');
                    }
                }  
            }
        });
    }

    $('#confirm_transfer_btn').on('click',function(){
        var confirm_id = document.forms['verify'].elements['confirm_id'].value;
        sendtransferverifycode(confirm_id);
    });

    function sendtransferverifycode(id){

        var code = document.forms['verify'].elements['code'].value;
        var csrf_test_name = document.forms['verify'].elements['csrf_test_name'].value;

        swal({
            title: 'Please Wait......',
            type: 'warning',
            showConfirmButton: false,
            onOpen: function () {
                swal.showLoading()
              }
        });

        $.ajax({
            url: base_url+'shareholder/transfer/transfer_verify',
            type: 'POST', //the way you want to send data to your URL
            data: {'id': id,'code':code,'csrf_test_name':csrf_test_name },
            success: function(data) { 
                
                if(data!=""){

                    var url         = $(location).attr('href');
                    var segmentdata = url.replace(base_url,"");
                    var segments    = segmentdata.split( '/' );
                    var tx_id       = segments[3];

                    swal({
                        title: "Good job!",
                        text: display['your_custom_email_send_successfully'][language],
                        type: "success",
                        showConfirmButton: false,
                        timer: 1500,

                    });
                    window.location.href = base_url+"shareholder/transfer/transfer_recite/"+tx_id;

                }else {

                    swal({
                        title: "Wops!",
                        text: "Wrong verification code",
                        type: "error",
                        showConfirmButton: false,
                        timer: 1500
                    });

                }
                
            }
        });
    }

    $('#transfer_amount').on('keyup',function(){
        transferFee();
    });

    function transferFee(){
        
        var amount = document.forms['transfer_form'].elements['amount'].value;
        var level = document.forms['transfer_form'].elements['level'].value;
        var csrf_test_name = document.forms['transfer_form'].elements['csrf_test_name'].value;

        if (amount=="" || amount==0) {
            $('#fee').text("Fees is "+0);
        }
        if (amount!=""){
            $.ajax({
                'url': base_url+'shareholder/ajaxload/fees_load',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'level':level,'amount':amount,'csrf_test_name':csrf_test_name },
                'dataType': "JSON",
                'success': function(data) { 
                    if(data){
                        $('#fee').text("Fees is "+data.fees);                    
                    } else {
                        alert('Error!');
                    }  
                }
            });
        } 
    }

    $('#exchang_buy_app').on('click',function(){

        Exchange('exchange_buy','exceptionorbuy');

    });

    $('#exchang_sell_app').on('click',function(){

        Exchange('exchange_sell','exceptionorsell');
        
    });

    function Exchange(form_name,exceptionid)
    {
        var exchange,qty,rate;
        exchange = document.forms[form_name].elements['exchange'].value;
        qty      = document.forms[form_name].elements['qty'].value;
        rate     = document.forms[form_name].elements['rate'].value;
        var csrf_test_name = document.forms[form_name].elements['csrf_test_name'].value;

        $('#'+exceptionid).html("<font color='green'>Please Wait......</font>");

        if(qty=="" || rate==""){
            $('#'+exceptionid).html("<font color='red'>Please fill up required field!</font>");
        }
        else{

            $.ajax({
                'url': base_url+'shareholder/exchange',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'exchange':exchange,'qty':qty,'rate':rate,'csrf_test_name':csrf_test_name },
                'dataType': "JSON",
                'success': function(data) {

                    if(data.type==1){

                        if(form_name=="exchange_buy"){

                            $('#'+form_name)[0].reset();
                            $("#buytotal").html("");
                        }
                        else{
                            $('#'+form_name)[0].reset();
                            $("#selltotal").html("");
                        }

                        $('#'+exceptionid).html("<div class='alert alert-info alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+data.message+"</div>");
                    }else {

                        if(form_name=="exchange_buy"){

                            $('#'+form_name)[0].reset();
                            $("#buytotal").html("");
                        }
                        else{

                            $('#'+form_name)[0].reset();
                            $("#selltotal").html("");
                        }

                        $('#'+exceptionid).html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+data.message+"</div>");
                    }
                }
            });
        }
    }

    $('#buyrate').on('keyup',function(){
        exchange_fees('exchange_buy','buyfee');
    });

    $('#sellrate').on('keyup',function(){
        exchange_fees('exchange_sell','sellfee');
    });

    function exchange_fees(form_name,fees_id){
        
        var amount  = document.forms[form_name].elements['rate'].value;
        var qty     = document.forms[form_name].elements['qty'].value;
        amount      = amount*qty;
        var level   = document.forms[form_name].elements['level'].value;

        var csrf_test_name = document.forms[form_name].elements['csrf_test_name'].value;

        if (amount=="" || amount==0) {
            $('#'+fees_id).text(0);
        }
        if (amount!=""){
            $.ajax({
                'url': base_url+'shareholder/ajaxload/fees_load',
                'type': 'POST', //the way you want to send data to your URL
                'data': {'level':level,'amount':amount,'csrf_test_name':csrf_test_name },
                'dataType': "JSON",
                'success': function(data) { 
                    if(data){
                        $('#'+fees_id).text(data.fees);                    
                    } else {
                        alert('Error!');
                    }  
                }
            });
        } 
    }

    if(segment=="exchange"){
        done01();
        done02();
    }

    function done01() {
        setTimeout( function() {         
        sellavaible(); 
        done01();
        }, 10000);
    }

    function done02() {
        setTimeout( function() {         
        exchangehistoryupdates(); 
        done02();
        }, 10000);
    }

    //Historycal data load
    function exchangehistoryupdates() {
        $.getJSON(base_url+'shareholder/exchange/getExchangRate', function(data) {

            var lastprice;
            if (data.coinhistory) {

                var change = data.coinhistory.price_change_24h/data.coinhistory.last_price;
                var lastprice = parseFloat(parseFloat(data.coinhistory.last_price).toString()).toFixed(2);                
                var lastprice1 = $('#buyrate').val();
                var lastprice2 = $('#sellrate').val();

                if (lastprice1=='') {
                    $('#buyrate').val(lastprice);
                    $('#buytotal').val(lastprice*1);
                };
                if (lastprice2=='') {
                    $('#sellrate').val(lastprice);
                    $('#selltotal').val(lastprice*1);
                };


                if (change>0) {
                    $(".price_updown").html(parseFloat(parseFloat(data.coinhistory.last_price).toString()).toFixed(2)+' <i class="fa fa-arrow-up" aria-hidden="true"></i>');
                    $('.price_updown').addClass("positive");
                    $('.price_updown').removeClass("negative");
                }
                else if(change<0) {
                    $(".price_updown").html(parseFloat(parseFloat(data.coinhistory.last_price).toString()).toFixed(2)+' <i class="fa fa-arrow-down" aria-hidden="true"></i>');

                    $('.price_updown').addClass("negative");
                    $('.price_updown').removeClass("positive");
                }else{

                    $(".price_updown").html(parseFloat(parseFloat(data.coinhistory.last_price).toString()).toFixed(2)+' <i class="fa fa-arrow-up" aria-hidden="true"></i>');

                    $('.price_updown').addClass('positive');
                    $('.price_updown').removeClass('negative');
                }
            };
        });
    }

    function sellavaible(){
        $.getJSON(base_url+'shareholder/exchange/getSellavaible',function(data){

            $(".sell_avaiable").html(Number(data.sellavaiable).toFixed(2));
            $(".crypto_balance").html(Number(data.cryptobalance).toFixed(2));
        });
    }

    $.getJSON(base_url+'internal_api/getcoininfo', function(apidata){
        $("#buyqty, #buyrate").on("keyup", function(event) {
            event.preventDefault();

            var qty   = parseFloat($('#buyqty').val())||0;
            var rate  = parseFloat($('#buyrate').val())||0;
            var total = qty*rate;

            $("#buytotal").html("<span>"+apidata.pair_with + total + "</span>");

        });
        $("#sellqty, #sellrate").on("keyup", function(event) {
            event.preventDefault();

            var qty = parseFloat($('#sellqty').val())||0;
            var rate = parseFloat($('#sellrate').val())||0;

            var total = qty*rate;

            $("#selltotal").html("<span>"+apidata.pair_with + total + "</span>");

        });
    });

    if($('#exchangesChart').length){
        var chart = AmCharts.makeChart("exchangesChart", {
            "type": "stock",
            "theme": "black",
            "categoryAxesSettings": {
                "minPeriod": "mm"
            },
            "dataSets": [{
            "color": "#b0de09",
            "fieldMappings": [ {
                "fromField": "last_price",
                "toField": "value"
                }, {
                "fromField": "total_coin_supply",
                "toField": "volume"
            } ],
            "categoryField": "date",
              /**
               * data loader for data set data
               */
            "dataLoader": {
                "url": base_url+'shareholder/exchange/trade_charthistory',
                "format": "json",
                "showCurtain": true,
                "showErrors": false,
                "async": true,
                "reverse": true,
                "delimiter": ",",
                "useColumnNames": true
            },
            }],
            "panels": [ {
                "showCategoryAxis": false,
                "title": "Value",
                "percentHeight": 70,

                "stockGraphs": [ {
                  "id": "g1",
                  "valueField": "value",
                  "type": "smoothedLine",
                  "lineThickness": 2,
                  "bullet": "round"
                } ],

                "stockLegend": {
                  "valueTextRegular": " ",
                  "markerType": "none"
                }
              }, {
                "title": "Volume",
                "percentHeight": 30,
                "stockGraphs": [ {
                  "valueField": "volume",
                  "type": "column",
                  "cornerRadiusTop": 2,
                  "fillAlphas": 1
                } ],

                "stockLegend": {
                  "valueTextRegular": " ",
                  "markerType": "none"
                }
            } ],
            "chartScrollbarSettings": {
                "graph": "g1",
                "usePeriod": "10mm",
                "position": "bottom"
            },
            "chartCursorSettings": {
                "valueBalloonsEnabled": true
            },
            "periodSelector": {
            "position": "top",
            "dateFormat": "YYYY-MM-DD JJ:NN",
            "inputFieldWidth": 150,
            "periods": [ {
              "period": "hh",
              "count": 1,
              "label": "1 hour"
            }, {
              "period": "hh",
              "count": 2,
              "label": "2 hours"
            }, {
              "period": "hh",
              "count": 5,
              "selected": true,
              "label": "5 hour"
            }, {
              "period": "hh",
              "count": 12,
              "label": "12 hours"
            }, {
              "period": "MAX",
              "label": "MAX"
            } ]
          },
            "panelsSettings": {
                "usePrefixes": true
              },
            "export": {
                "enabled": true,
                "position": "bottom-right"
            }
        });
    }

    $.getJSON(base_url+'internal_api/getcoininfo', function(apidata){

        if($('#marketDepth').length){
            //Market Depth
            var chart = AmCharts.makeChart("marketDepth", {
                "type": "serial",
                "theme": "patterns",
                "dataLoader": {
                    "url": base_url+'shareholder/exchange/market_depth',
                    "format": "json",
                    "reload": 120,
                    "showErrors": false,
                    "postProcess": function (data) {

                        // Function to process (sort and calculate cummulative volume)
                        function processData(list, type, desc) {

                            // Convert to data points
                            for (var i = 0; i < list.length; i++) {
                                list[i] = {
                                    value: Number(list[i][0]),
                                    volume: Number(list[i][1])
                                };
                            }

                            // Sort list just in case
                            list.sort(function (a, b) {
                                if (a.value > b.value) {
                                    return 1;
                                } else if (a.value < b.value) {
                                    return -1;
                                } else {
                                    return 0;
                                }
                            });

                            // Calculate cummulative volume
                            if (desc) {
                                for (var i = list.length - 1; i >= 0; i--) {
                                    if (i < (list.length - 1)) {
                                        list[i].totalvolume = list[i + 1].totalvolume + list[i].volume;
                                    } else {
                                        list[i].totalvolume = list[i].volume;
                                    }
                                    var dp = {};
                                    dp["value"] = list[i].value;
                                    dp[type + "volume"] = list[i].volume;
                                    dp[type + "totalvolume"] = list[i].totalvolume;
                                    res.unshift(dp);
                                }
                            } else {
                                for (var i = 0; i < list.length; i++) {
                                    if (i > 0) {
                                        list[i].totalvolume = list[i - 1].totalvolume + list[i].volume;
                                    } else {
                                        list[i].totalvolume = list[i].volume;
                                    }
                                    var dp = {};
                                    dp["value"] = list[i].value;
                                    dp[type + "volume"] = list[i].volume;
                                    dp[type + "totalvolume"] = list[i].totalvolume;
                                    res.push(dp);
                                }
                            }

                        }

                        // Init
                        var res = [];
                        processData(data.bids, "bids", true);
                        processData(data.asks, "asks", false);

                        return res;
                    }
                },
                "graphs": [{
                        "id": "bids",
                        "fillAlphas": 0.2,
                        "lineAlpha": 1,
                        "lineThickness": 2,
                        "lineColor": "#0f0",
                        "type": "step",
                        "valueField": "bidstotalvolume",
                        "balloonFunction": balloon
                    }, {
                        "id": "asks",
                        "fillAlphas": 0.2,
                        "lineAlpha": 1,
                        "lineThickness": 2,
                        "lineColor": "#f00",
                        "type": "step",
                        "valueField": "askstotalvolume",
                        "balloonFunction": balloon
                    }, {
                        "lineAlpha": 0,
                        "fillAlphas": 0.2,
                        "lineColor": "#0f0",
                        "type": "column",
                        "clustered": false,
                        "valueField": "bidsvolume",
                        "showBalloon": true
                    }, {
                        "lineAlpha": 0,
                        "fillAlphas": 0.2,
                        "lineColor": "#f00",
                        "type": "column",
                        "clustered": false,
                        "valueField": "asksvolume",
                        "showBalloon": true
                    }],
                "categoryField": "value",
                "chartCursor": {},
                "balloon": {
                    "textAlign": "left"
                },
                "valueAxes": [{
                        "title": "Volume"
                    }],
                "categoryAxis": {
                    "title": "Price ("+apidata.pair_with+"/"+apidata.symbol+")",
                    "minHorizontalGap": 100,
                    "startOnAxis": true,
                    "showFirstLabel": false,
                    "showLastLabel": false
                },
                "export": {
                    "enabled": true
                }
            });
        }
        
    });

    function balloon(item, graph) {
        var txt;
        if (graph.id === "asks") {
            txt = "Ask: <strong>" + formatNumber(item.dataContext.value, graph.chart, 4) + "</strong><br />"
                    + "Total volume: <strong>" + formatNumber(item.dataContext.askstotalvolume, graph.chart, 4) + "</strong><br />"
                    + "Volume: <strong>" + formatNumber(item.dataContext.asksvolume, graph.chart, 4) + "</strong>";
        } else {
            txt = "Bid: <strong>" + formatNumber(item.dataContext.value, graph.chart, 4) + "</strong><br />"
                    + "Total volume: <strong>" + formatNumber(item.dataContext.bidstotalvolume, graph.chart, 4) + "</strong><br />"
                    + "Volume: <strong>" + formatNumber(item.dataContext.bidsvolume, graph.chart, 4) + "</strong>";
        }
        return txt;
    }

    function formatNumber(val, chart, precision) {
        return AmCharts.formatNumber(
            val,
            {
                precision: precision ? precision : chart.precision,
                decimalSeparator: chart.decimalSeparator,
                thousandsSeparator: chart.thousandsSeparator
            });
    }

    $('.copy').on('click',function(){
        myFunction();
    });

    $('.copy1').on('click',function(){
        myFunction1();
    });

    $('.copy2').on('click',function(){
        myFunction2();
    });

    //Copy text
    function myFunction() {
        var copyText = document.getElementById("copyed");
        copyText.select();
        document.execCommand("Copy");
    }

    function myFunction1() {
      var copyText = document.getElementById("copyed1");
      copyText.select();
      document.execCommand("Copy");
    }

    function myFunction2() {
      var copyText = document.getElementById("copyed2");
      copyText.select();
      document.execCommand("Copy");
    }
 
}(jQuery));