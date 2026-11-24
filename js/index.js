function register(e){
    e.preventDefault();
    var Id = $("#Id").val();
    var Fname = $("#Fname").val();
    var Mname = $("#Mname").val();
    var Lname = $("#Lname").val();
    var Course = $("#Course").val();
    var Gender = $("#Gender").val();
    var Year = $("#Year").val();
    var Section = $("#Section").val();
    var Email = $("#Email").val();
    var Password = $("#Password").val();
    $.post("php/registration.php", {
        xId : Id,
        xFname : Fname,
        xMname : Mname,
        xLname : Lname,
        xCourse : Course,
        xGender : Gender,
        xYear : Year,
        xSection : Section,
        xEmail : Email,
        xPassword :Password

    }, function (data) {
        console.log(data)
        let dataX = JSON.parse(data)
        if (dataX.status == "sucess") {
            alert('Registration Successful!')
            window.location.href = "./html/login.html"
        }else{
            alert("Registration Error!")
        }
    })
}