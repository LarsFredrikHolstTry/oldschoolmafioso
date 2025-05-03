$(document).on("click", "input[name='radioBtn']", function(){
    thisRadio = $(this);
    if (thisRadio.hasClass("imChecked")) {
        thisRadio.removeClass("imChecked");
        thisRadio.prop('checked', false);
    } else { 
        thisRadio.prop('checked', true);
        thisRadio.addClass("imChecked");
    };
})

function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('clock').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}

function startDate(){
    var date = new Date();
    var day = ("0" + date.getDate()).slice(-2);
    var days = ["Søndag", "Mandag", "Tirsdag", "Onsdag", "Torsdag", "Fredag", "Lørdag"];
    var today = date.getDay();
    var months = ["Januar", "Februar", "Mars", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Desember"];
    var month_today = date.getMonth();
    document.getElementById('date').innerHTML = days[today] + " " + day + ". " + months[month_today];
}

function timer(seconds, id){
    var timeleft = seconds;
    var downloadTimer = setInterval(function(){
        timeleft--;
        document.getElementById(id).textContent = timeleft;
    if(timeleft <= 0)
    document.getElementById(id).innerHTML = '<span style="color: #009fe3;">klar!</span>';
    },1000);
}