<div class="HeaderBanner">
<?php echo GLOBAL_PROJECT_NAME;?><span>&nbsp;</span>
</div>
<div class='HeaderMenu'>
    <table width="100%">
    <tr>
        <td class="menu" width="100"> <a <?php echo $target;?> class="menu" href="/<?php echo BASE_DIRECTORY;?>/main.php">  HOME  </a> </td>
        <td class="menu" width="100"> <a <?php echo $target;?> class="menu" href="/<?php echo BASE_DIRECTORY;?>/change_password.php">  PASSWORD  </a> </td>
        <td class="menu" width="100"> <a <?php echo $target;?> class="menu" href="/<?php echo BASE_DIRECTORY;?>/change_skin.php">  SKIN  </a> </td>
        <td class="menu" width="100"> <a <?php echo $target;?> class="menu" href="/<?php echo BASE_DIRECTORY;?>/about.php">  ABOUT  </a> </td>
        <td class="menu" width="100"> <a <?php echo $target;?> class="menu" href="/<?php echo BASE_DIRECTORY;?>/help/contents.php">  HELP  </a> </td>
        <td align="right"><span class="text-normal">You are logged in as</span> <span class="text-info"><?php echo htmlentities($_SESSION['user'], ENT_COMPAT, MULTI_BYTE_ENCODING);?></span>&nbsp;</td>
        <td class="menu" width="75"> <a target="_parent" onClick="return confirm('Are you sure you wish to logout?')" href='/<?php echo BASE_DIRECTORY;?>/end.php' class="menu">  [LOGOUT]  </a> </td>
    </tr>
    </table>
</div>