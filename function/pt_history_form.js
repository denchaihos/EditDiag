/**
 * Created by User on 14/7/2559.
 */

function age(dob, today) {
    var today = today || new Date(),
        result = {
            years: 0,
            months: 0,
            days: 0,
            toString: function() {
                return (this.years ? this.years + ' ปี ' : '')
                    + (this.months ? this.months + ' เดือน ' : '')
                    + (this.days ? this.days + ' วัน' : '');
            }
        };
    result.months =
        ((today.getFullYear() * 12) + (today.getMonth() + 1))
            - ((dob.getFullYear() * 12) + (dob.getMonth() + 1));
    if (0 > (result.days = today.getDate() - dob.getDate())) {
        var y = today.getFullYear(), m = today.getMonth();
        m = (--m < 0) ? 11 : m;
        result.days +=
            [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m]
                + (((1 == m) && ((y % 4) == 0) && (((y % 100) > 0) || ((y % 400) == 0)))
                ? 1 : 0);
        --result.months;
    }
    result.years = (result.months - (result.months % 12)) / 12;
    result.months = (result.months % 12);
    return result;
}

$('body').on('click', '#vstdate', function(){
    var vn = $(this).find('input').val();
    $('td#vstdate').removeClass('td_current');
    $(this).addClass('td_current');
    //cleare old data/////
    $('#age').text('') ;
    $('#bw').text('') ;
    $('#height').text('');
    $('#waist_cm').text('');
    $('#tt').text('') ;
    $('#bmi').text('');
    $('#pr').text('');
    $('#rr').text('') ;
    $('#sbp').text('');
    $('#cc_h').text('');
    $('#pe_h').text('');
    $('#pi_h').text('');
    $('#pdx_h').text('');
    $('#dx_other_h').text('')
    var history_vstdate = this.innerText;
    $('span#dateshow').text(history_vstdate);

    //var hn = $('#hnn').val();
    $.getJSON('pt_history_data.php',{vn:vn}, function(data) {
        $.each(data, function(key,value){
            $('#age').text(age(new Date(value.brthdate),new Date(value.vstdttm))) ;
            $('#bw').text(value.bw+" ก.ก.") ;
            $('#height').text(value.height+" ซ.ม.");
            $('#waist_cm').text(value.waist_cm+" cc.");
            $('#tt').text(value.tt+" ก.ก.") ;
            $('#bmi').text(value.bmi+" ");
            $('#pr').text(value.pr+" ครั้ง/นาที");
            $('#rr').text(value.rr+" ครั้ง/นาที") ;
            $('#sbp').text(value.sbp+" / "+value.dbp+" มม.ปรอท");
            $('#cc_h').text(value.cc);
            $('#pe_h').text(value.pe);
            $('#pi_h').text(value.pi);
            $('#pdx_h').text(value.pdx);
            $('#dx_other_h').text('');
            $('#dx_other_h').append("<div>"+value.dx1+"</div><div>"+value.dx2+"</div><div>"+value.dx3+"</div><div>"+value.dx4+"</div><div>"+value.dx5+"</div>");
            //$('#dx_other1_h').add('p').text(value.dx2);
            //$('#dx_other2_h').text(value.dx2);

            //alert(value.bw);
        });
    });
    $('input#vstdate_fromclick').val(history_vstdate);
    $('input#vn_current').val(vn);
    getLab();
    getDrug();
    //$('div#lab_result').empty();

});

function getLab(){
    var vn = $('input#vn_current').val();
    //var id = this.id;
    //var hn = $('#hnn').val();
    //var vstdate =  $('input#vstdate_fromclick').val();
    $('div#lab_result').empty();
    $.getJSON('get_lab_data.php',{vn:vn}, function(data) {
        var array_len = data.length;
        if(data != ''){
            for (var j = 0; j < array_len; j++) {

                var num_result = data[j].length;
                for (var k = 3; k < num_result; k++) {
                    $('div#lab_result').append(
                        "<p>"+data[j][k]+"</p>"
                    )
                }
                $('div#lab_result').append(
                    "<hr>"
                )
            }
        }
    });
}
function getDrug(){
    var vn = $('input#vn_current').val();
    $('tbody#my_drugs tr').remove();
    $.getJSON('get_drug_data.php',{vn:vn}, function(data) {
        $x = 1;
        $.each(data, function(key,value){
            $("tbody#my_drugs").append("<tr>" +
                "<td>"+$x+"</td>" +
                "<td>"+value.nameprscdt+"</td>" +
                "<td>"+value.qty+"</td>" +
                "<td>"+value.doseprn1+" "+value.doseprn2+"</td>" +
                "</tr>"
            );
            $x++;
        });
    });
}

