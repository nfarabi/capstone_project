@push('localCSS')
    <link rel="stylesheet" href="{{ asset('css/vendor/codemirror/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/codemirror/theme/monokai.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/codemirror/addon/scroll/simplescrollbars.css') }}">
    <style>
        .CodeMirror {
            font-size: 16px;
        }
    </style>
@endpush

@push('localJavaScript')
    <script src="{{ asset('js/vendor/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('js/vendor/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('js/vendor/codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('js/vendor/codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('js/vendor/codemirror/addon/display/autorefresh.js') }}"></script>
    <script src="{{ asset('js/vendor/codemirror/addon/scroll/simplescrollbars.js') }}"></script>
    <script>
        $(function() {
            $('.editor').each(function(key, element) {

                var editor = CodeMirror.fromTextArea( $(element).get(0), {
                    autoRefresh: true,
                    htmlMode: true,
                    indentUnit: 4,
                    lineNumbers: true,
                    // lineWrapping: true,
                    mode: $(element).data('mode'),
                    scrollbarStyle: "simple",
                    theme: "monokai"
                });

            });
        });
    </script>
@endpush
