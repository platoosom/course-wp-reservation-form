

jQuery(function($){
    $(document).ready(function($){
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

            if($('#email').val() == ''){
                alert("Please input email");
                return false;
            }

            if($('#checkin').val() == ''){
                alert("Please input checkin");
                return false;
            }

            if($('#checkout').val() == ''){
                alert("Please input checkout");
                return false;
            }

            if($('#roomtype').val() == ''){
                alert("Please input roomtype");
                return false;
            }

            if($('#note').val() == ''){
                alert("Please input note");
                return false;
            }

            $('input[name="submit"]').val('Submitting...');
            $('input[name="submit"]').attr('disabled', true);

            $.ajax({
                type: "post",
                dataType: "json",
                url: Reservation.ajax_url,
                data: {
                    "action": "add_reservation",
                    "fullname": $("#fullname").val(),
                    "phone": $("#phone").val(),
                    "email": $("#email").val(),
                    "checkin": $("#checkin").val(),
                    "checkout": $("#checkout").val(),
                    "adults": $("#adults").val(),
                    "children": $("#children").val(),
                    "roomtype": $("#roomtype").val(),
                    "note": $("#note").val(),
                    "_wpnonce": $("#_wpnonce").val(),
                },
                success: function(msg){
                    alert(msg.data);

                    document.getElementsByClassName('uk-form-stacked')[0].reset();

                    $('input[name="submit"]').val('Submit');
                    $('input[name="submit"]').attr('disabled', false);

                }
            });


        });
    });
});
