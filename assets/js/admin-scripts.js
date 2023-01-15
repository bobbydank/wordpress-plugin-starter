(function ($) {
    $(document).ready(function() {
        $('.main_upload_image_button').click(function(e) {
            e.preventDefault();
            $this = $(this);
            var send_attachment_bkp = wp.media.editor.send.attachment;
            
            var button = $(this);
            var c = $(this).attr('data-input');
            
            wp.media.editor.send.attachment = function(props, attachment) {
                //console.log(attachment);
                $('input'+c).attr('value', attachment.id);
                $('span'+c).find('a').text(attachment.filename).attr('href', attachment.url);
                $this.hide();
            }
            wp.media.editor.open(button);
            
        });
        $('.main_remove_image_button').click(function(e) {
            e.preventDefault();
            $this = $(this);
            var answer = confirm('Are you sure?');
            
            var button = $(this);
            var c = button.attr('data-input');
            
            if (answer == true) {
                $('input'+c).attr('value', '');
                $('span'+c).find('a').text('').attr('href', '#');
                $this.parent().children().show();
            }
            return false;
        });

        
    });

    function main_query(type, val) {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {   
                var json = JSON.parse(xmlhttp.response);
                //console.log(json);

                json.forEach((thing) => {
                    //do something with data.
                });
            }
        }

        address = "location of the ajax.php file";

        xmlhttp.open("POST", address, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("p="+val);
    }

    function main_classify(string) {
        let s = string.toLowerCase();
        s = s.replace('?', '');
        s = s.replace('!', '');
        s = s.replace(',', '');
        s = s.replace(';', '');
        s = s.replace('.', '');
        s = s.replace("'", '');
        s = s.replace('"', '');
        s = s.replace('/', '');
        s = s.replace('&', '');
        s = s.replace('$', '');
        s = s.replace(' ', '_');

        return s;
    }
})(jQuery);