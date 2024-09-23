<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CKEditor Test</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script src="/public/adminlte/ckfinder/ckfinder.js"></script>
</head>
<body>
    <textarea class="editor"></textarea>
    <script>
        window.editors = {};
        document.querySelectorAll('.editor').forEach((node, index) => {
            ClassicEditor
                .create(node, {
                    ckfinder: {
                        uploadUrl: '/myshop/public/adminlte/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
                    },
                    toolbar: ['ckfinder', '|', 'heading', '|', 'bold', 'italic', '|', 'undo', 'redo', '|', 'link', 'bulletedList', 'numberedList', 'insertTable', 'blockQuote'],
                    image: {
                        toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight'],
                        styles: [
                            'alignLeft',
                            'alignCenter',
                            'alignRight'
                        ]
                    },
                    language: 'az'
                })
                .then(newEditor => {
                    window.editors[index] = newEditor
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</body>
</html>