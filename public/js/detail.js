$( document ).ready(function() {
    var premierClick = true;
    var estInscris;
    var txtDOrigine = "";
    // console.log(adresseBase+"sorties/insertinscription");

    //Partie mousseout de la sourie
    //Partie mousseout de la sourie
    //Partie mousseout de la sourie

    $(".svgInscri").on("mouseout", function() {
        if($(this).hasClass("svgNonInscri"))
        {
            // console.log("svgInscri sortant");
            $("#txtBtnRegister").text(" S'inscrire");
        }
        else
        {
            // console.log("svgNonInscri sortant");
            $("#txtBtnRegister").text(" Vous êtes inscrit");
        }
    });

    $(".svgNonInscri").on("mouseout", function() {
        if($(this).hasClass("svgNonInscri"))
        {
            // console.log("svgInscri sortant")
            $("#txtBtnRegister").text(" S'inscrire");
        }
        else
        {
            // console.log("svgNonInscri sortant")
            $("#txtBtnRegister").text(" Vous êtes inscrit");
        }
    });

    //Partie mousseover de la sourie
    //Partie mousseover de la sourie
    //Partie mousseover de la sourie

    $(".svgInscri").on("mouseover", function() {
        if($(this).hasClass("svgNonInscri"))
        {
            // console.log("svgInscri entrant");
            $("#txtBtnRegister").text(" Voulez vous inscrire ?");
        }
        else
        {
            // console.log("svgNonInscri entrant");
            $("#txtBtnRegister").text(" Se desinscrire ?");
        }
    });

    $(".svgNonInscri").on("mouseover", function() {
        if($(this).hasClass("svgNonInscri"))
        {
            // console.log("svgInscri entrant")
            $("#txtBtnRegister").text(" Voulez vous inscrire ?");
        }
        else
        {
            // console.log("svgNonInscri entrant")
            $("#txtBtnRegister").text(" Se desinscrire ?");
        }
    });

    //Partie qui gèrent les événement en click
    //Partie qui gèrent les événement en click
    //Partie qui gèrent les événement en click

    $( ".svgNonInscri" ).on( "click", function() {
        if(estInscris==false && !premierClick)
        {
            // console.log("svgNonInscri");
            inscription($(this).attr("value"));
            estInscris=true;
        }
        else if(estInscris==true && !premierClick)
        {
            // console.log("svgInscri");
            desinscription($(this).attr("value"));
            estInscris=false;
        }
        if(premierClick)
        {
            premierClick=false;
            estInscris=true;
            inscription($(this).attr("value"));
        }
    });

    $(".svgInscri" ).on( "click", function() {

        if(estInscris==false && !premierClick)
        {
            // console.log("svgNonInscri");
            inscription($(this).attr("value"));
            estInscris=true;
        }
        else if(estInscris==true && !premierClick)
        {
            // console.log("svgInscri");
            desinscription($(this).attr("value"));
            estInscris=false;
        }
        if(premierClick)
        {
            premierClick=false;
            estInscris=false;
            desinscription($(this).attr("value"));
        }
    });

    // Méthodes inscription et désistement 
    // Méthodes inscription et désistement 
    // Méthodes inscription et désistement 

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
        $(".svgRegister").append('<span id="txtBtnRegister"> Vous êtes inscrit !</span>');

        $(".svgRegister").trigger('svgInscri');
    }

    function desinscription(idSorti)
    {
        $.ajax({
            url : adresseBase+"sorties/deleteinscription",
            type : "POST",
            data : {
                "idSortie": idSorti,
            },
        
            succes: function (res) {
               
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr); //Ce code affichera le message d'erreur, ici Message d'erreur.
                console.log(ajaxOptions);
                console.log(thrownError);
            }
        })
        $("#flashMessage").append("<div class='alert-success'>Vous n'êtes plus inscrit</div>");
        $(".svgRegister").removeClass( "svgInscri" ).addClass( "svgNonInscri" );

        $(".svgRegister").find("svg").remove();
        $(".svgRegister").find('#txtBtnRegister').remove();
        $(".svgRegister").append('<svg class="svgPerso" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9 19h-4v-2h4v2zm2.946-4.036l3.107 3.105-4.112.931 1.005-4.036zm12.054-5.839l-7.898 7.996-3.202-3.202 7.898-7.995 3.202 3.201zm-6 8.92v3.955h-16v-20h7.362c4.156 0 2.638 6 2.638 6s2.313-.635 4.067-.133l1.952-1.976c-2.214-2.807-5.762-5.891-7.83-5.891h-10.189v24h20v-7.98l-2 2.025z"/></svg>')
        $(".svgRegister").append('<span id="txtBtnRegister"> S\'inscrire</span>');
        
        $(".svgRegister").trigger('svgInscri');
    }
});