document.querySelectorAll('#radio-proizvodi').forEach(function(item){
    item.addEventListener("click",pokaziProizvodDugme);
});

function pokaziProizvodDugme(){
    document.getElementById("btnsProizvodi").style.display = "block";
}
document.querySelectorAll('#radio-zaposleni').forEach(function(item){
    item.addEventListener("click",pokaziZaposlenogDugme);
});

function pokaziZaposlenogDugme(){
    document.getElementById("btnsZaposleni").style.display = "block";
}

document.querySelectorAll('#radio-izvestaj').forEach(function(item){
    item.addEventListener("click",pokaziIzvestajDugme);
});
function pokaziIzvestajDugme(){
    document.getElementById("btnsIzvestaj").style.display = "block";
}
// function checkZaposleniBtns(){
//     var radios = document.getElementsByName("radio-zaposleni");

//     for (var i = 0, len = radios.length; i < len; i++) {
//          if (radios[i].checked) {
//              return true;
//          }
//     }

//     return false;
// }
// function checkProizvodiBtns(){
//     var radios = document.getElementsByName("radio-proizvodi");

//     for (var i = 0, len = radios.length; i < len; i++) {
//          if (radios[i].checked) {
//              return true;
//          }
//     }

//     return false;
// }

$('#dodajProizvodForm').submit(function(){
    event.preventDefault();
    const $form = $(this);
    const $inputs = $form.find('input, select, button, textarea');
    const serijalizacija = $form.serialize();

    request = $.ajax({
        url:'handler/addProduct.php',
        type: 'post',
        data: serijalizacija
    });

    request.done(function(response, textStatus, jqXHR){
        if(response == "Success"){
            alert("Proizvod uspesno dodat!");
            console.log("Upsesno dodavanje");
            location.reload(true);
        }
        else{ console.log("Proizvod nije dodat" + response);
            alert(response);
            //console.log(response);
        }   
        
    });

    request.fail(function(jqXHR, text, errorThrown){
        console.error('Sledeca greska se desila: '+textStatus, errorThrown)
    });
});

$('#dodajZaposlenogForm').submit(function(){
    event.preventDefault();
    const $form = $(this);
    const $inputs = $form.find('input, select, button, textarea');
    const serijalizacija1 = $form.serialize();

    request = $.ajax({
        url:'handler/addUser.php',
        type: 'post',
        data: serijalizacija1
    });

    request.done(function(response, textStatus, jqXHR){
        if(response ==="Succes"){
            alert("Zaposleni uspesno dodat!");
            console.log("Upsesno dodavanje");
            location.reload(true);
        }
        else{
            console.log("Zaposleni nije dodat" + response);
            console.log(response);
            alert(response);
        } 
    });

    request.fail(function(jqXHR, text, errorThrown){
        console.error('Sledeca greska se desila: '+textStatus, errorThrown)
    });
});

$('#btn-obrisi-proizvod').click(function(){
    
    const checked = $('input[name=radio-proizvodi]:checked');

    request = $.ajax({
        url: 'handler/deleteProduct.php',
        type:'post',
        data: {'proizvod_id':checked.val()}
    });

    request.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
           checked.closest('tr').remove();
           alert('Obrisan proizvod');
           console.log('Obrisan');
           function reload(){
            var container = document.getElementById("myTable1");
            var content = container.innerHTML;
            container.innerHTML= content; 
            
           //this line is to watch the result in console , you can remove it later	
            console.log("Refreshed"); 
            }

        //    location.reload(true);
        }else {
        console.log("Proizvod nije obrisan "+res);
        alert("Proizvod nije obrisan ");

        }
    });

});
$('#btn-obrisi-zaposlenog').click(function(){
    
    const checked = $('input[name=radio-zaposleni]:checked');

    if(checked.val() == 1){
        alert("Ne mozete obrisati admina!");
        return;
        location.reload(true);
    }

    request = $.ajax({
        url: 'handler/deleteUser.php',
        type:'post',
        data: {'zaposleni_id':checked.val()}
    });

    request.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
           checked.closest('tr').remove();
           alert('Obrisan zaposleni');
           console.log('Obrisan');
           location.reload(true);
        }else {
        console.log("Zaposleni nije obrisan "+res);
        alert("Zaposleni nije obrisan!");

        }
        console.log(res);
    });

});
$('#btnObrisiIzvestaj').click(function(){
    
    const checked = $('input[name=radio-izvestaj]:checked');

    request = $.ajax({
        url: 'handler/deleteReport.php',
        type:'post',
        data: {'id':checked.val()}
    });

    request.done(function(res, textStatus, jqXHR){
        if(res=="Success"){
           checked.closest('tr').remove();
           alert('Obrisan izvestaj!');
           console.log('Obrisan');
           location.reload(true);
        }else {
        console.log("Izvestaj nije obrisan "+res);
        alert("Izvestaj nije obrisan ");

        }
        console.log(res);
    });

});

$('#btn-pretraga-proizvoda').click(function () {
    $('#txt-pretraga-proizvoda').toggle();
});

$('#btn-pretraga-zaposlenog').click(function () {

    $('#txt-pretraga-zaposlenog').toggle();

});

$("#txt-pretraga-proizvoda").on('keyup', function(){

    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("txt-pretraga-proizvoda");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable1");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
});

$("#txt-pretraga-zaposlenog").on('keyup', function(){

    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("txt-pretraga-zaposlenog");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable2");
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
});

$('#btn-izmeni-proizvod').click(function () {

    const checked = $('input[name=radio-proizvodi]:checked');
    request = $.ajax({
        url: 'handler/getProduct.php',
        type: 'post',
        data: {'id': checked.val()},
        dataType: 'json'
    });
    request.done(function (response, textStatus, jqXHR) {
        console.log('Vracena lista');

        $('#naziv').val(response[0]['naziv']);
        console.log(response[0]['naziv']);

        $('#cena').val(response[0]['cena']);
        console.log(response[0]['cena']);

        $('#datum_unosa').val(response[0]['datumUnosa']);
        console.log(response[0]['datumUnosa']);

        $('#unos-ID').val(checked.val());

        console.log(response);
    });

   request.fail(function (jqXHR, textStatus, errorThrown) {
       console.error('Sledeca greska se desila: ' + textStatus, errorThrown);
   });

});

$('#izmeniProizvodForm').submit(function () {
    event.preventDefault();
    const $form = $(this);
    const $inputs = $form.find('input, select, button, textarea');
    const serijalizacija = $form.serialize();
    console.log(serijalizacija);
    // $inputs.prop('disabled', true);

    request = $.ajax({
        url: 'handler/updateProduct.php',
        type:'post',
        data: serijalizacija
    });

    request.done(function (response, textStatus, jqXHR) {


        if (response === 'Success') {
            console.log('Proizvod je izmenjen');
            alert("Proizvod je uspesno izmenjen!");
            location.reload(true);
        }
        else{
        console.log('Proizvod nije izmenjen ' + response);
        console.log(response);
        alert(response);

        } 
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });


});
$('#btn-izmeni-zaposlenog').click(function () {

    const checked = $('input[name=radio-zaposleni]:checked');
    request = $.ajax({
        url: 'handler/getUser.php',
        type: 'post',
        data: {'id': checked.val()},
        dataType: 'json'
    });
    request.done(function (response, textStatus, jqXHR) {
        console.log('Vracena lista');

        $('#radnik_ime').val(response[0]['ime']);
        console.log(response[0]['radnik_ime']);

        $('#radnik_prezime').val(response[0]['prezime']);
        console.log(response[0]['radnik_prezime']);

        $('#radnik_datum_rodjenja').val(response[0]['datum_rodjenja']);
        console.log(response[0]['radnik_datum_rodjenja']);

        $('#radnik_sifra').val(response[0]['sifra']);
        console.log(response[0]['radnik_sifra']);

        $('#radnik_korisnicko_ime').val(response[0]['korisnicko_ime']);
        console.log(response[0]['radnik_korisnicko_ime']);

        $('#radnik_id').val(checked.val());

        console.log(response);
    });

   request.fail(function (jqXHR, textStatus, errorThrown) {
       console.error('Sledeca greska se desila: ' + textStatus, errorThrown);
   });

});

$('#izmeniZaposlenogForm').submit(function () {
    event.preventDefault();
    const $form = $(this);
    const $inputs = $form.find('input, select, button, textarea');
    const serijalizacija = $form.serialize();
    console.log(serijalizacija);

    request = $.ajax({
        url: 'handler/updateUser.php',
        type:'post',
        data: serijalizacija
    });

    request.done(function (response, textStatus, jqXHR) {

        if (response === 'Success') {
            console.log('Zaposleni je izmenjen');
            alert("Zaposleni je uspesno izmenjen!");
            location.reload(true);
        }
        else{
        console.log('Zaposleni nije izmenjen ' + response);
        console.log(response);
        alert(response);
        } 
    });
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });
});

function sortTableAsc1() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable1");
    switching = true;
    rows = table.rows;

    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[3];
            y = rows[i + 1].getElementsByTagName("TD")[3];
            if (x.innerHTML > y.innerHTML) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}
function sortTableDsc1() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable1");
    switching = true;
    rows = table.rows;

    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[3];
            y = rows[i + 1].getElementsByTagName("TD")[3];
            if (x.innerHTML < y.innerHTML) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }

}
function sortTableAsc2() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable2");
    switching = true;
    rows = table.rows;

    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[0];
            y = rows[i + 1].getElementsByTagName("TD")[0];
            if (x.innerHTML > y.innerHTML) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}
function sortTableDsc2() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable2");
    switching = true;
    rows = table.rows;

    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[0];
            y = rows[i + 1].getElementsByTagName("TD")[0];
            if (x.innerHTML < y.innerHTML) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }

}
function sortTableAsc3() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable3");
    switching = true;
    rows = table.rows;

    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[1];
            y = rows[i + 1].getElementsByTagName("TD")[1];
            if (x.innerHTML > y.innerHTML) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}
function sortTableDsc3() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("myTable3");
    switching = true;
    rows = table.rows;

    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[1];
            y = rows[i + 1].getElementsByTagName("TD")[1];
            if (x.innerHTML < y.innerHTML) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }

}

$('#dodajIzvestaj').submit(function(){
    event.preventDefault();
    const $form = $(this);
    const $inputs = $form.find('input, select, button, textarea');
    const serijalizacija1 = $form.serialize();

    console.log(serijalizacija1);

    request = $.ajax({
        url:'handler/addReport.php',
        type: 'post',
        data: serijalizacija1
    });

    request.done(function(response, textStatus, jqXHR){
        if(response == "Success"){
            alert("Izvestaj uspesno dodat!");
            console.log("Upsesno dodavanje");
            location.reload(true);
        }
        else{ console.log("Izvestaj nije dodat" + response);
            alert(response);
        }   
        
    });

    request.fail(function(jqXHR, text, errorThrown){
        console.error('Sledeca greska se desila: '+textStatus, errorThrown)
    });
});

function proveriDatum(){

     var today = new Date();
     var dd = today.getDate();
     
     var mm = today.getMonth()+1; 
     var yyyy = today.getFullYear();
     if(dd<10) 
     {
         dd='0'+dd;
     } 
     
     if(mm<10) 
     {
         mm='0'+mm;
     } 
     today = yyyy+'-'+mm+'-'+dd;
     console.log(today);
     

        request = $.ajax({
            url:'handler/checkDate.php',
            type: 'post',
            data: {'datum':today}
        });
    request.done(function(response, textStatus, jqXHR){
        if(response == "UNET"){
            document.getElementById("txt-izvestaj").readOnly = true;
            document.querySelector("#btnPosaljiIzvestaj").innerHTML = "Izvestaj je vec poslat!";
            document.getElementById("btnPosaljiIzvestaj").setAttribute('disabled','disabled');

        }
        else{ console.log("Neuspeh" + response);
        }   
        
    });

    request.fail(function(jqXHR, text, errorThrown){
        console.error('Sledeca greska se desila: '+textStatus, errorThrown)
    });
};

$('#btnPrikaziIzvestaj').click(function () {

    const checked = $('input[name=radio-izvestaj]:checked');
    request = $.ajax({
        url: 'handler/getReport.php',
        type: 'post',
        data: {'id': checked.val()},
        dataType: 'json'
    });
    request.done(function (response, textStatus, jqXHR) {
        console.log('Vracena lista');

        $('#ispisIzvestaja').val(response[0]['izvestaj']);
        console.log(response[0]['izvestaj']);

        console.log(response);
    });

   request.fail(function (jqXHR, textStatus, errorThrown) {
       console.error('Sledeca greska se desila: ' + textStatus, errorThrown);
   });

});