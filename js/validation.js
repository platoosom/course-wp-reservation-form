

jQuery(function($){
    $(document).ready(function(){
        $('.uk-form-stacked').submit(function(e){
            e.preventDefault();

            if($('#fullname').val() == ''){
                alert("Please input fullname");
                return false;
            }

            if($('#phone').val() == ''){
                alert("Please input phone");
                return false;
            }

            if($('#date').val() == ''){
                alert("Please input date");
                return false;
            }

            if($('#detail').val() == ''){
                alert("Please input detail");
                return false;
            }


            $.ajax({
                type: "post",
                dataType: "json",
                url: Reservation.ajax_url,
                data: {
                    "action": "add_reservation",
                    "fullname": $("#fullname").val(),
                    "date": $("#date").val(),
                    "phone": $("#phone").val(),
                    "detail": $("#detail").val() 
                },
                success: function(msg){
                    document.getElementsByClassName('uk-form-stacked')[0].reset();
                    alert(msg.data);
                }
            });


        });
    });
});
