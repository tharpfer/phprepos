$(document).ready(function() {
            $("#refresh").on("click", function() {
                $.ajax({
                    url: 'refresh.php',
                    dataType: 'json',
                    success: function(data) {
                        $("#refresh-message").remove();
                        if(data.error == false){
                            $('#repo-data').html(data.html);
                            var msg = '<p>Added Repositories: ' + data.added + '</p>'
                                    + '<p>Updated Repositories: ' + data.updated.length + '</p>'
                                    + '<p>Removed Repositories: ' + data.removed + '</p>';                        
                            $('#refresh-row .col-sm-8').append('<div id="refresh-message" class="alert alert-success">' + msg + '</div>');            
                            for(var i=0; i < data.updated.length; i++)
                            {
                                $("#row" + data.updated[i] + " .panel").removeClass('panel-default').addClass('panel-warning');
                            }
                        }
                        else {
                            $('#refresh-row .col-sm-8').append('<div id="refresh-message" class="alert alert-danger">Error: ' + data.msg + '</div>'); 
                        }
                    }
                });
            });
        });