<!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="utf-8">
   <title></title>
   <link rel="stylesheet" type="text/css" href="/css/main.css">
   <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/smoothness/jquery-ui.css">
 </head>
 <body>
     <?php include ("header.php"); ?>
     <?php include('navbar.php'); ?>

    <h1><?php echo $data['list']->getName(); ?></h1><br>
    <input type ="hidden" name ="listID" value="<?php echo $data['list']->getID(); ?>">

    <div id="editList">
        <ul>
            <?php $seens = $data['list']->getSeens(); ?>
            <?php for ($i = 0; $i < 10; $i++) : ?>
                <?php if (isset($seens[$i])) : ?>
                    <li id="recordsArray_<?php echo $seens[$i]->getFilm()->getID() ?>">
                        <?php echo $seens[$i]->getFilm()->getTitle(); ?>
                        <form method="GET" action="">
                            <input type="hidden" name="controller" value="ListController">
                            <input type="hidden" name="function" value="removeFromList">
                            <input type="hidden" name="film" value="<?php echo $seens[$i]->getFilm()->getID(); ?>">
                            <input type="hidden" name="list" value="<?php echo $data['list']->getID(); ?>">
                            <input type="submit" value="remove">
                        </form>
                     </li>

                 <?php else : ?>

                <?php endif; ?>
             <?php endfor; ?>
        </ul>

        <div id="addFilm">
            <form method="GET" action="">
                <input type="hidden" name="controller" value="ListController">
                <input type="hidden" name="function" value="addToList">
                <input type="hidden" name="list" value="<?php echo $data['list']->getID(); ?>">
                <input type="text" name="film" id="tags">
                <input type="submit">
            </form>
        </div>
    </div>

</body>
 </html>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script>
    $(function() {
            var availableTags = <?php echo json_encode($data['films']); ?>;
            $( "#tags" ).autocomplete({
                    source: availableTags
            });
    });
</script>
<script>
$(document).ready(function(){
	$(function() {
		$("#editList ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize");
			$.post("/?controller=ListController&list=<?php echo $data['list']->getID(); ?>&function=sort", order, function(theResponse){
				// $("#contentRight").html(theResponse);
			});
		}
		});
	});

});
</script>