function alert_message(title, content, type="orange") {
    $.alert({title: title, content: content, type: type});
}

function custom_dialog(titleDialog, dilaogContent) {
    $.dialog({
        title: titleDialog,
        columnClass: 'col-7',
        content: dilaogContent,
        onContentReady: function () {
            console.log(window);
            window.ventFrame = this;
        },
    });
}

function custom_confirm(title, type, content, confirm_Btn_title, confirm_Btn_function, cancel_Btn_title, cancel_Btn_function) {
    $.confirm({
        'title': title,
        'type': type,
        'content': content,
        'buttons': {
            'confirm': {
                'text': confirm_Btn_title,
                'action': confirm_Btn_function
            },
            'delete': {
                'text': cancel_Btn_title,
                'action': cancel_Btn_function
            }
        }
    });
}


