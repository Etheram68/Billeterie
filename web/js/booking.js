  $(document).ready(function() {
    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#AppBundle_books_tickets');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;
      var d = new Date();
      var hour = d.getHours();
      var day = d.getDate();
      var month = d.getMonth() + 1;
      var year = d.getFullYear();
      if (day < 10) {
          day = "0" + day;
      }
      if (month < 10) {
          month = "0" + month;
      }
      var today = day + "/" + month + "/" + year;

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_ticket').click(function(e) {
      addCategory($container);
        manageTypeTickets();

    $( ".datepicker" ).datepicker({
			showOn: "focus",
			buttonImage: "images/general/calendar.gif",
                        maxDate: -1,
			buttonImageOnly: false,
			changeMonth: true,
			changeYear: true,
			showWeek: true,
   			beforeShowDay: '',
			showAnim: "show"
		});


      e.preventDefault(); // évite qu'un # apparaisse dans l'URL
      return false;

    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    if (index == 0) {
      addCategory($container);
    } else {
      // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
      $container.children('div').each(function() {
        addDeleteLink($(this));
      });



    }

      function manageTypeTickets()
      {

          var inputWatched = $('.datepicker-book').val();
          var a = $('.typePick option[value=1]');
          var b = $('.typePick option[value=0]');

          if (hour >= 14 && inputWatched === today)
          {

              a.prop( "disabled", true );
              b.prop("selected", true);
          }
          else
              a.prop( "disabled", false );

      }
    // La fonction qui ajoute un formulaire CategoryType
    function addCategory($container) {
      // Dans le contenu de l'attribut « data-prototype », on remplace :
      // - le texte "__name__label__" qu'il contient par le label du champ
      // - le texte "__name__" qu'il contient par le numéro du champ
      var template = $container.attr('data-prototype')
        .replace(/__name__label__/g, 'Billet n°' + (index+1))
        .replace(/__name__/g,        index)
      ;

      // On crée un objet jquery qui contient ce template
      var $prototype = $(template);

      // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
      addDeleteLink($prototype);

      // On ajoute le prototype modifié à la fin de la balise <div>
      $container.append($prototype);

      // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
      index++;
    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
      // Création du lien
      var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');

      // Ajout du lien
      $prototype.append($deleteLink);

      // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
      $deleteLink.click(function(e) {
        $prototype.remove();

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
      });
    }

    $( ".datepicker" ).datepicker({
			showOn: "focus",
			buttonImage: "images/general/calendar.gif",
                        maxDate: -1,
			buttonImageOnly: false,
			changeMonth: true,
			changeYear: true,
			showWeek: true,
   			beforeShowDay: '',
			showAnim: "show"
		});

  });

