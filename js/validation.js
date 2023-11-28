

jQuery(function($){
    $(document).ready(function(){
        $('.uk-form-stacked').submit(function(){
            
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



            return true;
        });
    });
});
