<!DOCTYPE html>
<html lang="en">
<head>
    <title>FilmBento / Lists</title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:light,lightitalic,regular,italic,500,500italic,bold,bolditalic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type ="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/humanity/jquery-ui.css">
</head>
<body>
    <div id="pageWrapper">
        <?php include ("header.php"); ?>
        <div id="editList">
            <a id="goBack" href="<?php echo $data['user']->getPath(); ?>">< my profile</a>
            <div id="options">
                <a href="/lists/add" class="button"><span class="plus icon"></span>Add a list to your profile</a>
            </div>
            <?php if (empty($data['lists'])) : ?>
            <div id="noListsActivated">You haven't activated any lists yet</div>
            <?php endif; ?>
            <?php foreach($data['lists'] as $list) : ?>
            <div class="list">
                <h1><a href ="#"><?php echo $list['name']; ?></a></h1>
                <a id="removeList" href="/?controller=ListController&function=deactivateList&list=<?php echo $list['id']; ?>">
                    X
                </a>
                <div class="body">
                    <ol>
                        <?php for ($i = 0; isset($list['films'][$i]); $i++) : ?>
                            <?php if (isset($list['films'][$i])) : ?>
                                <li id="recordsArray_<?php echo $list['films'][$i]['id']; ?>">
                                    <a href="<?php echo $list['films'][$i]['path']; ?>"><?php echo $list['films'][$i]['title']; ?></a>
                                    <form method="POST" action="" class ="removeFilm">
                                        <input type="hidden" name="controller" value="ListController">
                                        <input type="hidden" name="function" value="removeFromList">
                                        <input type="hidden" name="film" value="<?php echo $list['films'][$i]['id']; ?>">
                                        <input type="hidden" name="list" value="<?php echo $list['id']; ?>">
                                        <button class="negative button"><span class="cross icon"></span>remove</button>
                                    </form>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </ol>
                    <?php if (count($list['films']) < $list['maxEntries'] || $list['maxEntries'] == 0) : ?>
                        <li class="addFilm" style="height: 48px;">
                            <form method="POST" action="">
                                <input type="hidden" name="function" value="addToList">
                                <input type="hidden" name="list" value="<?php echo $list['id']; ?>">
                                <input type="text" name="film" class="tags">
                                <button class="button"><span class="plus icon"></span>add</button>
                            </form>
                        </li>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>   
        <?php include ROOT_PATH . '/include/views/footer.php'; ?>
    </div>
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
                        $('#editList').load('/?controller=ListController #editList', function () {
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

                $('#editList').load('/?controller=ListController #editList', function () {
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
                var user_id = <?php echo $data['user']->getID(); ?>;

                var url = "/?controller=API&function=userList&user=" + user_id + "&list=" + list_id;

                var onList = [];

                $.getJSON(url, function(data) {
                    $.each(data, function(i, item) {
                        onList.push(item);
                    });
                });

                $(this).autocomplete({
                    minLength: 3,

                    source: function(req, add){
                        var term = req.term;

                        url = "/?controller=API&function=search&query=" + term;

                        $.getJSON(url, function(data) {
                              var suggestions = [];
                              $.each(data, function(i,item) {
                                  for (x in onList) {
                                      if (item == onList[x]) {
                                          return;
                                      }
                                  }
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
 </body>
 </html>
