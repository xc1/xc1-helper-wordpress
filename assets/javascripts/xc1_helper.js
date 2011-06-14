var XC1_Helper = function($) {
  
  function _initForm(form) {
    if ($('#xc1_helper_static').is(':checked')) {
      $('.xc1_static').show();
    } else {
      $('.xc1_static').hide();
    }
    
    $('#xc1_helper_static').change(function() {
      if ($(this).is(':checked')) {
        $('.xc1_static').show();
      } else {
        $('.xc1_static').hide();
      }
    });
    
    if ($('#xc1_helper_admin').is(':checked')) {
      $('.xc1_admin').show();
    } else {
      $('.xc1_admin').hide();
    }
    
    $('#xc1_helper_admin').change(function() {
      if ($(this).is(':checked')) {
        $('.xc1_admin').show();
      } else {
        $('.xc1_admin').hide();
      }
    });
  };
  
  function _elementExists(str) {
    return $(str).length !== 0;
  };
  
  return {
    init: function() {
      _elementExists('form#xc1_helper_settings') && _initForm('form#xc1_helper_settings');
    }
  };
};

jQuery(document).ready(XC1_Helper(jQuery).init);