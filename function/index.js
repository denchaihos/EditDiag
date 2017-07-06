/**
 * Created by User on 13/1/2559.
 */

/*********************dropdown menu  on hover show effect***********************************/
$('ul.nav li.dropdown').hover(function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
}, function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
});
function resetCSS () {
    $("#toggleCSSdefault").attr("href", "css/alertify.default.css");
    $("#toggleCSSbootstrap").attr("href", "css/alertify.bootstrap3.css");
    alertify.set({
        labels : {
            ok     : "OK",
            cancel : "Cancel"
        },
        delay : 5000,
        buttonReverse : false,
        buttonFocus   : "ok"
    });
}
function logout(){
    var e = window.event,
        btn = e.target || e.srcElement;

    alertify.confirm("คุณต้องการออกจากระบบ ?", function (e) {
        if (e) {
            $.ajax({
                type: 'post',
                url: "logout.php",
                data: {vaccation_id:1},
                success: function(data){
                    if (data == "erro") {
                        alert("erro")
                    } else {
                        alertify.alert(data);
                        location.reload();
                    }
                }
            });
        }else {
            alertify.error('ยกเลิกกระบวนการ');
        }
    });
}
$(document).ajaxStop($.unblockUI);

function waitPage() {
    $.ajax({ url: 'wait.php', cache: false });
}


function datepickerAdd(e){
    e = e || window.event;
    e = e.target || e.srcElement;
    if (e.nodeName === 'INPUT') {
        var d = new Date();
        var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);
        var elId = "#"+e.id;

        $(elId).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            isBuddhist: true,
            defaultDate: toDay,
            buttonImageOnly: false,
            showOn: 'focus',
            closeText: 'Clear',
            showButtonPanel: true,
            setDate: null,
            dayNames: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
            dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
            monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
            monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
            onClose:function(){
                var event = arguments.callee.caller.caller.arguments[0];
                // If "Clear" gets clicked, then really clear it
                if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
                    $(this).val('');
                }
            }

        });
        $('body').trigger('click');
        $(elId).focus();
    }
}

//override the existing _goToToday functionality
$.datepicker._gotoTodayOriginal = $.datepicker._gotoToday;
$.datepicker._gotoToday = function(id) {
    // now, optionally, call the original handler, making sure
    //  you use .apply() so the context reference will be correct
    /*$.datepicker._gotoTodayOriginal.apply(this, [id]);
     console.log(this);
     $.datepicker._selectDate.apply(this, [id]);*/
    var target = $(id);

    var inst = this._getInst(target[0]);

    if (this._get(inst, 'gotoCurrent') && inst.currentDay) {
        inst.selectedDay = inst.currentDay;
        inst.drawMonth = inst.selectedMonth = inst.currentMonth;
        inst.drawYear = inst.selectedYear = (inst.currentYear)+543;
    }
    else {
        var date = new Date();
        inst.selectedDay = date.getDate();
        inst.drawMonth = inst.selectedMonth = date.getMonth();
        inst.drawYear = inst.selectedYear = (date.getFullYear())+543;
    }
    this._notifyChange(inst);
    this._adjustDate(target);
    /* ### CUSTOMIZATION: Actually select the current date, don't just show it ### */
    this._setDateDatepicker(target, new Date());
    this._selectDate(id, this._getDateDatepicker(target));
};
function resetDatepicker(el){
    var elId = el.getAttribute("data-type");
    //alert("The  is a " + elId + ".");
    $(elId).val("");
}




