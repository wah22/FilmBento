<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
   <link rel="stylesheet" type ="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/humanity/jquery-ui.css">
 </head>
 <body>
    <?php include ("header.php"); ?>

    <?php foreach($data['user']->getLists() as $list) : ?>

    <div class="list">
        <a href ="#"><?php echo $list->getName(); ?></a><br>

        <div class="body">
            <div id="editList">
                <ol>
                    <?php $seens = $list->getSeens(); ?>
                    <?php for ($i = 0; $i < 10; $i++) : ?>
                        <?php if (isset($seens[$i])) : ?>
                            <li id="recordsArray_<?php echo $seens[$i]->getFilm()->getID() ?>">
                                <?php echo $seens[$i]->getFilm()->getTitle(); ?>
                                <form method="GET" action="">
                                    <input type="hidden" name="controller" value="ListController">
                                    <input type="hidden" name="function" value="removeFromList">
                                    <input type="hidden" name="film" value="<?php echo $seens[$i]->getFilm()->getID(); ?>">
                                    <input type="hidden" name="list" value="<?php echo $list->getID(); ?>">
                                    <input type="submit" value="remove">
                                </form>
                             </li>
                        <?php endif; ?>
                     <?php endfor; ?>
                </ol>

                <?php if (count($seens) < 10) : ?>
                    <div id="addFilm">
                        <form method="POST" action="/?controller=ListController">
                            <input type="hidden" name="list" value="<?php echo $list->getID(); ?>">
                            <input type="text" name="film" class="tags">
                            <input type="submit" value="Add">
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

     <?php endforeach; ?>

    <?php include "footer.php"; ?>
 </body>
 </html>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script>
    $(function() {
        $("#editList ol").sortable({ opacity: 0.6, cursor: 'move', update: function() {
                var order = $(this).sortable("serialize");
                $.post("/?controller=ListController&list=1&function=sort", order, function(theResponse){
                });
        }
        });

        $("#addFilm").submit(function() {
            var list = $('#addFilm input[name=list]').val();
            var film = $('#addFilm input[name=film]').val();
            var url = "/?controller=ListController&function=addToList&list=" + list + "&film=" + film;

            $.ajax(url);
        })

        $("div.body").hide();

        $(".list a").click(function() {
            if ( ! $(this).parent().find('div.body').is(':visible') ) {
                $(this).parent().find('div.body').slideDown("slow");
            } else {
                $(this).parent().find('div.body').slideUp("slow");
            }
            return false;
        })

        $( ".tags" ).autocomplete({
            source: function(req, add){
                var term = req.term;

                var url = "/?controller=FilmController&function=searchSeens&user=1&query=" + term;

                $.getJSON(url, function(data) {
                      var suggestions = [];
                      $.each(data, function(i,item){
                        suggestions.push(item);
                     });
                     add(suggestions);
                })
            }
        });
    });
</script>
