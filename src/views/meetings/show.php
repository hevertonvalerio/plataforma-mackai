<!-- Breadcrumb -->
<section style="background-color: var(--gray-100); padding: 1rem 0;">
    <div class="container">
        <nav style="font-size: 0.9rem; color: var(--gray-600);">
            <a href="/" style="color: var(--gray-600);">Início</a> 
            <span style="margin: 0 0.5rem;">›</span>
            <a href="/encontros" style="color: var(--gray-600);">Encontros</a>
            <span style="margin: 0 0.5rem;">›</span>
            <span style="color: var(--primary-red);"><?= htmlspecialchars($meeting['nome']) ?></span>
        </nav>
    </div>
</section>

<!-- Conteúdo Principal -->
<section class="section" style="background-color: var(--white);">
    <div class="container">
        <div style="display: grid; grid-template-columns: 280px 1fr; gap: 2rem; align-items: start;">
            
            <!-- Sidebar com encontros relacionados -->
            <aside style="background: var(--gray-50); border-radius: var(--border-radius-lg); padding: 1.5rem; position: sticky; top: 100px;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; color: var(--gray-600); font-size: 0.9rem;">
                    <div style="display: grid; place-items: center; width: 28px; height: 28px; border-radius: 8px; background: var(--gray-200);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 18l-6-6 6-6"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--gray-800);"><?= htmlspecialchars($meeting['periodo_nome']) ?></div>
                        <div style="font-size: 0.8rem;"><?= htmlspecialchars($meeting['grupo_nome']) ?></div>
                    </div>
                </div>
                
                <?php if (!empty($relatedMeetings)): ?>
                    <h4 style="margin-bottom: 1rem; font-size: 1rem;">Outros Encontros</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <?php $i = 1; foreach ($relatedMeetings as $related): ?>
                            <a href="/encontro/<?= $related['id'] ?>" 
                               style="display: block; padding: 0.75rem; background: var(--white); border-radius: var(--border-radius); text-decoration: none; border: 1px solid var(--gray-200); transition: all var(--transition-fast);"
                               onmouseover="this.style.borderColor='var(--primary-red)'; this.style.transform='scale(1.02)'"
                               onmouseout="this.style.borderColor='var(--gray-200)'; this.style.transform='scale(1)'">
                                <div style="font-weight: 600; color: var(--gray-800); margin-bottom: 0.25rem; font-size: 0.9rem;">
                                    Encontro <?= $i ?>
                                </div>
                                <div style="font-size: 0.8rem; color: var(--gray-600); margin-bottom: 0.25rem;">
                                    <?= date('d/m/y', strtotime($related['data'])) ?>
                                </div>
                                <div style="font-size: 0.85rem; color: var(--gray-700);">
                                    <?= htmlspecialchars($related['nome']) ?>
                                </div>
                            </a>
                        <?php $i++; endforeach; ?>
                    </div>
                <?php endif; ?>
            </aside>
            
            <!-- Conteúdo Principal -->
            <main>
                <!-- Player de Vídeo -->
                <div style="margin-bottom: 2rem;">
                    <div style="position: relative; width: 100%; aspect-ratio: 16/9; border-radius: var(--border-radius-lg); overflow: hidden; box-shadow: var(--shadow-lg);">
                        <?php 
                        $videoId = (new Meeting())->getYouTubeVideoId($meeting['video']);
                        ?>
                        <iframe 
                            src="https://www.youtube.com/embed/<?= htmlspecialchars($videoId) ?>" 
                            title="<?= htmlspecialchars($meeting['nome']) ?>"
                            style="width: 100%; height: 100%; border: none;"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
                
                <!-- Informações do Encontro -->
                <div>
                    <!-- Cabeçalho -->
                    <div style="margin-bottom: 1.5rem;">
                        <div style="display: flex; gap: 0.75rem; margin-bottom: 1rem; flex-wrap: wrap;">
                            <span style="background: var(--primary-red); color: white; padding: 0.375rem 0.875rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                                <?= htmlspecialchars($meeting['grupo_nome']) ?>
                            </span>
                            <span style="background: var(--gray-200); color: var(--gray-700); padding: 0.375rem 0.875rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                                <?= htmlspecialchars($meeting['periodo_nome']) ?>
                            </span>
                        </div>
                        
                        <h1 style="font-size: clamp(1.75rem, 4vw, 2.5rem); margin-bottom: 0.75rem; line-height: 1.2;">
                            <?= htmlspecialchars($meeting['nome']) ?>
                        </h1>
                        
                        <div style="color: var(--gray-600); font-size: 1.1rem;">
                            📅 <?= (new Meeting())->formatDate($meeting['data'], 'd/m/Y H\hi') ?>
                        </div>
                    </div>
                    
                    <!-- Descrição -->
                    <div style="background: var(--gray-50); padding: 2rem; border-radius: var(--border-radius-lg); border-left: 4px solid var(--primary-red);">
                        <h3 style="margin-bottom: 1rem; color: var(--gray-800);">Sobre este encontro</h3>
                        <div style="font-size: 1.1rem; line-height: 1.7; color: var(--gray-700);">
                            <?= nl2br(htmlspecialchars($meeting['texto'])) ?>
                        </div>
                    </div>
                    
                    <!-- Ações -->
                    <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="/encontros" class="btn btn-secondary">
                            ← Voltar aos Encontros
                        </a>
                        
                        <a href="https://www.youtube.com/watch?v=<?= htmlspecialchars($videoId) ?>" 
                           target="_blank" 
                           class="btn"
                           style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            📺 Ver no YouTube
                        </a>
                        
                        <!-- Botão de compartilhar -->
                        <button onclick="shareContent()" 
                                class="btn btn-secondary"
                                style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            🔗 Compartilhar
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>

<!-- JavaScript para funcionalidades -->
<script>
function shareContent() {
    if (navigator.share) {
        navigator.share({
            title: '<?= htmlspecialchars($meeting['nome']) ?>',
            text: 'Confira este encontro da Liga MackAI',
            url: window.location.href
        });
    } else {
        // Fallback para navegadores que não suportam Web Share API
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link copiado para a área de transferência!');
        });
    }
}

// Melhorar acessibilidade do player
document.addEventListener('DOMContentLoaded', function() {
    const iframe = document.querySelector('iframe');
    if (iframe) {
        iframe.setAttribute('tabindex', '0');
        iframe.setAttribute('aria-label', 'Player de vídeo do encontro <?= htmlspecialchars($meeting['nome']) ?>');
    }
});
</script>

<!-- Responsividade -->
<style>
@media (max-width: 768px) {
    .container > div {
        grid-template-columns: 1fr !important;
    }
    
    aside {
        order: 2;
        position: static !important;
    }
    
    main {
        order: 1;
    }
}
</style>
