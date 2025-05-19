
tinymce.PluginManager.add('mhelementor', function (editor) {
    var menuItems = [];
    tinymce.each(myListItems, function (key, value) {
        menuItems.push({
            text: value,
            onclick: function () {editor.insertContent(key);}
        });
    });
    editor.addButton('mhelementor', {
        type: 'menubutton',
        text: 'المنتور',
        tooltip: 'برای افزودن المان به ادیتور کلیک کنید',
        //icon: 'code',
        menu: menuItems
    });
    editor.addMenuItem('mhelementorDropDownMenu', {
        icon: 'code',
        text: 'المان های پیشفرض',
        menu: menuItems,
        context: 'insert',
        //prependToContext: true
    });
});

tinymce.init({
    forced_root_block : "", 
    convert_urls: false,
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea",  // change this value according to your HTML
    //rtl_ui:true,
    directionality: 'rtl',
    plugins:[
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen mhelementor",
        "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl | mhelementor | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
});
tinymce.init({
    forced_root_block : "", 
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea1",
    directionality: 'rtl',
    plugins:[
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
})
tinymce.init({
    forced_root_block : "", 
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea2",
    directionality: 'rtl',
    plugins:[
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
})
tinymce.init({
    forced_root_block : "", 
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea3",
    directionality: 'rtl',
    plugins:[
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
})
tinymce.init({
    forced_root_block : "", 
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea4",
    directionality: 'rtl',
    plugins:[
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
})
tinymce.init({
    forced_root_block : "", 
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea5",
    directionality: 'rtl',
    plugins:[
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
})
tinymce.init({
    forced_root_block : "", 
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea6",
    directionality: 'rtl',
    plugins:[
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
})


tinymce.init({
    forced_root_block : "", 
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea7",
    directionality: 'rtl',
    plugins:[
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
})


tinymce.init({
    forced_root_block : "", 
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea8",
    directionality: 'rtl',
    plugins:[
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
})


tinymce.init({
    forced_root_block : "", 
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea9",
    directionality: 'rtl',
    plugins:[
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
})


tinymce.init({
    forced_root_block : "", 
    force_br_newlines : true,
    force_p_newlines : false,
    selector: "#edittextarea10",
    directionality: 'rtl',
    plugins:[
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste directionality",
    ],
    toolbar: "ltr rtl | fontselect fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    font_formats: "Tahoma=tahoma,arial,helvetica,sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Open Sans=Open Sans,helvetica,sans-serif;Symbol=symbol;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
    fontsize_formats: "8px 10px 11px 12px 14px 18px 24px 36px",
    setup: function (ed) {
        ed.on('init', function (ed) {
            ed.target.editorCommands.execCommand("fontName", false, "tahoma");
        });
    }
})