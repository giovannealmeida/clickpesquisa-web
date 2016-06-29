<?php 
echo validation_errors(); 
if (isset($status) && !$status){
?>
<p>O CPF ou Senha não correspondem</p>
<?php
}
?>

<form action="<?=  base_url("index.php/login")?>" method="post">
    <label>CPF: </label><input type="text" name="cpf" id="cpf"/>
    <br/>
    <label>SENHA: </label><input type="password" name="senha" id="senha"/>
    <br/>
    <button type="submit">ACESSAR</button>
</form>
