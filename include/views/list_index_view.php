<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type ="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/humanity/jquery-ui.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include ("header.php"); ?>

        <div id="editList">

            <?php foreach($data['lists'] as $list) : ?>

            <div class="list">
                <h1><a href ="#"><?php echo $list['name']; ?></a></h1>
                <a id="removeList" href="/?controller=ListController&function=deactivateList&list=<?php echo $list['id']; ?>">remove</a>

                <div class="body">
                    <ol>
                        <?php for ($i = 0; $i < 10; $i++) : ?>
                            <?php if (isset($list['films'][$i])) : ?>
                                <li id="recordsArray_<?php echo $list['films'][$i]['id']; ?>">
                                    <?php echo $list['films'][$i]['title']; ?>
                                    <form method="POST" action="" class ="removeFilm">
                                        <input type="hidden" name="controller" value="ListController">
                                        <input type="hidden" name="function" value="removeFromList">
                                        <input type="hidden" name="film" value="<?php echo $list['films'][$i]['id']; ?>">
                                        <input type="hidden" name="list" value="<?php echo $list['id']; ?>">
                                        <input type="submit" value="x">
                                    </form>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </ol>

                    <?php if (count($list['films']) < 10) : ?>
                        <li class="addFilm">
                            <form method="POST" action="">
                                <input type="hidden" name="controller" value="ListController">
                                <input type="hidden" name="function" value="addToList">
                                <input type="hidden" name="list" value="<?php echo $list['id']; ?>">
                                <input type="text" name="film" class="tags">
                                <input type="submit" value="+">
                            </form>
                        </li>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        Activate another list:
        <?php foreach ($data['allLists'] as $list) : ?>
        <p>
            <a href = "/?controller=ListController&function=activateList&list=<?php echo $list->getID(); ?>">
                <?php echo $list->getName(); ?>
            </a>
        </p>
        <?php endforeach; ?>

        <?php include "footer.php"; ?>
    </div>
 </body>
 </html>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script>
    $(function() {

        //$("div.body").hide();

        setUpAutocomplete();
        setUpSortable();
        setUpSlideable();

        $(".addFilm").live('submit', function() {
            var list = $(this).find('input[name=list]').val();
            var film = $(this).find('input[name=film]').val();
            var url = "/?controller=ListController&function=addToList&list=" + list + "&film=" + encodeURI(film);

            $.ajax({
                url: url,
                success: function(data) {
                    $('#editList').load('/?controller=ListController .list', function () {
                        setUpAutocomplete();
                        setUpSortable();
                        setUpSlideable();
                    });
                }
                });

            return false;
        })

        $(".removeFilm").live('submit' ,function() {
            var list = $(this).parent().find('input[name=list]').val();
            var film = $(this).parent().find('input[name=film]').val();
            var url = "/?controller=ListController&function=removeFromList&list=" + list + "&film=" + film;

            $.ajax({url: url,
                    success: function(data) {
                        
                    }});
            
            $('#editList').load('/?controller=ListController .list', function () {
                setUpAutocomplete();
                setUpSortable();
                setUpSlideable();
            });
            
            return false;
        })
    });

    function setUpAutocomplete() {

        $(".tags").each(function(){
            var list_id = $(this).parent().find('input[name=list]').val();

            var url = "/?controller=API&function=userList&user=1&list=1";

            $.getJSON(url, function(data) {
                var onList = [];
                $.each(data, function(i, item) {
                    onList.push(item);
                });
            });

            $(this).autocomplete({
                source: function(req, add){
                    var term = req.term;

                    url = "/?controller=API&function=search&query=" + term;

                    $.getJSON(url, function(data) {
                          var suggestions = [];
                          $.each(data, function(i,item) {

                            suggestions.push(item);
                         });
                         add(suggestions);
                    })
                }
            });
        });
    }

    function setUpSortable() {
        $(".list ol").sortable({ opacity: 1.0, cursor: 'move', update: function() {
            var order = $(this).sortable("serialize");
            $.post("/?controller=ListController&list=1&function=sort", order, function(theResponse){
            });
        }
        });
    }

    function setUpSlideable() {
        $(".list h1").click(function() {
            if ( ! $(this).parent().find('div.body').is(':visible') ) {
                $(this).parent().find('div.body').slideDown("slow");
            } else {
                $(this).parent().find('div.body').slideUp("slow");
            }
            return false;
        }) 
    }
</script>
