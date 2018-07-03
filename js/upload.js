$(document).ready(function () {

    function postImages(clicker, inputElement, headerID) {
        $(clicker).on('submit', function (e) {
            e.preventDefault();
            var allFiles = document.getElementById(inputElement).files;
            var header = document.getElementById(headerID).value;

            var formData = new FormData();
            let status = document.querySelector('#status');
            console.log(allFiles.length);
            console.log(allFiles);

            for (var i = 0; i < allFiles.length; i++) {
                var file = allFiles[i];

                if (file.size >= 16000000) {
                    status.innerHTML = 'Filen är för stor!';
                    return;
                }
                formData.append('files[]', file);
                formData.append('headerID', header);
                console.log(file);
                console.log(headerID);
            }

            for (var pair of formData.entries()) {
                console.log(pair);
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
                    getHeadersAndImages();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#status").html('<pre><code>AJAX Request Failed<br/> textStatus=' + textStatus + ', errorThrown=' + errorThrown + '</code></pre>');
                }
            });
        });
    }

    function postFunc() {
        var click1 = '#file-form1';
        var click2 = '#file-form2';
        var click3 = '#file-form3';
        var inputEl1 = 'files1';
        var inputEl2 = 'files2';
        var inputEl3 = 'files3';
        var headerID1 = 'headvalue1';
        var headerID2 = 'headvalue2';
        var headerID3 = 'headvalue3';
        postImages(click1, inputEl1, headerID1);
        postImages(click2, inputEl2, headerID2);
        postImages(click3, inputEl3, headerID3);
    }

    postFunc();

    /* GET - headers and images */
    function getHeadersAndImages() {
        $.get('../api/?/galleryheader').then(function (response) {
            var responseheads = response.allheaders;
            Array.from(document.querySelectorAll('.gh')).map(function (head, i) {
                head.value = responseheads[i].header;
                return head.value;
            });
            responseheads.map(function (obj) {
                $.get('../api/?/galleryheader/' + obj.headerID + '/images').then(function (response) {
                    var image = response.header_images.map(function (img) {
                        var pic = '<img class="gallery-pic" src="' + img.dir + '" id="img' + img.id + '"/>';
                        return pic;
                    });

                    var id = response.id;
                    switch (id) {
                        case "1":
                            $('#gallery-1').html(image);
                            break;
                        case "2":
                            $('#gallery-2').html(image);
                            break;
                        case "3":
                            $('#gallery-3').html(image);
                            break;

                        default:
                            break;
                    }
                });
                return obj;
            });
        });
    }
    getHeadersAndImages();
});