$(document).ready(function(){
    var maxField = 4; //Input fields increment limitation
    var addHobby = $('#add_address'); //Add button selector
    var hobbywrapper = $('.address_wrap'); //Input field wrapper
    var hobbyHTML = ' <div class="uk-margin add_wrap"><textarea class="uk-textarea" rows="5" placeholder="Textarea" name="address[]"></textarea><a href="javascript:void(0);" class="btn btn-primary" id="add_address"><i class="material-icons">add</i></a><a href="javascript:void(0);" class="btn btn-danger" id="remove_address"><i class="material-icons">close</i></a></div>'; //New input field html 
    var y = 1; //Initial field counter is 1
    $(hobbywrapper).on('click', '#add_address', function(){ //Once add button is clicked
        if(y < maxField){ //Check maximum number of input fields
            y++; //Increment field counter
            $(hobbywrapper).append(hobbyHTML); // Add field html
        }
    });
    $(hobbywrapper).on('click', '#remove_address', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        y--; //Decrement field counter
    });
});