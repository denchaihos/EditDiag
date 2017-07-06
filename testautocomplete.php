<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27/10/2557
 * Time: 11:15 น.
 */

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="css/j_ui_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/ui/jquery.ui.core.js"></script>
    <script type="text/javascript" src="js/ui/jquery.ui.widget.js"></script>
   <script type="text/javascript" src="jquery/ui/jquery.ui.button.js"></script>
    <script type="text/javascript" src="js/ui/jquery.ui.position.js"></script>
    <script type="text/javascript" src="js/ui/jquery.ui.menu.js"></script>
    <script type="text/javascript" src="js/ui/jquery.ui.autocomplete.js"></script>
    <script type="text/javascript" src="js/ui/jquery.ui.tooltip.js"></script>

    <script>



        ///////
        var ajaxSubmit = function(formEl) {

            if ($("#combobox").val() == '' ){
                    alert("กรุณากรอกข้อมูลให้ครบ");
            } else {
                var url = $(formEl).attr('action');
                var data = $(formEl).serialize();
                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    datatype: 'html',
                    success: function(data){
                        alert(data);
                        $.fancybox.close();
                        $("#flex1").flexReload();
                    }
                })
            }
            return false;

        };
    //-------autocomplete--------------
    (function( $ ) {
    $.widget( "custom.combobox", {
    _create: function() {
    this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
            .attr( "tabIndex", -1 )
            .attr( "title", "Show All Items" )
            .tooltip()
            .appendTo( this.wrapper )
            .button({
            icons: {
            primary: "ui-icon-triangle-1-s"
            },
            text: false
            })
            .removeClass( "ui-corner-all" )
            .addClass( "custom-combobox-toggle ui-corner-right" )
            .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
            })
            .click(function() {
            input.focus();

            // Close if already visible
            if ( wasOpen ) {
            return;
            }

            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
            });
            },

            _source: function( request, response ) {
            var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
            response( this.element.children( "option" ).map(function() {
            var text = $( this ).text();
            if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
            label: text,
            value: text,
            option: this
            };
            }) );
            },

            _removeIfInvalid: function( event, ui ) {

            // Selected an item, nothing to do
            if ( ui.item ) {
            return;
            }

            // Search for a match (case-insensitive)
            var value = this.input.val(),
            valueLowerCase = value.toLowerCase(),
            valid = false;
            this.element.children( "option" ).each(function() {
            if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
            }
            });

            // Found a match, nothing to do
            if ( valid ) {
            return;
            }

            // Remove invalid value
            this.input
            .val( "" )
            .attr( "title", value + " didn't match any item" )
            .tooltip( "open" );
            this.element.val( "" );
            this._delay(function() {
            this.input.tooltip( "close" ).attr( "title", "" );
            }, 2500 );
            this.input.data( "ui-autocomplete" ).term = "";
            },

            _destroy: function() {
            this.wrapper.remove();
            this.element.show();
            }
            });
            })( jQuery );

            $(function() {
            $( "#combobox" ).combobox();
            $( "#toggle" ).click(function() {
            $( "#combobox" ).toggle();
            });
            });


        function icd10name() {

            var dx = $('#txt').val();
            //$('.custom-combobox-input').val(dx);
            var len_dx = dx.length;
            //alert(dx);

            if(len_dx>1){

                //$('input.custom-combobox-input').val(dx);
                 $.getJSON('testautocomplete_data.php',{dx:dx}, function(data) {

                     $.each(data, function(key,value) {
                         //$('#combobox').append('<option value="'+value.icd10+'">'+value.icd10name+'</option>');
                         $('#icd10name').val(value.icd10name);
                        // alert(value.icd10name);

                     });
                 });
            }
        };
            </script>
</head>
<body>
<?php
 include 'connect.php';
?>
    <form name="add_order" id="profileForm" type="actionForm" action="distribute_detail_temp_add.php" method="post"  onsubmit="return ajaxSubmit(this)"   >
        <input type="text" id="txt" onkeyup="icd10()" name="txt" value="ab"/>
        <input type="text" id="icd10name" name="icd10name" value=""/>
            <select id="combobox" name="txtwasadu_name" class="ui-widget" tabindex="1"  onKeyPress="return tabE(this,event)"  >
            <option ></option>

        </select>


    </form>
</body>
</html>
