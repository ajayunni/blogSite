<script type="application/javascript">
    $('input[type=file]').on('change', function () {
        var $files = $(this).get(0).files;
        if ($files.length) {
            // Reject big files
            if ($files[0].size > $(this).data('max-size') * 1024) {
                tinymce.get('text-box').setContent( tinymce.get('text-box').getContent() +' select a smaller file');
                return false;
            }
            // Begin file upload
            console.log('Uploading file to Imgur..');
            // Replace ctrlq with your own API key
            var apiUrl = 'https://api.imgur.com/3/image';
            var apiKey = '2cec3bfab1e245a';

            var settings = {
                async: false,
                crossDomain: true,
                processData: false,
                contentType: false,
                type: 'POST',
                url: apiUrl,
                headers: {
                    Authorization: 'Client-ID ' + apiKey,
                    Accept: 'application/json',
                },
                mimeType: 'multipart/form-data',
            };
            var formData = new FormData();
            formData.append('image', $files[0]);
            settings.data = formData;
            // Response contains stringified JSON
            // Image URL available at response.data.link
            $.ajax(settings).done(function (response) {
                tinymce.get('text-box').setContent( tinymce.get('text-box').getContent() +' '+JSON.parse(response).data.link);
            });
        }
    });
</script>
