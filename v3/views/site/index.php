<?php

/* @var $this yii\web\View */

$this->registerJsFile("js/feed.js", ['position' => $this::POS_END]);
$this->registerJsFile("js/post.js", ['position' => $this::POS_END]);
$this->registerCssFile("css/feed.css");

?>
<navbar>
    <ul>
        <li data-type="popular" class="selected"><a href="#">Popular</a></li>
        <li data-type="tendencia"><a href="#">Tendencia</a></li>
        <li data-type="nuevo"><a href="#">Nuevo</a></li>
    </ul>
</navbar>

<article data-types="popular,tendencia" data-tags="anime">
    <div class="ui fluid raised card">
        <div class="content">
            <div class="ui left floated">
                <a href="#"><img class="ui custom avatar image" src="media/avatars/pp.jpg" onclick=""> <b> hayasaca</a></b>
            </div>
            <div class="right floated meta">Hace 8 minutos</div>
        </div>
        <div class="content post-title">
            <div class="header">mfw</div>
        </div>
        <a class="image" href="comments.html">
            <img src="media/posts/post.jpg" alt="">
        </a>	
        <div class="content">
            <span class="left floated">
                <i class="comments outline icon"></i>
                64 comentarios
            </span>
            <span class="right floated">
                <i class="thumbs up outline icon"></i>
                279 me gusta
            </span>
        </div>
        <div class="extra content">
            <div class="ui fluid five item grid container secondary compact text options-section menu">
                <div class="item like-button" onclick= "iconPressed(this, '.dislike-button');" data-state="0">
                    <i class="thumbs up icon"></i>
                </div>
                <div class="item dislike-button" onclick= "iconPressed(this, '.like-button');" data-state="0">
                    <i class="thumbs down icon"></i>
                </div>
                <div class="item comment-button" onclick= "window.location= 'comments.html'">
                    <i class="comments icon"></i>
                </div>
                <div class="item facebook-button" onclick= "window.open('https://www.facebook.com/sharer.php?t=Me reí&u=me.me')">
                    <i class="facebook icon"></i>
                </div>
                <div class="item twitter-button" onclick= "window.open('https://twitter.com/intent/tweet?text=Me reí&url=http%3A%2F%2Fme.me')">
                    <i class="twitter icon"></i>
                </div>
            </div>
            <div class="ui fluid container comment-section">
                <img class="ui left floated item avatar image" src="media/avatars/pp.jpg" onclick="">
                <form class= "ui item unstackable form" onsubmit= "return comentar(event, this)">
                    <div class="inline fields">
                        <div class="twelve wide field">
                            <input type="text" name= "comentario" class= "comment-box" 
                            placeholder= "Comenta algo gracioso..." required maxlength= "280">
                        </div>
                        <div class="field">
                            <button type= "submit" class= "ui green button">
                                <i class= "send icon"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>

<article data-types="tendencia,nuevo" data-tags="wholesome">
    <div class="ui fluid raised card">
        <div class="content">
            <div class="ui left floated">
                <a href="#"><img class="ui custom avatar image" src="media/avatars/pp.jpg" onclick=""> <b> hayasaca</a></b>
            </div>
            <div class="right floated meta">Hace 13 minutos</div>
        </div>
        <div class="content post-title">
            <div class="header">had a good day</div>
        </div>
        <a class="image" href="comments.html">
            <img src="media/posts/post2.jpg" alt="">
        </a>	
        <div class="content">
            <span class="left floated">
                <i class="comments outline icon"></i>
                13 comentarios
            </span>
            <span class="right floated">
                <i class="thumbs up outline icon"></i>
                29 me gusta
            </span>
        </div>
        <div class="extra content">
            <div class="ui fluid five item grid container secondary compact text options-section menu">
                <div class="item like-button" onclick= "iconPressed(this, '.dislike-button');" data-state="0">
                    <i class="thumbs up icon"></i>
                </div>
                <div class="item dislike-button" onclick= "iconPressed(this, '.like-button');" data-state="0">
                    <i class="thumbs down icon"></i>
                </div>
                <div class="item comment-button" onclick= "window.location= 'comments.html'">
                    <i class="comments icon"></i>
                </div>
                <div class="item facebook-button" onclick= "window.open('https://www.facebook.com/sharer.php?t=Me reí&u=me.me')">
                    <i class="facebook icon"></i>
                </div>
                <div class="item twitter-button" onclick= "window.open('https://twitter.com/intent/tweet?text=Me reí&url=http%3A%2F%2Fme.me')">
                    <i class="twitter icon"></i>
                </div>
            </div>
            <div class="ui fluid container comment-section">
                <img class="ui left floated item avatar image" src="media/avatars/pp.jpg" onclick="">
                <form class= "ui item unstackable form" onsubmit= "return comentar(event, this)">
                    <div class="inline fields">
                        <div class="twelve wide field">
                            <input type="text" name= "comentario" class= "comment-box" 
                            placeholder= "Comenta algo gracioso..." required maxlength= "280">
                        </div>
                        <div class="field">
                            <button type= "submit" class= "ui green button">
                                <i class= "send icon"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>

<article data-types="nuevo,popular" data-tags="videos,wholesome,animales">
    <div class="ui fluid raised card">
        <div class="content">
            <div class="ui left floated">
                <a href="#"><img class="ui custom avatar image" src="media/avatars/pp.jpg" onclick=""> <b> hayasaca</a></b>
            </div>
            <div class="right floated meta">Hace 20 minutos</div>
        </div>
        <div class="content post-title">
            <div class="header">LOL ded</div>
        </div>
        <video src="media/posts/post3.webm" controls>
        </video>
        <div class="content">
            <span class="left floated">
                <i class="comments outline icon"></i>
                153 comentarios
            </span>
            <span class="right floated">
                <i class="thumbs up outline icon"></i>
                66 me gusta
            </span>
        </div>
        <div class="extra content">
            <div class="ui fluid five item grid container secondary compact text options-section menu">
                <div class="item like-button" onclick= "iconPressed(this, '.dislike-button');" data-state="0">
                    <i class="thumbs up icon"></i>
                </div>
                <div class="item dislike-button" onclick= "iconPressed(this, '.like-button');" data-state="0">
                    <i class="thumbs down icon"></i>
                </div>
                <div class="item comment-button" onclick= "window.location= 'comments.html'">
                    <i class="comments icon"></i>
                </div>
                <div class="item facebook-button" onclick= "window.open('https://www.facebook.com/sharer.php?t=Me reí&u=me.me')">
                    <i class="facebook icon"></i>
                </div>
                <div class="item twitter-button" onclick= "window.open('https://twitter.com/intent/tweet?text=Me reí&url=http%3A%2F%2Fme.me')">
                    <i class="twitter icon"></i>
                </div>
            </div>
            <div class="ui fluid container comment-section">
                <img class="ui left floated item avatar image" src="media/avatars/pp.jpg" onclick="">
                <form class= "ui item unstackable form" onsubmit= "return comentar(event, this)">
                    <div class="inline fields">
                        <div class="twelve wide field">
                            <input type="text" name= "comentario" class= "comment-box" 
                            placeholder= "Comenta algo gracioso..." required maxlength= "280">
                        </div>
                        <div class="field">
                            <button type= "submit" class= "ui green button">
                                <i class= "send icon"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>