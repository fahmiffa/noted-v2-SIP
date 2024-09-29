$(document).ready(function() {
    $('.summernote').summernote({
        tabDisable :true,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear', 'highlight']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['custom', ['insertSymbol','insertSymbols','insertSymbols1']],
        ],
        buttons: {
            insertSymbol: function() {
                const ui = $.summernote.ui;
                const button = ui.button({
                    contents: '<span class="symbol-button">≤</span>',
                    tooltip: 'Insert Symbol',
                    click: function() {
                        const summernoteInstance = $(this).closest('.note-editor')
                            .prev('.summernote');

                        summernoteInstance.summernote('code', '<span class="simbol">≤</span>');
                    }
                });
                return button.render();
            },
            insertSymbols: function() {
                const ui = $.summernote.ui;
                const button = ui.button({
                    contents: '<span class="symbol-button">≥</span>',
                    tooltip: 'Insert Symbol',
                    click: function() {
                        const summernoteInstance = $(this).closest('.note-editor')
                            .prev('.summernote');

                        summernoteInstance.summernote('code', '<span class="simbol">≥</span>');
                    }
                });
                return button.render();
            },
            insertSymbols1: function() {
                const ui = $.summernote.ui;
                const button = ui.button({
                    contents: '<span class="symbol-button">≠</span>',
                    tooltip: 'Insert Symbol',
                    click: function() {
                        const summernoteInstance = $(this).closest('.note-editor')
                            .prev('.summernote');

                        summernoteInstance.summernote('code', '<span class="simbol">≠</span>');
                    }
                });
                return button.render();
            }

        }
    });

});