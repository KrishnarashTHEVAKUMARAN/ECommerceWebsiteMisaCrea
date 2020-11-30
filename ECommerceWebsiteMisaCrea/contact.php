<?php
require_once("header.php");
?>
</br></br></br></br></br></br>

<p align="center"><strong><span class="border">Contact</span></strong></p>
<p align="center"><strong><span class="border">Envoyer un message </span></strong></p>

<table width="500" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#dbf5eb">
<form action="envoiContact.php" method="post" enctype="application/x-www-form-urlencoded" name="formulaire">

<tr>
<td><div align="left"><font size="2.5">Votre nom: </font></div></td>
<td colspan="3"><input type="text" name="nom" size="66" maxlength="150" required></td>
</tr>

<tr>
<td width="20%"><div align="left"><font size="2.5">Votre mail: </font></div></td>
<td colspan="3"><input type="email" name="mail" size="66" maxlength="150" required></td>
</tr>

<tr>
<td><div align="left"><font size="2.5">Sujet: </font></div></td>
<td colspan="3"><input type="text" name="objet" size="66" maxlength="150" required></td>
</tr>

<tr>
<td><div align="left"><font size="2.5">Message: (Max 300 caract&eacute;res)</font></div></td>
<td colspan="3"><textarea name="message" cols="50" rows="10" maxlength="300" required></textarea></td>
</tr>

<tr>
<td></td>
<td width="42%"><center>
<input type="reset" name="Submit" value="Réinitialiser le formulaire">
</center></td>
<td width="41%"><center>
<input type="submit" name="Submit" value="Envoyer">
</center></td>
</tr>

</form>
</table>
</br></br></br></br></br></br></br></br></br></br></br></br></br></br>
<?php
require_once("footer.php");
?>