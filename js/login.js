function login(e) {
    e.preventDefault();
    var Uname = $("xUname").val();
    var pass  = $("xpass").val();
    $.post("./php/login.php",{
        xUname : Uname,
        xpass : pass
        
    }, function (data){
        if (data == "../php/userdashboard.php"){
            window.location.href = "../php/userdashboard.php";
        }else{
            alert(data)
        }
    })
}