<header id="header">
    <div class="content">
        <!-- Logo -->
        <div id="logo">
            <a href="#"><img src="<?php echo IMG_PATH; ?>/logo.png" alt="Logo"></a>
        </div>

        <!-- Navegação -->
        <nav id="nav">
            <button aria-label="Abrir Menu" id="btn-mobile" aria-haspopup="true" aria-controls="menu" aria-expanded="false">
                <span id="hamburger"></span>
            </button>

            <ul id="menu" role="menu">
                <li><a href="#">Início</a></li>

                <li class="submenu">
                    <a href="#">Cadastros</a>
                    <ul class="children">
                        <li><a href="../pages/cadastros/funcionario.php">Funcionário</a></li>
                        <li><a href="../pages/cadastros/servico.php">Serviços</a></li>
                        <li><a href="../pages/cadastros/usuario.php">Usuários</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#">Movimentações</a>
                    <ul class="children">
                        <li><a href="../pages/movimentacoes/registros.php">Registros</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#">Relatórios</a>
                    <ul class="children">
                        <li><a href="../pages/relatorios/funcionario.php">Funcionários</a></li>
                        <li><a href="../pages/relatorios/servico.php">Serviços</a></li>
                        <li><a href="../pages/relatorios/usuario.php">Usuários</a></li>
                        <li><a href="../pages/relatorios/registros.php">Registros</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#">Pesquisas</a>
                    <ul class="children">
                        <li><a href="../pages/pesquisar/funcionarios.php">Funcionários</a></li>
                        <li><a href="../pages/pesquisar/servicos.php">Serviços</a></li>
                        <li><a href="../pages/pesquisar/usuarios.php">Usuários</a></li>
                        <li><a href="../pages/pesquisar/registros.php">Registros</a></li>
                    </ul>
                </li>

                <li><a href="../pages/ajuda/ajuda.pdf" target="_blank">Ajuda</a></li>
                <li><a href="/gil/login/logout.php">Sair</a></li>
            </ul>
        </nav>
    </div>
</header>
