/**
 * Created by User on 26/4/2559.
 */
$(document).ready(function () {
    $("#hn").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) { //Enter keycode
            code = 9;
            return false;
        }
    });
    //change placeholder search
    $("input[name='visit_type']").change(function () {
        if ($(this).val() == "O") {
            $('#hn').attr('placeholder', 'ค้นหาด้วย HN');
        } else {
            $('#hn').attr('placeholder', 'ค้นหาด้วย AN');
        }
    });

    //////////// javascritp  for  other file on fancybox  call  /////////////
    ///// pt_history_form.php///////////


});
//  end of  document.reday/////////

// unblock when ajax activity stops
$(document).ajaxStop($.unblockUI);

function test() {
    $.ajax({ url: 'wait.php', cache: false });
}

$(document).ready(function() {
    $('#submit_date1').click(function() {
        $.blockUI();
        test();
    });
    $('#submit_date').click(function() {
        //alert('me');
        $.blockUI({ message: '<h1><img src="img/busy.gif" /> Just a moment...</h1>' });
        test();
    });
    $('.dem2').click(function() {
        $.blockUI({ message: '<h1><img src="img/busy.gif" /> Just a moment...</h1>' });
        test();
    });
    $('#pageDemo3').click(function() {
        $.blockUI({ css: { backgroundColor: '#f00', color: '#fff' } });
        test();
    });

    $('#pageDemo4').click(function() {
        $.blockUI({ message: $('#domMessage') });
        test();
    });
});

//--------------Cancel-------------
function btnCancel(){
    $.fancybox.close();
    //$("#flex1").flexReload();
}
///////////set icd10 name  to  input//////////
function set_icd10name(){
    //alert('me');

    var icd10t = $('#icd10').val();
    var icd10 = icd10t.toUpperCase();
    $('#icd10').val(icd10);
    var len_icd10 = icd10.length;
    //alert(len_icd10);

    if(len_icd10==0){
        //alert(len_icd10);
        var add_form = document.getElementById('add_dx');
        if (add_form != null) {
            document.getElementById('submit_save').disabled = false;
        }else{
            document.getElementById('submit_save').disabled = true;
        }
    }else{
        document.getElementById('submit_save').disabled = false;
    }
    if(len_icd10>0){
        //alert(len_icd10);
        $.getJSON('pt_edit_dx_data.php',{icd10:icd10}, function(data) {
            $.each(data, function(key,value){
                //alert(value.icd10name);
                $('#icd10name').val(value.icd10name);
            });
        });
    };
}
function calendar(){
    $('#visit_date').focus();
}
/*******************************************/

function cancelAjax(){
    $("#dlg").hide('800', "swing", function () { $("#bkg").fadeOut("500") });
};
$(document).ready(function() {
    var today = new Date();
    if(today.getDate() < 10){
        var dd = ('0'+today.getDate());
    }else{
        var dd = today.getDate();
    }
    if(today.getMonth() < 10){
        var mm = ('0'+(today.getMonth()+1)); //January is 0!
    }else{
        var mm = today.getMonth()+1; //January is 0!
    }


    var yyyy = today.getFullYear();
    $('#visit_date').focus();
    today = dd+'-'+mm+'-'+yyyy;
    $('#visit_date').val(today);

    $(function(){
        var keyStop = {
            8: ":not(input:text, textarea, input:file, input:password)", // stop backspace = back
            13: "input:text, input:password", // stop enter = submit

            end: null
        };
        $(document).bind("keydown", function(event){
            var selector = keyStop[event.which];

            if(selector !== undefined && $(event.target).is(selector)) {
                event.preventDefault(); //stop event
            }
            return true;
        });
    });


    /////////////////////////////  function  on click submit_date///////////////////////////////////////////////////
    $("input#submit_date").click(function(event){
        $('#hn').val('');

        var radios_visit_type = document.getElementsByName("visit_type");
        for (var i = 0; i < radios_visit_type.length; i++) {
            if (radios_visit_type[i].checked) {
                var visit_type = (radios_visit_type[i].value);
                break;
            }
        }
        //alert(visit_type);
        //creat  page  number  ////////////////////////////////////
        var row_per_page = 10;
        var visit_date = $('#visit_date').val();
        //alert(visit_date+";"+visit_type);

        var total_row = new Array();
        // $(".content2").html("หน้าที่ 1 / "+(total_row / row_per_page);

        $("#curpage").val(1);
        $.getJSON('pt_visit_data.php',{visit_date:visit_date,visit_type:visit_type,limit:0}, function(data) {
            //  loop push array creat  numrows  to  page nummber//////////

            $.each(data, function(key,value) {
                total_row.push(value.total_rows);
            });
            var numrow = (total_row[1]);

            $('.dem2').bootpag({
                total: Math.ceil(numrow/row_per_page),
                page: 1,
                maxVisible: 10,
                leaps: true,
                firstLastUse: true,
                first: '←',
                last: '→',
                wrapClass: 'pagination',
                activeClass: 'active',
                disabledClass: 'disabled',
                nextClass: 'next',
                prevClass: 'prev',
                lastClass: 'last',
                firstClass: 'first'
            }).on("page", function(event, num){
                $(".content2").html("Page " + num); // or some ajax content loading...
            });
            //  end create  page number///////////
            $('tbody#my_news tr').remove();
            var i = 1;
            $.each(data, function(key,value) {
                var id_dxx = value.id_dx;


                $("tbody#my_news").append("<tr><td style='text-align: center'>"+value.numrecord+"</td>" +
                    "<td>"+value.ptname+"</td>" +
                    "<td>"+value.hn+"</td>" +
                    "<td>"+value.an+"</td>" +
                    "<td>"+value.vstdttm+"</td>" +
                    "<td id='department'>"+value.department+"</td>" +
                    "<td id='cc'>"+value.cc+"<div id='pi'>PI::"+value.pi+"</div></td>" +
                    "<td id='show_pi'>show</td>" +
                    "<td class='dx' id='"+id_dxx+"'>"+value.pdx+"</td>" +
                    "<td class='dx' id='"+value.id1+"'>"+value.dx1+"</td>" +
                    "<td class='dx' id='"+value.id2+"'>"+value.dx2+"</td>" +
                    "<td class='dx' id='"+value.id3+"'>"+value.dx3+"</td>" +
                    "<td class='dx' id='"+value.id4+"'>"+value.dx4+"</td>" +
                    "<td class='dx' id='"+value.id5+"'>"+value.dx5+"</td>" +
                    "<td class='dx_new'  id='"+value.vn+"'><i class='fa fa-plus dx'></i></td>" +
                    "<td class='' id='"+value.hn+","+value.vn+"' onclick='showEMR("+value.hn+");'><i class='fa fa-user dx' style='color: #0089CB'></i></td>" +
                    "</tr>");
                i++;
            });

            ///////////click  to show present illnes  //////////
            $("td#show_pi").click(function(){
                var this_td = this;
                var check_status = this.innerText;

                $(this).parent().find('div#pi').slideToggle("slow");
                if(check_status == 'show'){
                    this_td.innerText = "hide";
                }else{
                    this_td.innerText = "show";
                }
            });
            $("td#show_pi").mouseover(function(){
                var this_td = this;
                $(this).parent().find('div#pi').slideToggle("slow");
                this_td.innerText = "hide";
            });
            $("td#show_pi").mouseout(function(){
                $(this).parent().find('div#pi').slideToggle("slow");
                var this_td = this;
                this_td.innerText = "show";
            });
            /////////////click dx  to  edit/////////////////////////////////
            var dx = $('td.dx');
            var len_dx = dx.length;
            $("td.dx_p,td.dx,td.dx_all,td.history,.dx_new").click(function(event){
                var id_dx =  this.id;


                var class_dx = this.className;
                //alert(class_dx);
                //alert(id_dx);
                if(id_dx!=''){
                    var pdx = this.innerText;
                    var this_td = this;
                    var this_tr = this_td.parentNode.rowIndex;

                    if(class_dx=='dx'){

                        var link_page = 'pt_edit_dx_form.php?id_dx='+id_dx+'&&pdx='+pdx+'&&visit_type='+visit_type;
                        var modal = false;
                    }else if(class_dx=='dx_new'){
                        var link_page = 'pt_add_dx_form.php?id_dx='+id_dx+'&&visit_type='+visit_type;
                        var modal = false;
                    }else if(class_dx=='history'){
                        var link_page = 'pt_history_form.php?hn='+id_dx;
                        var modal = true;
                    }else{
                        var link_page = 'pt_edit_dx_all_form.php?id_dx='+id_dx;
                        var modal = false;
                    }
                    //alert(visit_type);
                    $.fancybox({'href'	: link_page,//link_page+id_dx+'&&pdx='+pdx+'',
                        'width' : 1000,
                        'height' : 1000,
                        'modal' : modal,
                        //'showCloseButton' : true,
                        'autoSize' : false,
                        'transitionIn'  :   'elastic',
                        'transitionOut' :   'elastic',
                        'speedIn'    :  600,
                        'speedOut'   :  100,
                        'overlayShow'   :   false,
                        'closeBtn': false,
                        'hideOnOverlayClick' : false, // prevents closing clicking OUTSIE fancybox
                        'hideOnContentClick' : false, // prevents closing clicking INSIDE fancybox
                        'enableEscapeButton' : true,  // prevents closing pressing ESCAPE key
                        'autoCenter': true, // and not 'true'
                        beforeShow: function () {
                            /* this.width = $(this.element).data("width") ? $(this.element).data("width") : null;
                             this.height = $(this.element).data("height") ? $(this.element).data("height") : null;*/
                        },
                        afterShow : function() {
                            $('.fancybox-skin').append('<a title="Close" class="fancybox-item fancybox-close" href="javascript:jQuery.fancybox.close();"></a>');},
                        onComplete : function() {
                            if(class_dx!='history'){
                                var old_dx = this_td.innerText;
                                $('#change_dx').val(old_dx);
                                $("input#icd10").focus().select();
                            }
                            if(class_dx=='history'){
                                //alert(this.height);
                                var newheight = $(window).height();
                                // alert(newheight);
                                //var newHeightStr = newheight + 'px';
                                //this.height = newheight-100;
                                //this.height = (newheight-100) +'px';
                                document.getElementById('me').style.height= (newheight-100) +'px';
                                document.getElementById('vstdate_h').style.height= (newheight-120) +'px';
                                document.getElementById('content_history').style.height= (newheight-120) +'px';
                                $.fancybox.center;
                                //  auto click  to element
                                $('td#vstdate:first').trigger('click');
                            }
                        },
                        afterClose: function(){
                            // $("body").css({'overflow-y':'visible'});
                        },
                        onClosed : function(){
                            var change_dx = $('#change_dx').val();
                            if(class_dx=='dx'){
                                this_td.innerText = $('#change_dx').val();
                                if(change_dx ==''){
                                    this_td.id = '';
                                }
                            }else{
                                var dx_str = $('#change_dx').val();
                                var dx_array = dx_str.split(',');
                                var dx_array_len = dx_array.length;
                                var table = document.getElementById("mytable");
                                var row = table.rows[this_tr] ;
                                var start_dx = 6;
                                var num_cell = row.cells.length ;
                                var n = 0;
                                for (var i = start_dx; i < num_cell; i++) {
                                    var dx_status = row.cells[i].innerText;
                                    if ( dx_status == "" && n  <= dx_array_len-1 ) {
                                        row.cells[i].innerText =  dx_array[n];
                                        row.cells[i].id = "vn"+id_dx;
                                        n++;
                                    }
                                }
                            }
                        }
                    });
                    ////  use ajax to sent  $_get  to  other page///////////////
                    /*if(class_dx=='dx'){
                     url: "pt_edit_dx_form.php"
                     }else{
                     url: "pt_add_dx_form.php"
                     }*/
                    if(class_dx=='dx'){
                        url: 'pt_edit_dx_form.php'
                    }else if(class_dx=='dx_new'){
                        url: 'pt_add_dx_form.php'
                    }else if(class_dx=='history'){
                        url: 'pt_history_form.php'
                    }else{
                        url: 'pt_edit_dx_all_form.php'
                    }
                    $.ajax({
                        type: "POST",
                        dataType: "html",
                        url: url,
                        headers: {
                            'Cache-Control': 'no-cache, no-store, must-revalidate',
                            'Pragma': 'no-cache',
                            'Expires': '0'
                        },
                        cache: false,
                        data: id_dx
                    });
                };
            });
            /////////////// enc of  edit  dx/////////////////
            ////  function  on click  page number////////////////////


            //////End of  funtion on click  page  number ///////////////
        });
    });
    /////////////////////////////  End of function  on click submit_date///////////////////////////////////////////////////

});

$('.dem2').on('page', function(event, num){
    var hn = $('#hn').val();
    if(hn == ''){
        var radios_visit_type = document.getElementsByName("visit_type");

        for (var i = 0; i < radios_visit_type.length; i++) {
            if (radios_visit_type[i].checked) {
                var visit_type = (radios_visit_type[i].value);
                break;
            }
        }
        var row_per_page = 10;
        var visit_date = $('#visit_date').val();
        var total_row = new Array();
        $("#curpage").val(num);
        var limit = (num-1) * row_per_page;

        $.getJSON('pt_visit_data.php',{visit_date:visit_date,visit_type:visit_type,limit:limit}, function(data) {
            //  loop push array creat  numrows  to  page nummber//////////
            //alert(num);
            $.each(data, function(key,value) {
                total_row.push(value.total_rows);
            });
            var numrow = (total_row[1]);
            var all_page = Math.ceil(numrow/row_per_page);
            var maxVisible= (all_page - row_per_page);
            //alert(all_page);
            //alert(maxVisible);
            //alert(num);
            if(maxVisible = row_per_page){
                maxVisibleP = row_per_page;
            }else{
                maxVisibleP = all_page ;
            }
            //var row_per_page = 10;
            $(".content2").html("หน้าที่ "+ num +"  / "+Math.ceil((numrow/row_per_page)));
            $(".total").html("จำนวนผู้รับบริการในช่วงเวลาที่เลือก  "+numrow+"   ราย");
            $('.dem2').bootpag({
                total: Math.ceil(numrow/row_per_page),
                page: num,
                maxVisible:10 //Math.ceil(numrow/row_per_page)

            })
            //  end create  page number///////////
            $('tbody#my_news tr').remove();
            var i = 1;
            $.each(data, function(key,value) {
                $("tbody#my_news").append("<tr><td style='text-align: center'>"+value.numrecord+"</td>" +
                    "<td>"+value.ptname+"</td>" +
                    "<td>"+value.hn+"</td>" +
                    "<td>"+value.an+"</td>" +
                    "<td>"+value.vstdttm+"</td>" +
                    "<td id='department'>"+value.department+"</td>" +
                    "<td id='cc'>"+value.cc+"<div id='pi'>PI::"+value.pi+"</div></td>" +
                    "<td id='show_pi'>show</td>" +
                    "<td class='dx' id='"+value.id_dx+"'>"+value.pdx+"</td>" +
                    "<td class='dx' id='"+value.id1+"'>"+value.dx1+"</td>" +
                    "<td class='dx' id='"+value.id2+"'>"+value.dx2+"</td>" +
                    "<td class='dx' id='"+value.id3+"'>"+value.dx3+"</td>" +
                    "<td class='dx' id='"+value.id4+"'>"+value.dx4+"</td>" +
                    "<td class='dx' id='"+value.id5+"'>"+value.dx5+"</td>" +
                    //"<td class='dx_all'  id='"+value.vn+"'><i class='fa fa-child'></i></td>" +
                    "<td class='dx_new'  id='"+value.vn+"'><i class='fa fa-plus dx'></i></td>" +
                    "<td class='' id='"+value.hn+","+value.vn+"' onclick='showEMR("+value.hn+");'><i class='fa fa-user dx' style='color: #0089CB'></i></td>" +
                    "</tr>");
                i++;
            });

            ///////////click  to show present illnes  //////////
            $("td#show_pi").click(function(){
                var this_td = this;
                var check_status = this.innerText;

                $(this).parent().find('div#pi').slideToggle("slow");
                if(check_status == 'show'){
                    this_td.innerText = "hide";
                }else{
                    this_td.innerText = "show";
                }
            });
            $("td#show_pi").mouseover(function(){
                var this_td = this;
                $(this).parent().find('div#pi').slideToggle("slow");
                this_td.innerText = "hide";
            });
            $("td#show_pi").mouseout(function(){
                $(this).parent().find('div#pi').slideToggle("slow");
                var this_td = this;
                this_td.innerText = "show";
            });
            /////////////click dx  to  edit/////////////////////////////////
            var dx = $('td.dx');
            var len_dx = dx.length;
            $("td.dx_p,td.dx,td.dx_all,td.history,.dx_new").click(function(event){
                var id_dx =  this.id;
                var class_dx = this.className;
                //alert(class_dx);
                if(id_dx!=''){
                    var pdx = this.innerText;
                    var this_td = this;
                    var this_tr = this_td.parentNode.rowIndex;
                    if(class_dx=='dx'){
                        var link_page = 'pt_edit_dx_form.php?id_dx='+id_dx+'&&pdx='+pdx+'&&visit_type='+visit_type;
                        var modal = false;
                    }else if(class_dx=='dx_new'){
                        var link_page = 'pt_add_dx_form.php?id_dx='+id_dx+'&&visit_type='+visit_type;
                        var modal = false;
                    }else if(class_dx=='history'){
                        var link_page = 'pt_history_form.php?hn='+id_dx;
                        var modal = true;
                    }else{
                        var link_page = 'pt_edit_dx_all_form.php?id_dx='+id_dx;
                        var modal = false;
                    }
                    $.fancybox({'href'	: link_page,//link_page+id_dx+'&&pdx='+pdx+'',
                        'width' : 1000,
                        'height' : 1000,
                        'modal' :  modal,
                        //'showCloseButton' : true,
                        'autoSize' : false,
                        'transitionIn'  :   'elastic',
                        'transitionOut' :   'elastic',
                        'speedIn'    :  600,
                        'speedOut'   :  100,
                        'overlayShow'   :   false,
                        'closeBtn': false,
                        'hideOnOverlayClick' : false, // prevents closing clicking OUTSIE fancybox
                        'hideOnContentClick' : false, // prevents closing clicking INSIDE fancybox
                        'enableEscapeButton' : true,  // prevents closing pressing ESCAPE key
                        'autoCenter': true, // and not 'true'
                        beforeShow: function () {
                            /* this.width = $(this.element).data("width") ? $(this.element).data("width") : null;
                             this.height = $(this.element).data("height") ? $(this.element).data("height") : null;*/
                        },
                        afterShow : function() {
                            $('.fancybox-skin').append('<a title="Close" class="fancybox-item fancybox-close" href="javascript:jQuery.fancybox.close();"></a>');},
                        onComplete : function() {
                            if(class_dx!='history'){
                                var old_dx = this_td.innerText;
                                $('#change_dx').val(old_dx);
                                $("input#icd10").focus().select();
                            }
                            if(class_dx=='history'){
                                //alert(this.height);
                                var newheight = $(window).height();
                                // alert(newheight);
                                //var newHeightStr = newheight + 'px';
                                //this.height = newheight-100;
                                //this.height = (newheight-100) +'px';
                                document.getElementById('me').style.height= (newheight-100) +'px';
                                document.getElementById('vstdate_h').style.height= (newheight-120) +'px';
                                document.getElementById('content_history').style.height= (newheight-120) +'px';
                                $.fancybox.center;
                                //  auto click  to element
                                $('td#vstdate:first').trigger('click');
                            }
                        },
                        afterClose: function(){
                            // $("body").css({'overflow-y':'visible'});
                        },
                        onClosed : function(){
                            var change_dx = $('#change_dx').val();
                            if(class_dx=='dx'){
                                this_td.innerText = $('#change_dx').val();
                                if(change_dx ==''){
                                    this_td.id = '';
                                }
                            }else{
                                var dx_str = $('#change_dx').val();
                                var dx_array = dx_str.split(',');
                                var dx_array_len = dx_array.length;
                                var table = document.getElementById("mytable");
                                var row = table.rows[this_tr] ;
                                var start_dx = 6;
                                var num_cell = row.cells.length ;
                                var n = 0;
                                for (var i = start_dx; i < num_cell; i++) {
                                    var dx_status = row.cells[i].innerText;
                                    if ( dx_status == "" && n  <= dx_array_len-1 ) {
                                        row.cells[i].innerText =  dx_array[n];
                                        row.cells[i].id = "vn"+id_dx;
                                        n++;
                                    }
                                }
                            }
                        }
                    });
                    ////  use ajax to sent  $_get  to  other page///////////////
                    if(class_dx=='dx'){
                        url: 'pt_edit_dx_form.php'
                    }else if(class_dx=='dx_new'){
                        url: 'pt_add_dx_form.php'
                    }else if(class_dx=='history'){
                        url: 'pt_history_form.php'
                    }else{
                        url: 'pt_edit_dx_all_form.php'
                    }
                    $.ajax({
                        type: "POST",
                        dataType: "html",
                        url: url,
                        headers: {
                            'Cache-Control': 'no-cache, no-store, must-revalidate',
                            'Pragma': 'no-cache',
                            'Expires': '0'
                        },
                        cache: false,
                        data: id_dx
                    });
                };
            });
            /////////////// enc of  edit  dx/////////////////
            ////  function  on click  page number////////////////////


            //////End of  funtion on click  page  number ///////////////
        });

    };
});
/////////////end of ready function///////////////////////////////////////////
//----------------------Search  patient-----------------------------------
$(document).keyup(function (e) {
    if ($("#hn").is(":focus") && (e.keyCode == 13)) {
        search_by_hn();
    }
});

function notAssign_date() {
    var checkbox = document.getElementById("assign_date");
    var textBox = document.getElementById("visit_date");

    if(checkbox.checked) {
        textBox.value = "";
    }else{
        var today = new Date();
        if(today.getDate() < 10){
            var dd = ('0'+today.getDate());
        }else{
            var dd = today.getDate();
        }
        if(today.getMonth() < 10){
            var mm = ('0'+(today.getMonth()+1)); //January is 0!
        }else{
            var mm = today.getMonth()+1; //January is 0!
        }
        var yyyy = today.getFullYear();
        today = dd+'-'+mm+'-'+yyyy;
        textBox.value = today ;
    }
}

function search_by_hn(){
    //$("#visit_date").val('');
    var hn = $('#hn').val();

    var visit_date = $('#visit_date').val();

    //alert(hn);
    var radios_visit_type = document.getElementsByName("visit_type");



    if( hn !=''){
        //alert(hn);
        //var  row_per_page = 5;
        //var total_row = new Array();
        $.getJSON('pt_visit_data_hn.php',{hn:hn,visit_date:visit_date,limit:0}, function(data) {

            $('.dem2').bootpag({
                total: 1,
                page: 1,
                maxVisible: 1
            });
            $(".content2").html("");
            $(".total").html("");
            $('tbody#my_news tr').remove();
            $.each(data, function(key,value) {
                //alert(value.vn);
                if (typeof value.id_dx === 'undefined' || value.id_dx === null) {
                    //alert(value.vn);
                    var id_dxx = value.vn;
                }else{
                    var id_dxx = value.id_dx;
                }
                if(value.an > 0){
                    var visit_type = 'I';
                }else{
                    var visit_type = 'O';
                }

                $("tbody#my_news").append("<tr id='"+visit_type+"' ><td style='text-align: center'>"+value.numrecord+"</td>" +
                    "<td>"+value.ptname+"</td>" +
                    "<td>"+value.hn+"</td>" +
                    "<td>"+value.an+"</td>" +
                    "<td>"+value.vstdttm+"</td>" +
                    "<td id='department'>"+value.department+"</td>" +
                    "<td id='cc'>"+value.cc+"<div id='pi'>PI::"+value.pi+"</div></td>" +
                    "<td id='show_pi'>show</td>" +
                    "<td class='dx' id='"+id_dxx+"'>"+value.pdx+"</td>" +
                    "<td class='dx' id='"+value.id1+"'>"+value.dx1+"</td>" +
                    "<td class='dx' id='"+value.id2+"'>"+value.dx2+"</td>" +
                    "<td class='dx' id='"+value.id3+"'>"+value.dx3+"</td>" +
                    "<td class='dx' id='"+value.id4+"'>"+value.dx4+"</td>" +
                    "<td class='dx' id='"+value.id5+"'>"+value.dx5+"</td>" +
                    // "<td class='dx_all'  id='"+value.vn+"'><i class='fa fa-child'></i></td>" +
                    "<td class='dx_new'  id='"+value.vn+","+visit_type+"'><i class='fa fa-plus dx'></i></td>" +
                    "<td class='' id='"+value.hn+","+value.vn+"' onclick='showEMR("+value.hn+");'><i class='fa fa-user dx' style='color: #0089CB'></i></td>" +
                    "</tr>"
                );
                //$("#visit_date").val(value.datevisit);

            });
            ///////////click  to show present illnes  //////////
            $("td#show_pi").click(function(){
                var this_td = this;
                var check_status = this.innerText;

                $(this).parent().find('div#pi').slideToggle("slow");
                if(check_status == 'show'){
                    this_td.innerText = "hide";
                }else{
                    this_td.innerText = "show";
                }
            });
            $("td#show_pi").mouseover(function(){
                var this_td = this;
                $(this).parent().find('div#pi').slideToggle("slow");
                this_td.innerText = "hide";
            });
            $("td#show_pi").mouseout(function(){
                $(this).parent().find('div#pi').slideToggle("slow");
                var this_td = this;
                this_td.innerText = "show";
            });
            /////////////click dx  to  edit/////////////////////////////////

            var dx = $('td.dx');
            var len_dx = dx.length;
            $("td.dx_p,td.dx,td.dx_all,td.history,td.dx_new").click(function(event){
                var id_dx =  this.id;
                var class_dx = this.className;
                var visit_type = this.parentNode.id ;
                //alert(id_dx);
                if(id_dx!=''){
                    var pdx = this.innerText;
                    var this_td = this;
                    var this_tr = this_td.parentNode.rowIndex;
                    if(class_dx=='dx'){
                        var link_page = 'pt_edit_dx_form.php?id_dx='+id_dx+'&&pdx='+pdx+'&&visit_type='+visit_type;
                        var modal = false;
                    }else if(class_dx=='dx_new'){
                        var link_page = 'pt_add_dx_form.php?id_dx='+id_dx;
                        var modal = false;
                    }else if(class_dx=='history'){
                        var link_page = 'pt_history_form.php?hn='+id_dx;
                        var modal = true;
                    } else{
                        var link_page = 'pt_edit_dx_all_form.php?id_dx='+id_dx;
                        var modal = false;
                    }
                    $.fancybox({'href'	: link_page,//link_page+id_dx+'&&pdx='+pdx+'',
                        'width' : 1000,
                        'height' : 1000,
                        'modal' :  modal,
                        //'showCloseButton' : true,
                        'autoSize' : false,
                        'transitionIn'  :   'elastic',
                        'transitionOut' :   'elastic',
                        'speedIn'    :  600,
                        'speedOut'   :  100,
                        'overlayShow'   :   false,
                        'closeBtn': false,
                        'hideOnOverlayClick' : false, // prevents closing clicking OUTSIE fancybox
                        'hideOnContentClick' : false, // prevents closing clicking INSIDE fancybox
                        'enableEscapeButton' : true,  // prevents closing pressing ESCAPE key
                        'autoCenter': true, // and not 'true'
                        beforeShow: function () {
                            /* this.width = $(this.element).data("width") ? $(this.element).data("width") : null;
                             this.height = $(this.element).data("height") ? $(this.element).data("height") : null;*/
                        },
                        afterShow : function() {
                            $('.fancybox-skin').append('<a title="Close" class="fancybox-item fancybox-close" href="javascript:jQuery.fancybox.close();"></a>');},
                        onComplete : function() {
                            if(class_dx!='history'){
                                var old_dx = this_td.innerText;
                                $('#change_dx').val(old_dx);
                                $("input#icd10").focus().select();
                            }
                            if(class_dx=='history'){
                                //alert(this.height);
                                var newheight = $(window).height();
                                // alert(newheight);
                                //var newHeightStr = newheight + 'px';
                                //this.height = newheight-100;
                                //this.height = (newheight-100) +'px';
                                document.getElementById('me').style.height= (newheight-100) +'px';
                                document.getElementById('vstdate_h').style.height= (newheight-120) +'px';
                                document.getElementById('content_history').style.height= (newheight-120) +'px';
                                $.fancybox.center;
                                //  auto click  to element
                                $('td#vstdate:first').trigger('click');
                            }
                        },
                        onClosed : function(){
                            var change_dx = $('#change_dx').val();
                            if(class_dx=='dx'){
                                this_td.innerText = $('#change_dx').val();
                                if(change_dx ==''){
                                    this_td.id = '';
                                }
                            }else{
                                var dx_str = $('#change_dx').val();
                                var dx_array = dx_str.split(',');
                                var dx_array_len = dx_array.length;
                                var table = document.getElementById("mytable");
                                var row = table.rows[this_tr] ;
                                var start_dx = 6;
                                var num_cell = row.cells.length ;
                                var n = 0;
                                for (var i = start_dx; i < num_cell; i++) {
                                    var dx_status = row.cells[i].innerText;
                                    if ( dx_status == "" && n  <= dx_array_len-1 ) {
                                        row.cells[i].innerText =  dx_array[n];
                                        row.cells[i].id = "vn"+id_dx;
                                        n++;
                                    }
                                }
                            }
                        }
                    });
                    ////  use ajax to sent  $_get  to  other page///////////////
                    if(class_dx=='dx'){
                        url: 'pt_edit_dx_form.php'
                    }else if(class_dx=='dx_new'){
                        url: 'pt_add_dx_form.php'
                    }else if(class_dx=='history'){
                        url: 'pt_history_form.php'
                    }else{
                        url: 'pt_edit_dx_all_form.php'
                    }
                    $.ajax({
                        type: "POST",
                        dataType: "html",
                        url: url,
                        headers: {
                            'Cache-Control': 'no-cache, no-store, must-revalidate',
                            'Pragma': 'no-cache',
                            'Expires': '0'
                        },
                        cache: false
                        //data: id

                    });
                };
            });
            /////////////// enc of  edit  dx/////////////////
        });
    }else{
        alert('คุณยังไม่ได้ระบุวันที่ หรือ ไม่ได้ใส่ HN')

    }
};
/*****************************/

//create alert  dialog  myAlert name global
alertify.myAlert || alertify.dialog('myAlert',function factory(){
    return {
        main:function(content){
            this.setContent(content);
        },
        setup:function(){
            return {
                options:{
                    modal:false,
                    basic:true,
                    maximizable:true,
                    resizable:false,
                    padding:false,
                    transition: 'fade',
                    autoReset: false

                }
            };
        }
    };
});
function showEMR(hn){
    $.ajax({
        url: 'pt_history_form.php?hn='+hn,
        headers: {
            'Cache-Control': 'no-cache, no-store, must-revalidate',
            'Pragma': 'no-cache',
            'Expires': '0'
        },
        cache: false
    }).success(function(data){
        alertify.myAlert(data).set('resizable',true).resizeTo('90%','85%');
        $('td#vstdate:first').trigger('click');
    }).error(function(){
        alertify.error('Errro loading external file.');
    });
}