require('./bootstrap')

tinymce.init({
    selector: '#description',
    toolbar: 'undo redo  | bold italic underline |  removeformat',
    menubar: false,
})
