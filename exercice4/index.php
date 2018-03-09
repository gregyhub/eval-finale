<?php
require_once 'Chat.class.php';

$infos1=[
            'prenom'    =>  'Kissa',
            'age'       =>  5,
            'couleur'   =>  'maron',
            'sexe'      =>  'femelle',
            'race'      =>  'la plus belle race'
        ];
$infos2=[
            'prenom'    =>  'Treize',
            'age'       =>  10,
            'couleur'   =>  'blanc',
            'sexe'      =>  'male',
            'race'      =>  'angora'
        ];
$infos3=[
            'prenom'    =>  'Scarface',
            'age'       =>  12,
            'couleur'   =>  'roux',
            'sexe'      =>  'male',
            'race'      =>  'batard'
        ];
try{
    $chatDeGreg = new Chat($infos1);
    $infosChats[] = $chatDeGreg->getInfo();
    $chatDeOlivia = new Chat($infos2);
    $infosChats[] = $chatDeOlivia->getInfo();
    $chatDeCaro = new Chat($infos3);
    $infosChats[] = $chatDeCaro->getInfo();

?>
    <table>
        <tr>
            <th>Prenom</th>
            <th>Age</th>
            <th>Couleur</th>
            <th>Sexe</th>
            <th>Race</th>
        </tr>
            <?php foreach($infosChats as $chat): ?>
            <tr>
                <?php foreach($chat as $val): ?>
                <td><?= $val ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
    </table>
<?php

}
catch(Exception $e) {
    echo 'Exception reçue : ',  $e->getMessage(), "\n";
}
