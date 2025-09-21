<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>MackAI - Liga de IA</title>
    
    <!-- Meta tags SEO -->
    <meta name="description" content="<?= $pageDescription ?? 'Liga Acadêmica de Ciência de Dados e Inteligência Artificial da Universidade Presbiteriana Mackenzie' ?>">
    <meta name="keywords" content="MackAI, Inteligência Artificial, Ciência de Dados, Mackenzie, Liga Acadêmica">
    <meta name="author" content="Liga MackAI">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= $pageTitle ?? 'MackAI - Liga de IA' ?>">
    <meta property="og:description" content="<?= $pageDescription ?? 'Liga Acadêmica de Ciência de Dados e IA' ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= BASE_URL . $_SERVER['REQUEST_URI'] ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= ASSETS_URL ?>/images/favicon.ico">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/main.css">
    <?php if (isset($additionalCSS)): ?>
        <?php foreach ($additionalCSS as $css): ?>
            <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/<?= $css ?>.css">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="/">Mack AI</a>
            </div>
            <ul class="nav-links">
                <li><a href="/" class="<?= $currentPage === 'home' ? 'active' : '' ?>">Início</a></li>
                <li><a href="/sobre" class="<?= $currentPage === 'about' ? 'active' : '' ?>">Sobre</a></li>
                <li><a href="/portfolio" class="<?= $currentPage === 'portfolio' ? 'active' : '' ?>">Portfólio</a></li>
                <li><a href="/encontros" class="<?= $currentPage === 'meetings' ? 'active' : '' ?>">Encontros</a></li>
                <li><a href="/contato" class="<?= $currentPage === 'contact' ? 'active' : '' ?>">Contato</a></li>
            </ul>
            
            <!-- Menu mobile -->
            <div class="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <!-- Conteúdo principal -->
    <main>
        <?php if (isset($content)): ?>
            <?= $content ?>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>MackAI</h3>
                <p>Liga Acadêmica de Ciência de Dados e Inteligência Artificial da Universidade Presbiteriana Mackenzie.</p>
            </div>
            
            <div class="footer-section">
                <h4>Links Rápidos</h4>
                <ul>
                    <li><a href="/sobre">Sobre Nós</a></li>
                    <li><a href="/portfolio">Portfólio</a></li>
                    <li><a href="/encontros">Encontros</a></li>
                    <li><a href="/contato">Contato</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Contato</h4>
                <p>📧 contato@mackai.com.br</p>
                <p>🏫 Universidade Presbiteriana Mackenzie</p>
            </div>
            
            <div class="footer-section">
                <h4>Redes Sociais</h4>
                <div class="social-links">
                    <a href="#" aria-label="Instagram">📷</a>
                    <a href="#" aria-label="LinkedIn">💼</a>
                    <a href="#" aria-label="GitHub">💻</a>
                    <a href="#" aria-label="YouTube">📺</a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> MackAI. Todos os direitos reservados.</p>
            <p>Desenvolvido com ❤️ pela Liga MackAI</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="<?= ASSETS_URL ?>/js/main.js"></script>
    <?php if (isset($additionalJS)): ?>
        <?php foreach ($additionalJS as $js): ?>
            <script src="<?= ASSETS_URL ?>/js/<?= $js ?>.js"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Scripts inline -->
    <?php if (isset($inlineJS)): ?>
        <script><?= $inlineJS ?></script>
    <?php endif; ?>
</body>
</html>
