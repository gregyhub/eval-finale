$(function(){

    //démarage du site / affichage du tableau de données véhicule
    function afficheVehicule(){
        $.post('ajax.php','action=affiche',function(donnees){
            //traitement de la réponse
            if(donnees.resultat === true){
                var tab='';
                donnees.vehicules.forEach(vehicule => {
                    tab += '<tr>';
                        tab += '<td>'+vehicule.id+'</td>';
                        tab += '<td>'+vehicule.marque+'</td>';
                        tab += '<td>'+vehicule.modele+'</td>';
                        tab += '<td>'+vehicule.annee+'</td>';
                        tab += '<td>'+vehicule.couleur+'</td>';
                    tab += '</tr>';
                });
                $('.insert').html(tab);
            }
        }, 'json')
    }

    afficheVehicule();


    //soumission du formulaire
    $('#vehicule').on('submit', function(e){
        e.preventDefault(); //j'annule l'envoie du formulaire
        $('.msg').html(); //j'efface tout dans la div msg



        //je constitue mon paramètre
        var params='action=insert';
        var erreurForm='';
        if($('#marque').val().length==0){
            erreurForm += '<div class="alert alert-danger" role="alert">la marque ne peut pas être vide</div>';
        }else{
            params += '&marque='+$('#marque').val();
        }
        if($('#modele').val().length==0){
            erreurForm += '<div class="alert alert-danger" role="alert">le modèle ne peut pas être vide</div>';
        }else{
            params += '&modele='+$('#modele').val();
        }
        if($('#annee').val().length==0){
            erreurForm += '<div class="alert alert-danger" role="alert">l\'annee ne peut pas être vide</div>';
        }else{
            params += '&annee='+$('#annee').val();
        }
        if($('#couleur').val().length==0){
            erreurForm += '<div class="alert alert-danger" role="alert">la couleur ne peut pas être vide</div>';
        }else{
            params += '&couleur='+$('#couleur').val();
        }
        if(erreurForm.length==0){
            //si affieResultat est = 0 alors ca veut dire qu'il n'y a pas d erreur
            //j'envoie ma requete ajax
            $.post('ajax.php',params,function(donnees){
                //traitement de la réponse
                if(donnees.resultat === true){
                    afficheResultat = '<div class="alert alert-success" role="alert">vous avez ajouté le vehicule avec success !</div>';
                    //je remet à 0 les données du formulaire
                    $('input[type=text]').val('');
                    afficheVehicule(); // pour actualiser le résultat
                }
                else{
                    afficheResultat = '<div class="alert alert-danger" role="alert">une erreur est survenue lors de l\'ajout du véicule !</div>';
                }
                $('.msg').html(afficheResultat);
            }, 'json')
        }else{
            $('.msg').html(erreurForm);
        }
        //affichage du message dans la page

    }); //fin de l'event

}) //fin du document ready
