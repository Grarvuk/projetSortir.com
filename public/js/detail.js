$( document ).ready(function() {
    console.log(adresseBase+"sorties/insertinscription");

    $( ".svgNonInscri" ).on( "click", function() {
        inscription($(this).attr("value"));
    });

    $(".svgInscri" ).on( "click", function() {
        desinscription($(this).attr("value"));
    });

    function inscription(idSorti)
    {
        $.ajax({
            url : adresseBase+"sorties/insertinscription",
            type : "POST",
            data : {
                "idSortie": idSorti,
            },
        
            succes: function (res) {
               
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr); // Ce code affichera le message d'erreur, ici Message d'erreur.
                console.log(ajaxOptions);
                console.log(thrownError);
            }
        })
        $("#flashMessage").append("<div class='alert-success'>Inscription réussie</div>");
        $(".svgRegister").removeClass( "svgNonInscri" ).addClass( "svgInscri" );

        $(".svgRegister").find("svg").remove();
        $(".svgRegister").find('#txtBtnRegister').remove();
        $(".svgRegister").append("<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><path d='M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z'/></svg>")
        $(".svgRegister").append('<span id="txtBtnRegister"> Inscris</span>')
    }

    function desinscription(idSorti)
    {
        $.ajax({
            url : adresseBase+"sorties/deleteinscription",
            type : "POST",
            data : {
                "idSortie": 1,
            },
        
            succes: function (res) {
               
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr); //Ce code affichera le message d'erreur, ici Message d'erreur.
                console.log(ajaxOptions);
                console.log(thrownError);
            }
        })
        $("#flashMessage").append("<div class='alert-success'>Inscription réussie</div>");
        $(".svgRegister").css("fill", "green");
        $(".svgRegister").css("color", "green");

        $(".svgRegister").find("svg").remove();
        $(".svgRegister").find('#txtBtnRegister').remove();
        $(".svgRegister").append("<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><path d='M20.285 2l-11.285 11.567-5.286-5.011-3.714 3.716 9 8.728 15-15.285z'/></svg>")
        $(".svgRegister").append('<span id="txtBtnRegister"> Inscris</span>')
    }
});