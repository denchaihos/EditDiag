<?php
/**
 * Created by PhpStorm.
 * User: IT3
 * Date: 12/6/2557
 * Time: 13:36 น.
 */
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/jquery-migrate-1.0.0.js"></script>
    <link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

    <title>BootPag - boostrap dynamic pagination jQuery plugin</title>
    <style type="text/css">
        p{
            text-align: center;
        }
        #fancybox-close {
            display:inline !important;
            top: -7px !important;
            right: 1px !important;
            width: 28px !important;
            height: 30px !important;

        }
    </style>
    <script type="text/javascript">
        function resizeFancyBox()
{
 var newheight = $(window).height() - 30;
 var newHeightStr = newheight + 'px';
 $("#fancybox-content").css({ 'height': newHeightStr });
}

function closeCallback() {
 $(window).unbind('resize', resizeFancyBox);
}

function startCallback(){
 $(window).bind('resize', resizeFancyBox);
}

function showEformFancyBox() {
 $('#hdnFancyBoxLink').fancybox({
  width: 800,
  height: $(window).height() - 20,
  onStarted : startCallback,
  onClosed : closeCallback,
  showCloseButton: true
 });
 $('#hdnFancyBoxLink').click();
}
        function edit_dx(){
            $.fancybox({'href'	: 'testfancy2.php',
                  width: 800,
                  height: $(window).height() - 20,
                  showCloseButton: true,                
                speedIn    :  600,
                speedOut   :  200,
                overlayShow   :   true,
               enableEscapeButton: false,
                onStarted : startCallback,
                

                onComplete : function() {
                    $('#txtwasadu_name').focus();
                },
                onClosed : closeCallback,
            });
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "distribute_detail_form.php",
                data: distribute_id

            });

        }
        //--------------SAVE-------------
        function btnSave(){
            $.fancybox({'href'	: 'distribute_save.php',
                'transitionIn'  :   'elastic',
                'transitionOut' :   'elastic',
                'speedIn'    :  600,
                'speedOut'   :  200,
                'overlayShow'   :   false,
                onComplete : function() {
                    $.fancybox.close();
                    $("#flex1").focus();
                    $("#flex1").flexReload();
                    //$.flexigrid.flexReload();
                }
            });

        }
        //--------------Cancel-------------
        function btnCancel(){
            $.fancybox({'href'	: 'distribute_cancel.php',
                'transitionIn'  :   'elastic',
                'transitionOut' :   'elastic',
                'speedIn'    :  600,
                'speedOut'   :  200,
                'overlayShow'   :   false,
                onComplete : function() {
                    $.fancybox.close();
                    $("#flex1").flexReload();

                }

            });

        }
    </script>
</head>
<body>
    <input type="button" value="testfancy" id="hdnFancyBoxLink" onclick="edit_dx()"/>



</body>
</html>