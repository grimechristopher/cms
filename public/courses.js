console.log('courses.js loaded.');
console.log('courses.js loaded 2 .');
window.onload = function () {
    var desktopView = window.matchMedia('(min-width: 64em)');
    //var printView = window.matchMedia('print');
    var menuToggle = document.getElementById('menutoggle');
    var nav = document.getElementsByTagName('nav')[0];
    if (menuToggle){
        menuToggle.addEventListener("click", toggleNav, false);    
    }
    if (desktopView.matches){
        console.log('Screen size is larger than 64em.');
        var details = document.getElementsByTagName('details');
        nav.style.display = "block";
        for (var i = 0 in details) {
            details[i].open = true;
        }
    }
    else {
        console.log('Screen size is smaller than 64em.');
        nav.style.display = "none";
        for (var i = 0 in details) {
            details[i].open = false;
        }
    }
}
function toggleNav() {
    var nav = document.getElementsByTagName('nav')[0];
    var checkbox = document.getElementById('menutoggle');
    if (checkbox.checked == true){
        nav.style.display = "block";
    }
    else{
        nav.style.display = "none";
    }
}