$(document).ready(function() {
    $('#show-ocb-form').live('click', function() {
        $('#ocb-form-wrap').show();
        $('#ocb-form').show();
        $('#ocb-form-result').hide();
        return !1;
    });

    $('.ocb-form-header-close').live('click', function() {
        $('.ocb-error-msg').each(function(index) { $(this).hide(); });
        $('.ocb-result-icon-success').hide();
        $('.ocb-result-icon-fail').hide();
        $('#ocb-form-wrap').fadeOut();
        return !1;
    });

    $('button.intaro-modules-button.disabled, .intaro-modules-button.disabled input').live('click', function() {
        return false;
    });

    $('#ocb-form').live('submit', function() {
        $('.ocb-error-msg').each(function(index) { $(this).hide(); });
        var fieldId, fieldVal, checked = !0, self = $(this);
        var emailReg = RegExp("^[0-9a-zA-Z\-_\.]+@[0-9a-zA-Z\-]+[\.]{1}[0-9a-zA-Z\-]+[\.]?[0-9a-zA-Z\-]+$");
        var phoneReg = RegExp("^[+0-9\-\(\) ]+$");
        $('input[name^="new_order"]').each(function() {
            fieldId = $(this).attr('id');
            fieldVal = $(this).val();
            if ($(this).prev().children('ins').length > 0) {
                if (fieldVal=='') {
                    $('#' + fieldId + '-error').show();
                    checked = !1;
                }
            }
            if (fieldId.indexOf('PHONE')!=-1 && fieldVal!='' && !phoneReg.test(fieldVal)) {
                $('#' + fieldId + '-format-error').show();
                checked = !1;
            }
            if (fieldId.indexOf('EMAIL')!=-1 && fieldVal!='' && !emailReg.test(fieldVal)) {
                $('#' + fieldId + '-format-error').show();
                checked = !1;
            }
        });
        if (!checked) return !1;
        $('.intaro-modules-button', $(this)).addClass('disabled');
        $('.ocb-form-loader').show();
        if (0 < $('#ocb_antispam_check').length && $('#ocb-antispam').length === 0) {
            $('#ocb-params').prepend("<input id='ocb-antispam' type='hidden' name='antispam' value=''>");
        }

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'json',
            error: function(obj, text, err) {
                $('.ocb-form-loader').hide();
                alert('Error connecting server or getting server response!');
            },
            success: function(data) {
                if(data.ok!='Y') {
                    $('.ocb-result-icon-fail').show();
                    $('.ocb-result-text').text(data.msg);
                } else {
                    $('.ocb-result-icon-success').show();
                    if ($('#cart_line').length > 0)
                        $('#cart_line').html(data.msg);
                }
                $('.ocb-form-loader').hide();
                $('.intaro-modules-button', self).removeClass('disabled');
                $('#ocb-form').hide();
                $('#ocb-form-result').show();
                window.setTimeout(function() { $('.ocb-form-header-close').click(); }, 3000);
            }
        });

        return !1;
    });
});