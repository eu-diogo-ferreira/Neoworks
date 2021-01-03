<?php

$alertaLogin = strlen($alertaLogin) ? '<div class="alert alert-danger">'.$alertaLogin.'</div>' : '';
$alertaCadastro = strlen($alertaCadastro) ? '<div class="alert alert-danger">'.$alertaCadastro.'</div>' : '';

?>

<div class="jumbotron">

    <div class="row">
        <div class="col">

            <form action="" method="post">
                <h2>Login</h2>

                <?=$alertaLogin;?>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="senha" id="" class="form-control" required>
                </div>

                <div class="form-group">                
                    <button type="submit" name="acao" value="logar" class="btn btn-primary">Entrar</button>
                </div>
            </form>

        </div>

        <div class="col">
        
            <form action="" method="post">
                <h2>Cadastre-se</h2>

                <?=$alertaCadastro;?>

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" id="" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="senha" id="" class="form-control" required>
                </div>

                <div class="form-group">                
                    <button type="submit" name="acao" value="cadastrar" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>

        </div>
    </div>

</div>