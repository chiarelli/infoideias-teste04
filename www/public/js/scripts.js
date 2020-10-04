
$(document).ready(function(){/* jQuery toggle layout */
$('#btnToggle').click(function(){
  if ($(this).hasClass('on')) {
    $('#main .col-md-6').addClass('col-md-4').removeClass('col-md-6');
    $(this).removeClass('on');
  }
  else {
    $('#main .col-md-4').addClass('col-md-6').removeClass('col-md-4');
    $(this).addClass('on');
  }
});
});

jQuery(document).ready(function ($) {
    
    var $row       = $("#publication_date_row")
      , $checkboxe = $("#publicar")
    ;
    
    function checked() {
        if(this.checked) {
            return $row.show();
        }        
        $row.hide();
    }
    
    $checkboxe.change(checked);
    
    $checkboxe.get(0) 
        ? checked.apply($checkboxe.get(0)) 
        : $row.show();
});
