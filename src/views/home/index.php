<!-- Seção Hero -->
<section class="hero">
    <div class="hero-content">
        <h1>LIGA MACKAI</h1>
        <p>Liga Acadêmica de Ciência de Dados e Inteligência Artificial da Universidade Presbiteriana Mackenzie</p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="/encontros" class="btn">Ver Encontros</a>
            <a href="/sobre" class="btn btn-secondary">Saiba Mais</a>
        </div>
    </div>
    
    <!-- Indicadores -->
    <div style="position: absolute; bottom: 2rem; left: 2rem;">
        <div style="display: flex; gap: 0.5rem;">
            <div style="width: 10px; height: 10px; background: rgba(255,255,255,0.8); border-radius: 50%;"></div>
            <div style="width: 10px; height: 10px; background: rgba(255,255,255,0.4); border-radius: 50%;"></div>
            <div style="width: 10px; height: 10px; background: rgba(255,255,255,0.4); border-radius: 50%;"></div>
        </div>
    </div>
</section>

<!-- Estatísticas -->
<section class="section" style="background-color: var(--white);">
    <div class="container">
        <div class="grid grid-3">
            <div class="card text-center">
                <h3 style="font-size: 2.5rem; color: var(--primary-red); margin-bottom: 0.5rem;">
                    <?= $stats['total_meetings'] ?>
                </h3>
                <h4>Encontros Realizados</h4>
                <p>Encontros sobre diversos temas de IA e Ciência de Dados</p>
            </div>
            
            <div class="card text-center">
                <h3 style="font-size: 2.5rem; color: var(--primary-red); margin-bottom: 0.5rem;">
                    <?= $stats['total_groups'] ?>
                </h3>
                <h4>Grupos de Estudo</h4>
                <p>Diferentes áreas de especialização em IA</p>
            </div>
            
            <div class="card text-center">
                <h3 style="font-size: 2.5rem; color: var(--primary-red); margin-bottom: 0.5rem;">
                    <?= $stats['current_period']['nome'] ?? '2024/2' ?>
                </h3>
                <h4>Período Atual</h4>
                <p>Semestre letivo em andamento</p>
            </div>
        </div>
    </div>
</section>

<!-- Encontros Recentes -->
<?php if (!empty($recentMeetings)): ?>
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Encontros Recentes</h2>
            <p>Confira os últimos encontros realizados pela liga</p>
        </div>
        
        <div class="grid grid-3">
            <?php foreach ($recentMeetings as $meeting): ?>
                <div class="card">
                    <div style="background: var(--gray-100); border-radius: var(--border-radius); padding: 1rem; margin-bottom: 1rem;">
                        <span style="background: var(--primary-red); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                            <?= htmlspecialchars($meeting['grupo_nome']) ?>
                        </span>
                    </div>
                    
                    <h3><?= htmlspecialchars($meeting['nome']) ?></h3>
                    
                    <p style="color: var(--gray-600); font-size: 0.9rem; margin-bottom: 0.5rem;">
                        📅 <?= date('d/m/Y', strtotime($meeting['data'])) ?> • 
                        🎓 <?= htmlspecialchars($meeting['periodo_nome']) ?>
                    </p>
                    
                    <p><?= htmlspecialchars(substr($meeting['texto'], 0, 120)) ?>...</p>
                    
                    <a href="/encontro/<?= $meeting['id'] ?>" class="btn" style="margin-top: 1rem; display: inline-block;">
                        Ver Detalhes
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center" style="margin-top: 2rem;">
            <a href="/encontros" class="btn">Ver Todos os Encontros</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Grupos de Estudo -->
<?php if (!empty($activeGroups)): ?>
<section class="section" style="background-color: var(--white);">
    <div class="container">
        <div class="section-title">
            <h2>Grupos de Estudo</h2>
            <p>Explore as diferentes áreas de atuação da liga</p>
        </div>
        
        <div class="grid grid-2">
            <?php foreach ($activeGroups as $group): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($group['nome']) ?></h3>
                    
                    <?php
                    // Descrições dos grupos
                    $descriptions = [
                        'Aprendizagem de Máquina' => 'Estudo de algoritmos e técnicas de machine learning, desde conceitos básicos até implementações avançadas.',
                        'Processamento de Linguagem Natural' => 'Exploração de técnicas para processamento e compreensão de linguagem natural por máquinas.',
                        'Ética' => 'Discussões sobre ética em IA, vieses algorítmicos e responsabilidade social na tecnologia.',
                        'Projetos' => 'Desenvolvimento de projetos práticos aplicando conhecimentos de IA e ciência de dados.'
                    ];
                    
                    $icons = [
                        'Aprendizagem de Máquina' => '🤖',
                        'Processamento de Linguagem Natural' => '💬',
                        'Ética' => '⚖️',
                        'Projetos' => '🚀'
                    ];
                    ?>
                    
                    <div style="font-size: 3rem; margin-bottom: 1rem;">
                        <?= $icons[$group['nome']] ?? '📚' ?>
                    </div>
                    
                    <p><?= $descriptions[$group['nome']] ?? 'Grupo de estudos especializado em ' . htmlspecialchars($group['nome']) ?></p>
                    
                    <a href="/encontros?grupo=<?= $group['id'] ?>" class="btn" style="margin-top: 1rem; display: inline-block;">
                        Ver Encontros
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Call to Action -->
<section class="section" style="background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%); color: white;">
    <div class="container text-center">
        <h2 style="color: white; margin-bottom: 1rem;">Junte-se à Liga MackAI</h2>
        <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">
            Faça parte da comunidade de IA e Ciência de Dados do Mackenzie
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="/contato" class="btn">Entre em Contato</a>
            <a href="/sobre" class="btn btn-secondary">Saiba Mais</a>
        </div>
    </div>
</section>

<?php if (isset($error)): ?>
<div style="background: #f8d7da; color: #721c24; padding: 1rem; margin: 1rem; border-radius: var(--border-radius); text-align: center;">
    <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>
