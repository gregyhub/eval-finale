<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form id="vehicule" action="#" method="POST">

        <p><label for="marque">Marque</label>
        <input type="text" name="marque" id="marque"></p>

        <p><label for="modele">Modèle</label>
        <input type="text" name="modele" id="modele"></p>

        <p><label for="annee">Année</label>
        <input type="text" name="annee" id="annee"></p>

        <p><label for="couleur">Couleur</label>
        <input type="text" name="couleur" id="couleur"></p>

        <p><input type="submit" value="valider"></p>
    </form>
    <div class="msg"></div>


    <table>
        <tr>
            <th>id</th>
            <th>Marque</th>
            <th>Modele</th>
            <th>Année</th>
            <th>Couleur</th>
        </tr>
        <tbody class="insert">
            <tr>
                <td class='vide' colspan="5">Aucun véhicule à afficher</td>
            </tr>
        </tbody>
    </table>


    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    <script src="monJS.js"></script>
</body>
</html>