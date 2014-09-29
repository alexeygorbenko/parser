/**
 * Created by alex on 9/22/14.
 */

$(document).ready(function(){
    $(".status").on('click', function(event) {
        event.preventDefault();
        if ($(this).html() == 'enabled')
        {
            $(this).text('disabled');
            $(this).attr('status' , 'disabled')
        }
        else
        {
            $(this).text('enabled');
            $(this).attr('status' , 'enabled')
        }
        $.ajax({
            type: "POST",
            url: "myCode/getContent.php",
            data: "status=" + $(this).attr('status') + "&" + "id=" + $(this).attr("value")
        })
            .done(function(data){
                console.log(data)
            });
    });

    $(".url").on('click', function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "myCode/getContent.php",
            data: "fileName=" + $(this).attr("href")
        })
            .done(function(data){
                console.log(data)
            });
    });

})
