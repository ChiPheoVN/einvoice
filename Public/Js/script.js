"use strict";
$(document).ready(function(){
    init.set_datepicker();
    init.button_close_panel();
    init.hover_active();

    script.enterprise_script();
    script.admin_script();
    script.setting_script();
    script.file_import_invoice_setting_script();
    //script.nkc1_script();
    script.group_permiss_script();
    script.general_journal_script();
})
var init = {
    set_datepicker : function(){
        $('.datepicker').datepicker({
            title: 'Chọn ngày',
            todayBtn: true,
            todayHighlight: true,
            autoclose: true,
            format: 'dd-mm-yyyy',
            startView: 'days'
        }).datepicker("setDate", new Date());
    },
    button_close_panel: function(){
        $(document).on('click', 'button[data-dismiss="panel"]', function(){
            let _panel = $(this).closest('div.panel-group');
            $(_panel).remove();
        })
    },
    hover_active: function(){
        $(document).on('mouseover', '.hover_active:not(.active):not(.success)', function(){
            $('.hover_active').removeClass('active');
            $(this).addClass('active');
        }).on('click', '.hover_active:not(.success)', function(){
            $('.hover_active').removeClass('success');
            $(this).addClass('success');
        })
    }
}
var handle = {
    sendAjax : function(url = '', data = '', f_success, dataType = "JSON", type = 'POST',  reloadJS = false, listJsFile = new Array(), f_js_sucess) {
        $.ajax({
            cache: false,
            type: type,
            data: data,
            dataType: dataType,
            url: url,
            success: function (data) {
                if (reloadJS) {
                    $.each(listJsFile, function (i, item) {
                        $.getScript(item, function (data) {
                            f_js_sucess(data);
                        });
                    });
                };
                f_success(data);
            },
            error: function (error) {
                console.log(error.responseText);
            }
        });
    },
    getJson_ajax: function(url = '', data = '', f_success){
        this.sendAjax(
            url,
            data,
            f_success
        );
    },
    getHtml_ajax: function(url = '', data = '', f_success){
        this.sendAjax(
            url,
            data,
            f_success,
            'html'
        );
    }
}
var script = {
    admin_script : function(){
        $(document).on('click', '.btn-delete-admin', function(){
            let _url    = $(this).data('href');
            let _modal  = $('div.modal_delete_admin');
            $(_modal).find('.btn-ok-delete').attr('href', _url);
        }),
        $(document).on('click', '.btn-edit-admin', function(){
            let _id     = $(this).data('id');
            let _modal  = $('div.modal_edit_admin');
            let _f          = function(_data){
                let _username   = _data.username;
                let _permiss    = _data.permiss;

                $(_modal).find('input.txt_username').val(_username);
                $(_modal).find('select.slb_permiss_group option[value="'+_permiss+'"]').prop('selected', true);
                $(_modal).find('button.btn_save').val(_id);

            };
            handle.sendAjax(
                'get-infor-admin-ajax.html',
                {id: _id},
                function(_data){
                    console.log(_data);
                    _f(_data);
                }
            );
        })
    },
    enterprise_script : function(){
        $(document).on('click', '.btn-view-infor-enterprise', function(){// view infor enterprise
            let _modal_view = $('div.modal_view_enterprise');
            let _id         = $(this).data('id');
            let _f          = function(_data){
                if(_data.hasOwnProperty('enterprise_infor')){
                    let _enterprise_infor = _data.enterprise_infor;
                    $(_modal_view).find('label.lbl_username').text(_enterprise_infor.username);
                    $(_modal_view).find('label.lbl_email').text(_enterprise_infor.email);
                    $(_modal_view).find('label.lbl_sellername').text(_enterprise_infor.sellername);

                    $(_modal_view).find('label.lbl_vtusername').text(_enterprise_infor.vtname);
                    $(_modal_view).find('label.lbl_vtpassword').text(_enterprise_infor.vtpassword);
                    $(_modal_view).find('label.lbl_ngaydangky').text(_enterprise_infor.ngaydangky);
                    $(_modal_view).find('label.lbl_ngayhethan').text(_enterprise_infor.ngayhethan);
                    $(_modal_view).find('label.lbl_taxcode').text(_enterprise_infor.sellertaxcode);

                    $(_modal_view).find('label.lbl_legalname').text(_enterprise_infor.sellerlegalname);
                    $(_modal_view).find('label.lbl_address').text(_enterprise_infor.address);
                    $(_modal_view).find('label.lbl_website a').text(_enterprise_infor.website);
                    $(_modal_view).find('label.lbl_website a').attr('href',_enterprise_infor.website);
                }
            };
            handle.sendAjax(
                'get-infor-enterprise-ajax.html',
                {id: _id},
                function(_data){
                    console.log(_data);
                    _f(_data);
                }
            );
        });

        $(document).on('click', '.btn-delete-enterprise', function(){
            let _url    = $(this).data('href');
            let _modal  = $('div.modal_delete_enterprise');
            $(_modal).find('.btn-ok-delete').attr('href', _url);
        })

        $(document).on('click', '.btn-edit-infor-enterprise', function(){// edit infor enterprise
            let _modal_edit = $('div.modal_edit_enterprise');
            let _id         = $(this).data('id');
            let _f          = function(_data){
                if(_data.hasOwnProperty('enterprise_infor')){
                    let _enterprise_infor = _data.enterprise_infor;
                    $(_modal_edit).find('input.txt_username').val(_enterprise_infor.username);
                    $(_modal_edit).find('input.txt_email').val(_enterprise_infor.email);
                    $(_modal_edit).find('input.txt_sellername').val(_enterprise_infor.sellername);

                    $(_modal_edit).find('input.txt_vtusername').val(_enterprise_infor.vtname);
                    $(_modal_edit).find('input.txt_vtpassword').val(_enterprise_infor.vtpassword);
                    $(_modal_edit).find('input.txt_ngaydangky').val(_enterprise_infor.ngaydangky);
                    $(_modal_edit).find('input.txt_ngayhethan').val(_enterprise_infor.ngayhethan);
                    $(_modal_edit).find('input.txt_sellertaxcode').val(_enterprise_infor.sellertaxcode);

                    $(_modal_edit).find('input.txt_sellerlegalname').val(_enterprise_infor.sellerlegalname);
                    $(_modal_edit).find('input.txt_address').val(_enterprise_infor.address);
                    $(_modal_edit).find('input.txt_website').val(_enterprise_infor.website);
                    $(_modal_edit).find('input.txt_phonenumber').val(_enterprise_infor.phonenumber);
                    $(_modal_edit).find('input.txt_giamdoc').val(_enterprise_infor.giamdoc);

                    $(_modal_edit).find('select.slb_export_excel_id option[value="' + _enterprise_infor.id_import_excel + '"]').prop('selected', true);
                    $(_modal_edit).find('select.slb_general_journal_id option[value="' + _enterprise_infor.general_journal_id + '"]').prop('selected', true);
                    $(_modal_edit).find('select.slb_service_provider_id option[value="' + _enterprise_infor.service_provider + '"]').prop('selected', true);

                    $(_modal_edit).find('button.btn_edit_enterprise').val(_id);
                }
            };
            handle.sendAjax(
                'get-infor-enterprise-ajax.html',
                {id: _id},
                function(_data){
                    console.log(_data);
                    _f(_data);
                }
            );
        });
    },
    setting_script: function(){
        $(document).on('click','input[type="checkbox"][data-parent_name]',function(){
            let _name               = $(this).attr('name');
            let _checked            = $(this).prop('checked');
            let _parent_name        = $(this).data('parent_name');
            let _same_parent        = $('input[type="checkbox"][data-parent_name="'+_parent_name+'"]');
            let _same_parent_checked= $('input[type="checkbox"][data-parent_name="'+_parent_name+'"]:checked');
            let _children           = $('input[type="checkbox"][data-parent_name="'+_name+'"]');
            let _children_length    = $(_children).length;

            let _length_same_parent = $(_same_parent).length;
            let _length_same_parent_checked = $(_same_parent_checked).length;

            $('input[type="checkbox"][name="'+_parent_name+'"]').prop('checked', _length_same_parent == _length_same_parent_checked);

            $(_children).each(function(){
                $(this).prop('checked', _checked);
            });
        });
    },
    file_import_invoice_setting_script : function(){
        $('.choose-file').change(function() {
            console.log($(this).val());
        });
        $(document).on('click', 'a.btn-delete-file-import-setting', function(){
            let _modal_edit = $('div.modal_delete_file_import_setting');

            let _certain    = $(this).data('href-certain');
            let _uncertain  = $(this).data('href-uncertain');

            $(_modal_edit).find('.btn-ok-delete-certain').attr('href', _certain);
            $(_modal_edit).find('.btn-ok-delete-uncertain').attr('href', _uncertain)
        });
        $(document).on('click','a.btn-edit-file-setting', function(){
            let _modal_edit = $('div.modal_edit_file_setting');
            let _id = $(this).data('id');
            let _f          = function(_data){
                if(_data.hasOwnProperty('file_infor')){
                    console.log(_data.file_infor);
                    let _file_infor = _data.file_infor;
                    $(_modal_edit).find('input.txt-templatecode').val(_file_infor.temp_code);
                    $(_modal_edit).find('input.txt-filename').val(_file_infor.file_name);
                    $(_modal_edit).find('input.txt-startrowinsertdata').val(_file_infor.start_row_insert_data);
                    $(_modal_edit).find('input.txt-startrowtitledata').val(_file_infor.start_row_title_data);
                    $(_modal_edit).find('button.btn_edit').val(_id);
                }
            };
            handle.sendAjax(
                'get-infor-file-import-setting-ajax.html',
                {id: _id},
                function(_data){
                    console.log(_data);
                    _f(_data);
                }
            );
        });
        $(document).on('click', 'a.btn-setting-file-import', function(){
            let _url    = $(this).data('url');
            let _id     = $(this).data('id');
            let _modal_setting = $('div.modal_setup_file_setting');

            let _f          = function(_data){
                console.log(_data);
                $(_modal_setting).find('button.btn_add_connect').data('id', _id);
                $(_modal_setting).find('button.btn_save_connect').val(_id);
                $(_modal_setting).find('.modal-body .connect_container').html(_data);
            };

            handle.sendAjax(
                _url,
                {id: _id},
                function(_data){
                    console.log(_data);
                    _f(_data);
                },
                'html'
            );
        });
        $(document).on('click', 'button.btn_add_connect', function(){
            let _id = $(this).data('id');
            let _modal_setting = $('div.modal_setup_file_setting');
            let _f          = function(_data){
                //console.log(_data);
                $(_modal_setting).find('.modal-body>div.connect_container').append(_data);
            };
            handle.sendAjax(
                'add-connect-html.html',
                {id: _id},
                function(_data){
                    console.log(_data);
                    _f(_data);
                },
                'html'
            );
        });
        $(document).on('change', 'select.slb_file_general_journal', function(){
            let _id     = $(this).val();
            handle.getJson_ajax(
                'get-col-general-joural-json.html',
                {id: _id},
                function(json){
                    console.log(json);
                    let _slb_col_gen = $('.panel_add_connect .col_general_journal');
                    $(_slb_col_gen).html('');

                    $(_slb_col_gen).append($('<option>', {text: '-- Mặc định --', value: -1}));
                    json.forEach(function(item, key){
                        $(_slb_col_gen).append($('<option>',{text: item.text, value: item.value}));
                    });
                }
            )
        });
    },
    nkc_script: function(){
        $(document).on('click', 'button.btn_add_new_col_extension', function(){
            let _panel = $('div.panel_extension_col');
            let _f          = function(_data){
                $(_panel).find('div.panel-body').append(_data);
            };
            handle.sendAjax(
                'add-extension-col-nkc-html.html',
                {},
                function(_data){
                    console.log(_data);
                    _f(_data);
                },
                'html'
            );
        }),
        $(document).on('click', 'button.btn_add_new_col_caculate', function(){
            let _panel = $('div.panel_caculate_col');
            let _f          = function(_data){
                $(_panel).find('div.panel-body').append(_data);
            };
            handle.sendAjax(
                'add-caculate-col-nkc-html.html',
                {},
                function(_data){
                    console.log(_data);
                    _f(_data);
                },
                'html'
            );
        })
    },
    general_journal_script: function(){
        $(document).on('click', '.btn-delete-general-journal', function(){
            let _modal  = $('div.modal_delete_general_journal');
            let _href   = $(this).data('href');

            // set url
            $(_modal).find('a.btn-ok-delete').attr('href', _href);
        }),
        $(document).on('click', '.btn-edit-general-journal', function(){
            let _modal  = $('div.modal_edit_general_journal');
            let _id     = $(this).data('id');

            $(_modal).find('button.btn_edit').val(_id);

            // get infor gen by ajax
            handle.getJson_ajax(
                'get-infor-file-general-journal-json.html',
                {id: _id},
                function(data){
                    if(!data.hasOwnProperty('error')){
                        let _result = data.result;
                        $(_modal).find('input.txt_name_general_journal').val(_result.name);
                        $(_modal).find('input.txt_startrowtitledata_general_journal').val(_result.row_title_data);
                        $(_modal).find('input.txt_startrowreaddata_general_journal').val(_result.row_read_data);
                    }
                }
            );
        }),
        $(document).on('click', '.click_tr_general_journal', function(){
            let _id = $(this).data('id');
            handle.getHtml_ajax(
                'get-option-view-ajax.html',
                {id: _id},
                function(html){
                    console.log(html);
                    $('div.show_option_general_journal').html('');
                    $('div.show_option_general_journal').html(html);
                }
            );
        }),
        $(document).on('click', '.btn_add_new_col_extension', function(){
            let _html_tr    = $('table.tbl_extension_col tbody tr.tr_new').html();
            let _new_tr     = $('<tr>').html(_html_tr);
            $('table.tbl_extension_col tbody').append(_new_tr);
            $('table.tbl_extension_col tbody tr:not(.hidden):last-child td.td_index').text($('table.tbl_extension_col tbody tr:not(.hidden)').length);
        }),
        $(document).on('click', '.btn_add_new_col_caculate', function(){
            let _html_tr    = $('table.tbl_caculate_col tbody tr.tr_new').html();
            let _new_tr     = $('<tr>').html(_html_tr);
            $('table.tbl_caculate_col tbody').append(_new_tr);
            $('table.tbl_caculate_col tbody tr:not(.hidden):last-child td.td_index').text($('table.tbl_caculate_col tbody tr:not(.hidden)').length);
        }),
        $(document).on('click', '.btn_edit_col_general_journal', function(){
            let _id_col = $(this).data('id-col');
            let _panel  = $('div.modal_edit_col_general_journal');
            $(_panel).find('button.btn_edit').val(_id_col);

            // get infor col
            handle.getJson_ajax('get-col-general-joural-infor-json.html',{id: _id_col}, function(data){
                $(_panel).find('input').val('');

                $(_panel).find('input.txt_col_title_general_journal').val(data.title);
                $(_panel).find('input.txt_col_name_general_journal').val(data.name);

                if(data.type === 'root'){
                    $(_panel).find('input.txt_col_default_value_general_journal').attr('readOnly','true');
                    $(_panel).find('input.txt_col_formula_general_journal').attr('readOnly','true');
                }else if(data.type === 'extension'){
                    $(_panel).find('input.txt_col_default_value_general_journal').val(data.default_value);

                    $(_panel).find('input.txt_col_default_value_general_journal').removeAttr('readOnly');
                    $(_panel).find('input.txt_col_formula_general_journal').attr('readOnly','true');

                }else if(data.type == 'caculate'){
                    $(_panel).find('input.txt_col_formula_general_journal').val(data.formula);

                    $(_panel).find('input.txt_col_default_value_general_journal').attr('readOnly','true');
                    $(_panel).find('input.txt_col_formula_general_journal').removeAttr('readOnly');
                }
            });

        })
    },
    group_permiss_script: function(){
        $(document).on('click', '.btn-edit-group-permiss', function(){
            let _panel  = $('div.edit_group_permiss');
            let _id     = $(this).data('id');
            $(_panel).find('button.btn-save').val(_id);

            let _f          = function(_data){
                $(_panel).find('.panel-permiss .panel-body .checkbox input[type="checkbox"]').prop('checked', false);
                _data.checked_permiss.forEach((_checked)=>{
                    console.log(_checked);
                    $(_panel).find('.panel-permiss .panel-body .checkbox input[type="checkbox"][value="'+_checked+'"]').prop('checked', true);
                });

                $(_panel).find('.txt_group_permiss_name').val(_data.group_name);
                $(_panel).find('.txt_group_permiss_des').val(_data.group_des);
            };
            handle.sendAjax(
                'view-edit-permission-ajax.html',
                {id: _id},
                function(_data){
                    console.log(_data.all_permiss);
                    _f(_data);
                }
            );
        })
    }
}
