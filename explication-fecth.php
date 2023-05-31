<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <style>
      .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
      }

      /* Modal Content */
      .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
      }

      /* The Close Button */
      .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
      }

      .close:hover,
      .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
      }

      .modal.visible {
        display: block;
      }
    </style>


  </head>
  <body>
    <form>
      <div class="field">
        <label for=""></label>
        <input id="nom" type="text" />
      </div>

      <label>Marque</label>
      <select id="selectMarques">
        <?php

        try{

          include_once 'bdd.php';

          $requete = $bdd->prepare( "SELECT * FROM marques");

          $requete->execute();

          $listeMarque = $requete->fetchAll();

          foreach($listeMarque as $marque) {
             echo '<option value="'.$marque['nom'].'">'.$marque['nom'].'</option>';
          }

      } catch (PDOException $e) {
          echo 'Echec de la connexion : ' . $e->getMessage();
          exit;
      }
      ?>
      </select>
      <button type="button" onclick="onAfficherAjoutMarque()">+</button>
    </form>


    <div id="modalAjoutMarque" class="modal">

    <div class="modal-content">
      <span id="closeModal">&times;</span>
      <form onsubmit="return onAjoutMarque()">
        <div class="field">
          <label for="nomMarque"></label>
          <input id="nomMarque" type="text" />
        </div>
        <button type="submit">Ajouter la marque</button>
      </form>
      </div>
    </div>
  </body>

  <script>
    function onAjoutMarque() {
      const inputNomNouvelleMarque = document.querySelector("#nomMarque");
      const nomNouvelleMarque = inputNomNouvelleMarque.value;

      const nouvelleMarque = { nom: nomNouvelleMarque };
      const jsonNouvelleMarque = JSON.stringify(nouvelleMarque);

      fetch("http://localhost/explication-fetch/ajout-marque.php", {
        method: "POST",
        body: jsonNouvelleMarque,
      })
        .then((reponse) => reponse.json())
        .then((listeMarque) => {
          const selectMarques = document.querySelector("#selectMarques");
          selectMarques.innerHTML = "";
          for (let marque of listeMarque) {
            selectMarques.innerHTML += `<option value="${marque.id}">${marque.nom}</option>`;
          }

          selectMarques
            .querySelector("option:last-child")
            .setAttribute('selected','selected'); 

          inputNomNouvelleMarque.value = ""
          modalAjoutMarque.classList.remove('visible')

        });

      return false; //pour que la page ne se recharge pas
    }

    function onAfficherAjoutMarque() {
       modalAjoutMarque.classList.add('visible');
    }

    const modalAjoutMarque = document.querySelector("#modalAjoutMarque");

    // Get the <span> element that closes the modal
    const close = document.querySelector("#closeModal");

      // When the user clicks on <span> (x), close the modal
      close.addEventListener('click',e =>
        modalAjoutMarque.classList.remove('visible'))

      // When the user clicks anywhere outside of the modal, close it
      window.addEventListener('click',e => {
        if (event.target == modalAjoutMarque) {
          modalAjoutMarque.classList.remove('visible')
        }
      })

  </script>
</html>
