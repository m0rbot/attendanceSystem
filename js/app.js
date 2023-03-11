let registerStudent = document.getElementById('student');
let abscenseList = document.getElementById('abs');
let ajouterBtn = document.getElementById('ajt');
let listBtn = document.getElementById('lst');
let filierSel = document.getElementById('fil');
let geii_data = document.getElementById('geii_data');
let scheduleBtn = document.getElementById('sch');
let schedule = document.getElementById('schedule');
let datepicker = document.getElementById('date');
let fingerprint = document.getElementById('fingerprint');
let fingerId = document.getElementById('form3Example4');

setTimeout(function(){
  $('#icorrectCred').remove();
},3000);
setTimeout(function(){
  $('#success').remove();
},3000);
setTimeout(function(){
  $('#fail').remove();
},3000);

if(window.history.replaceState){
  window.history.replaceState(null, null, window.location.href);
}

ajouterBtn.addEventListener('click', function(){
    registerStudent.style.display='block';
    abscenseList.style.display='none';
    schedule.style.display='none';

});
listBtn.addEventListener('click', function(){
    abscenseList.style.display='block';
    registerStudent.style.display='none';
    schedule.style.display='none';

});
scheduleBtn.addEventListener('click', function(){
    schedule.style.display='block';
    abscenseList.style.display='none';
    registerStudent.style.display='none';

});

filierSel.addEventListener("change", function() {
    if (this.value === "geii") {
        geii_data.style.display = "block";
}});
fingerprint.addEventListener("click", function(){
  var data = fingerId.value;
  var conn = new SerialPort('com3', {baudRate: 9600});
  conn.write(data);
  console.log(data);
})




