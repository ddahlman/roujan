$(document).ready(function () {

    $('#file-form').on('submit', (e) => {
        e.preventDefault();
        var allFiles = document.getElementById('files').files;
        var formData = new FormData();
        let status = document.querySelector('#status');
        console.log(allFiles.length);
        var json_arr = JSON.stringify(allFiles);
        for (var i = 0; i < allFiles.length; i++) {
            var file = allFiles[i];

            if (file.size >= 16000000) {
                status.innerHTML = 'Filen är för stor!';
                return;
            }

            formData.append('files', file);
            console.log(formData);
            console.log(typeof file);
        }

        $.ajax({
            type: "POST",
            url: "http://localhost/roujan/api/?/gallery",
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                console.log(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#status").html('<pre><code>AJAX Request Failed<br/> textStatus=' + textStatus + ', errorThrown=' + errorThrown + '</code></pre>');
            }
        });
        /*console.log(formdata);*/

        /*   $.post('http://localhost/markdowntest/api/?/courses', formdata, {
               contentType: false,
               processData: false
           }).then((response) => {
               console.log(response.file);
           });*/
    });

    $('#get').on('click', () => {
        let id = $('#get-id').val();

        $.ajax({
            type: "GET",
            url: "http://localhost/markdowntest/api/?/courses/" + id,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                console.log(response.content);
                $('#markdown').html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#status").html('<pre><code>AJAX Request Failed<br/> textStatus=' + textStatus + ', errorThrown=' + errorThrown + '</code></pre>');
            }
        });


        /*$.get('http://localhost/markdowntest/api/?/courses/40')
            .then((response) => {
                console.log(response);
                $('#markdown').html(response.courses[2].contents);
            }).fail((xhr, status, error) => {
                $("#status").html('<pre><code>AJAX Request Failed<br/> textStatus=' + status + ', errorThrown=' + error + '</code></pre>');
            });*/
    });
});