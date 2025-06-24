//GLOBALNE PREMENNE:

var CaretSelection;
var otvorene = new Array(2).fill(false);
var kliknutelne = new Array(2).fill(true);
var ParagraphOpen = true;
var Paragraph = "";
var OutFocus = false;
var FocusID = "";

var ClanokInfo = {
    nadpis: document.getElementById("art-header").innerHTML,
    fotka: "/random.png",
    clanok: document.getElementById("art-txt").innerHTML,
    kategoria: -1,
    tagy: "nic"
}

var Radios = document.getElementsByClassName("category-section-radio");
var nRadios = Radios.length;
for(let m = 0; m < nRadios; m++) {
    Radios[m].addEventListener("click", () => {
        ClanokInfo.kategoria = Radios[m].value;
        console.log("element " + Radios[m].value);
    });

}



document.execCommand('defaultParagraphSeparator', false, 'p');

function pridajObrazok(nazov) {
    /*var sel, range;
    if(CaretSelection) {
        console.log("Pridaj obrazok");
        console.log(CaretSelection);
        //sel = window.getSelection();
        if(CaretSelection.getRangeAt && CaretSelection.rangeCount) {
            range = CaretSelection.getRangeAt(0);
            range.deleteContents();
            var imgtag = document.createElement("img");
            imgtag.alt = "ALTERNATIVA";
            imgtag.src = "";
            imgtag.className = "img-100";
            var imgfrag = document.createDocumentFragment();
            imgfrag.appendChild(imgtag);
            range.insertNode(imgfrag);

        }
    }
    else if (document.selection && document.selection.createRange) {
        document.selection.createRange().text = text;
    }*/
    var htmlstring = "<img src='"+nazov+"' alt='The image' class='img-100'/>";
    document.execCommand("insertHtml", true, htmlstring);
}

function zmena(n, ptm = false) {
        var fd = new FormData();
        fd.append("subor",n.files[0]);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && xhr.status === 200) {
                if(this.response != "H" && this.response != "HH") 
                {
                    document.getElementById("img-spread").innerHTML = this.response;
                    alert("CHYBA! " + this.response);
                }
                else alert("Nepodporovaná koncovka súboru.");
                //console.log("F " + this.response);
                if(ptm) potom();
                //alert("CHYBA 4.3.2020" + xhr.responseText);
            }
        }
        xhr.open("post","imgupload.php",true);
        xhr.send(fd);
}



function obrazokMenu(top, anim, id) {
    //console.log(top + " " + anim);
    if(kliknutelne[id]) {
        kliknutelne[id] = false;
        setTimeout(() => {
            kliknutelne[id] = true;
            otvorene[id] = !otvorene[id];
        }, 1500);
        if(!otvorene[id]) {
            document.getElementById(top).style.opacity = 1;
            document.getElementById(top).style.overflow = "unset";
            document.getElementById(top).style.height = "230px";
            setTimeout(() => document.getElementById(anim).style.opacity = 1, 500);
        } else {
            document.getElementById(anim).style.opacity = 0;
            setTimeout(() => {
                document.getElementById(top).style.opacity = 0;
                document.getElementById(top).style.overflow = "hidden";
                document.getElementById(top).style.height = "0";
            }, 800);
        }
    }
}

document.getElementById("tag-section-textarea").addEventListener("click", function() {
    //console.log("OUTFOCUS TRUE");
    OutFocus = true;
    FocusID = this.id;
    this.focus();
});

document.getElementById("tag-section-textarea").addEventListener("keyup", function() {
    ClanokInfo.tagy = this.innerHTML;
});

document.getElementById("art-header").addEventListener("click", function() {
    //console.log("OUTFOCUS TRUE");
    OutFocus = true;
    FocusID = this.id;
    this.focus();
});

document.getElementById("vlozit-link").addEventListener("click", function() {
    OutFocus = true;
    FocusID = this.id;
    this.focus();
});

document.getElementById("vlozit-text").addEventListener("click", function() {
    OutFocus = true;
    FocusID = this.id;
    this.focus();
});

document.getElementById("art-txt").addEventListener("focusin", function() {
    //CaretSelection = window.getSelection();
    //console.log("focusin");
    //document.execCommand("insertHtml",false,"<p>TXT</p>");
});

document.getElementById("art-txt").addEventListener("focusout", function(event) {
    //console.log("FOCUSOUT");
    if(!OutFocus) {
        CaretSelection = window.getSelection();
        document.getElementById("art-txt").focus();
    }
    else {
        document.getElementById(FocusID).focus();
        FocusID = this.id;
        OutFocus = false;
    }
});

document.getElementById("art-txt").addEventListener("keyup", function(event) {
    /*if(event.keyCode === 13) {
        event.preventDefault();
        document.execCommand("insertHtml",true,"<p>TXT</p>");
        //zatagovat("p");
    }*/
    ClanokInfo.clanok = this.innerHTML;
    //console.log(this.innerHTML);
});

document.getElementById("art-header").addEventListener("keyup", function(event) {
    ClanokInfo.nadpis = this.innerHTML;
});


document.getElementById("art-txt").addEventListener("input", function() {
});

document.getElementById("vlozit-odkaz").addEventListener("click", function() {
    /*document.getElementById("art-txt").focus();
    FocusID = document.getElementById("art-txt");
    OutFocus = false;*/
    vlozitOdkaz(document.getElementById("vlozit-text").value,document.getElementById("vlozit-link").value);
});

function zatagovat(typ) {
    //console.log(CaretSelection);
    //var oznacene = CaretSelection.toString() || "";
    var range = CaretSelection.getRangeAt(0);
    range.deleteContents();
    var el = document.createElement(typ);
    //el.innerHTML = oznacene;
    range.insertNode(el);
    //CaretSelection.collapse(el,1);
}

function vlozitOdkaz(text, link) {
    var range = CaretSelection.getRangeAt(0);
    range.deleteContents();
    var a = document.createElement("a");
    a.innerHTML = text;
    a.href = link;
    range.insertNode(a);
}



window.onload = function() {
    //alert("sda");
    document.getElementById("art-txt").focus();
}

function potom(n) {
    //console.log("POTOM");
    let url = "";
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if(xhr.status === 200 && xhr.readyState === 4) {
            url = xhr.response;
            console.log("R " + url);
            document.getElementById("main-pic").style.backgroundImage = "url('"+url+"')";
            document.getElementById("main-pic-ct").style.display = "none";
            ClanokInfo.fotka = url;
        }
    }
    xhr.open("GET", "adminka_bcg.php?fun=last");
    xhr.send();
    
}

function publikovat() {
    ClanokInfo.clanok = document.getElementById("art-txt").innerHTML;
    ClanokInfo.nadpis = document.getElementById("art-header").innerHTML;
    let objstring = JSON.stringify(ClanokInfo);
    objstring = encodeURIComponent(objstring);
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if(xhr.status === 200 && xhr.readyState === 4) {
            if(parseInt(xhr.response) === 1) alert("Publikované!");
            else console.log(xhr.response);
        }
    }
    xhr.open("POST","../create-article.php",true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    console.log("Poslednýkrát pred poslaním:");
    //console.log(objstring);
    xhr.send("objstring="+objstring);
}