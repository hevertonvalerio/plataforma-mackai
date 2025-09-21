<!-- Hero Section -->
<section class="hero" style="min-height: 60vh;">
    <div class="hero-content">
        <h1>Encontros da Liga</h1>
        <p>Explore nossos encontros sobre Inteligência Artificial e Ciência de Dados</p>
    </div>
</section>

<!-- Filtros -->
<section style="background-color: var(--white); padding: 2rem 0; border-bottom: 1px solid var(--gray-200);">
    <div class="container">
        <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <h3 style="margin: 0; color: var(--gray-800);">Filtrar por:</h3>
            
            <!-- Filtro por Grupo -->
            <select id="groupFilter" onchange="applyFilters()" style="padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: var(--border-radius); background: white;">
                <option value="">Todos os Grupos</option>
                <?php foreach ($groups as $group): ?>
                    <option value="<?= $group['id'] ?>" <?= $currentGroup == $group['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($group['nome']) ?> (<?= $group['total_encontros'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            
            <!-- Filtro por Período -->
            <select id="periodFilter" onchange="applyFilters()" style="padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: var(--border-radius); background: white;">
                <option value="">Todos os Períodos</option>
                <?php foreach ($periods as $period): ?>
                    <option value="<?= $period['id'] ?>" <?= $currentPeriod == $period['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($period['nome']) ?> (<?= $period['total_encontros'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            
            <!-- Limpar Filtros -->
            <?php if ($currentGroup || $currentPeriod): ?>
                <a href="/encontros" class="btn btn-secondary" style="padding: 0.5rem 1rem;">
                    Limpar Filtros
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Lista de Encontros -->
<section class="section">
    <div class="container">
        <?php if (!empty($meetings)): ?>
            <div class="grid grid-3">
                <?php foreach ($meetings as $meeting): ?>
                    <div class="card" style="transition: all var(--transition-normal);" 
                         onmouseover="this.style.transform='translateY(-8px)'" 
                         onmouseout="this.style.transform='translateY(0)'">
                        
                        <!-- Thumbnail do vídeo -->
                        <div style="position: relative; margin-bottom: 1rem; border-radius: var(--border-radius); overflow: hidden; background: var(--gray-100);">
                            <?php 
                            $videoId = (new Meeting())->getYouTubeVideoId($meeting['video']);
                            $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
                            ?>
                            <img src="<?= $thumbnailUrl ?>" 
                                 alt="Thumbnail de <?= htmlspecialchars($meeting['nome']) ?>"
                                 style="width: 100%; aspect-ratio: 16/9; object-fit: cover;"
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIwIiBoZWlnaHQ9IjE4MCIgdmlld0JveD0iMCAwIDMyMCAxODAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIzMjAiIGhlaWdodD0iMTgwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xNDQgNzJMMTc2IDkwTDE0NCAxMDhWNzJaIiBmaWxsPSIjOUNBM0FGIi8+Cjwvc3ZnPgo='">
                            
                            <!-- Play button overlay -->
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.7); border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Informações do encontro -->
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
                            <span style="background: var(--primary-red); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                <?= htmlspecialchars($meeting['grupo_nome']) ?>
                            </span>
                            <span style="background: var(--gray-200); color: var(--gray-700); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                <?= htmlspecialchars($meeting['periodo_nome']) ?>
                            </span>
                        </div>
                        
                        <h3 style="margin-bottom: 0.75rem; line-height: 1.3;">
                            <?= htmlspecialchars($meeting['nome']) ?>
                        </h3>
                        
                        <p style="color: var(--gray-600); font-size: 0.9rem; margin-bottom: 0.5rem;">
                            📅 <?= (new Meeting())->formatDate($meeting['data'], 'd/m/Y') ?> • 
                            ⏱️ <?= (new Meeting())->formatDate($meeting['data'], 'H\hi') ?>
                        </p>
                        
                        <p style="color: var(--gray-700); line-height: 1.5; margin-bottom: 1.5rem;">
                            <?= htmlspecialchars(substr($meeting['texto'], 0, 120)) ?>...
                        </p>
                        
                        <a href="/encontro/<?= $meeting['id'] ?>" class="btn" style="width: 100%; text-align: center;">
                            Assistir Encontro
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Estado vazio -->
            <div style="text-align: center; padding: 4rem 2rem; color: var(--gray-600);">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                <h3 style="margin-bottom: 1rem; color: var(--gray-700);">Nenhum encontro encontrado</h3>
                <p style="margin-bottom: 2rem;">
                    <?php if ($currentGroup || $currentPeriod): ?>
                        Não há encontros para os filtros selecionados. Tente ajustar os filtros ou
                        <a href="/encontros" style="color: var(--primary-red);">ver todos os encontros</a>.
                    <?php else: ?>
                        Os encontros serão exibidos aqui conforme forem sendo realizados.
                    <?php endif; ?>
                </p>
                
                <?php if ($currentGroup || $currentPeriod): ?>
                    <a href="/encontros" class="btn">Ver Todos os Encontros</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- JavaScript para filtros -->
<script>
function applyFilters() {
    const groupFilter = document.getElementById('groupFilter').value;
    const periodFilter = document.getElementById('periodFilter').value;
    
    let url = '/encontros';
    const params = new URLSearchParams();
    
    if (groupFilter) params.append('grupo', groupFilter);
    if (periodFilter) params.append('periodo', periodFilter);
    
    if (params.toString()) {
        url += '?' + params.toString();
    }
    
    window.location.href = url;
}

// Melhorar acessibilidade
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar navegação por teclado nos cards
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        const link = card.querySelector('a[href^="/encontro/"]');
        if (link) {
            card.setAttribute('tabindex', '0');
            card.setAttribute('role', 'button');
            card.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    link.click();
                }
            });
        }
    });
});
</script>

<?php if (isset($error)): ?>
<div style="background: #f8d7da; color: #721c24; padding: 1rem; margin: 1rem; border-radius: var(--border-radius); text-align: center;">
    <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>
