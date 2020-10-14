$( document ).ready(function() {
    adresseBrut = location.href.split("/");
    adresseBase = adresseBrut[0]+"/"+adresseBrut[1]+"/"+adresseBrut[2]+"/"+adresseBrut[3]+"/"+adresseBrut[4]+"/";
    

    $('#myTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
    });

    $('#myTable2').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
    });
});