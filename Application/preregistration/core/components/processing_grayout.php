<?php
//Creates loading animation that grays out the screen when triggered (usually after a submit button is pressed)
?>
<div id='locking_overlay' class="throbber_screen_locker">
</div>

<div id="throbber_overlay" class="throbber">
    <img src="/<?php echo BASE_DIRECTORY; ?>/images/<?php echo $_SESSION['icon_set']; ?>/throbber.gif">
</div>

<script>
document.getElementById('throbber_overlay').style.visibility = 'hidden';
document.getElementById('locking_overlay').style.visibility = 'hidden';

function show_loading_div()
{
    document.getElementById('locking_overlay').style.visibility = 'visible';
    document.getElementById('throbber_overlay').style.visibility = 'visible';
}
</script>