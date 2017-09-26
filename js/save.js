$(document).ready(function(){
    $('#contact_us').click(function(){
       var name=$('#name').val();
       var email=$('#email').val();
       var mobile=$('#mobile').val();
       var message=$('#message').val();
       alert(message);
       $.post('./save.php',{name:name,email:email,mobile:mobile,message:message},function(data){
            alert(data);
       });
    });
});