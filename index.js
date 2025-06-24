function send() {
    var inp = document.getElementById("newsinput").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if(xhr.status === 200 && xhr.readyState === 4) {
            switch(xhr.response) {
                case "OK":
                    document.getElementById("newslettermsgs").innerHTML = '<div id="badmail" style="display: block; background-color:#27ae60;">Thank you!</div>';
                    break;
                case "WF":
                    document.getElementById("newslettermsgs").innerHTML = '<div id="badmail" style="display: block">Incorrect email format.</div>';
                    break;
                case "AL":
                    document.getElementById("newslettermsgs").innerHTML = '<div id="badmail" style="display: block">Email is already enlisted.</div>';
            }
        }
    }
    inp = "email=" + inp;
    xhr.open("POST","newsletter.php", true);
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
    xhr.send(inp);
}

function cookies() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET","cookie.php",true);
    xhr.send();
    document.getElementById("gdpr").innerHTML = "";
}