<html>
    <head>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

    </head>
    <body>
        <h1>Novo Formulário</h1>
        <hr/>
        <form method="post" action="<?= base_url("index.php/NovoFormulario") ?>">
            <label for="txt_nome">Nome do Formulário: </label>
            <input type="text" id="txt_nome" name="txt_nome" />
            <br/>
            <label >Tipo de Formulário: </label>
            <select name="group_group">
                <option value="1">Opção 1</option>
                <option value="2">Opção 2</option>
            </select>

            <br/>
            <label for="question_name">Enunciado Pergunta: </label>
            <input type="text" id="question_name" name="question_name" />
            <br/>

            <label >Tipo de Pergunta: </label>
            <select name="question_type" id="question_type">
                <option value="">--SELECIONE--</option>
                <option value="1">text</option>
                <option value="2">checkbox</option>
                <option value="3">radio</option>
                <option value="4">checkbox+text</option>
                <option value="5">radio+text</option>
            </select>
            <div id="question_item_container">
            </div>

            <br/>
            <button type="reset">Limpar</button>
            <button type="submit">Criar</button>
        </form>
    </body>
    <script type="text/javascript" src="<?= base_url('js/form_functions.js') ?>"></script>

</html>