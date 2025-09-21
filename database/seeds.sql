-- Dados iniciais para MackAI OP-3
-- Baseado nos dados do OP-2 com melhorias

--
-- Inserindo dados na tabela `grupo`
--

INSERT INTO `grupo` (`id`, `nome`, `descricao`, `cor`, `ativo`, `created`, `updated`) VALUES
(1, 'Aprendizagem de Máquina', 'Estudo de algoritmos e técnicas de machine learning, desde conceitos básicos até implementações avançadas. Abordamos temas como redes neurais, deep learning, algoritmos de classificação e regressão.', '#CE2029', 1, '2025-08-12 12:53:33', '2025-08-12 12:53:33'),
(2, 'Processamento de Linguagem Natural', 'Exploração de técnicas para processamento e compreensão de linguagem natural por máquinas. Incluindo análise de sentimentos, chatbots, tradução automática e modelos de linguagem.', '#2E86AB', 1, '2025-08-12 12:53:33', '2025-08-12 12:53:33'),
(3, 'Ética em IA', 'Discussões sobre ética em inteligência artificial, vieses algorítmicos, responsabilidade social na tecnologia e impactos da IA na sociedade.', '#A23B72', 1, '2025-08-12 12:53:33', '2025-08-12 12:53:33'),
(4, 'Projetos Práticos', 'Desenvolvimento de projetos práticos aplicando conhecimentos de IA e ciência de dados. Desde prototipagem até implementação completa de soluções.', '#F18F01', 1, '2025-08-12 12:53:33', '2025-08-12 12:53:33');

--
-- Inserindo dados na tabela `periodo`
--

INSERT INTO `periodo` (`id`, `nome`, `data_inicio`, `data_fim`, `ativo`, `created`, `updated`) VALUES
(1, '2024/1', '2024-02-01', '2024-06-30', 0, '2025-08-12 12:54:42', '2025-08-12 12:54:42'),
(2, '2024/2', '2024-08-01', '2024-12-15', 0, '2025-08-12 12:54:42', '2025-08-12 12:54:42'),
(3, '2025/1', '2025-02-01', '2025-06-30', 0, '2025-08-12 12:54:42', '2025-08-12 12:54:42'),
(4, '2025/2', '2025-08-01', '2025-12-15', 1, '2025-08-12 12:54:42', '2025-08-12 12:54:42');

--
-- Inserindo dados na tabela `encontro`
--

INSERT INTO `encontro` (`id`, `grupo`, `periodo`, `data`, `nome`, `texto`, `video`, `thumbnail`, `duracao`, `visualizacoes`, `ativo`, `created`, `updated`) VALUES
(1, 1, 2, '2024-08-12 21:00:00', 'A História do Perceptron', 'Visão geral sobre o Perceptron, sua história e importância no desenvolvimento do campo do aprendizado de máquina. Exploramos desde os conceitos fundamentais propostos por Frank Rosenblatt até as limitações que levaram ao desenvolvimento de redes neurais mais complexas. Uma introdução essencial para entender os fundamentos da inteligência artificial moderna.', 'rc9cFq8M-Ys', NULL, 90, 156, 1, '2025-08-12 15:58:44', '2025-08-12 19:23:30'),

(2, 1, 2, '2024-08-19 21:00:00', 'Treinando a Rede Neural', 'Para treinar uma rede neural eficientemente, utilizamos o algoritmo de backpropagation. Neste encontro, exploramos como o gradiente descendente funciona na prática, como ajustar hiperparâmetros e como evitar problemas comuns como overfitting e underfitting. Incluímos exemplos práticos com Python e TensorFlow.', 'rc9cFq8M-Ys', NULL, 105, 89, 1, '2025-08-12 15:58:44', '2025-08-12 19:23:33'),

(3, 2, 2, '2024-08-26 21:00:00', 'Introdução ao Processamento de Linguagem Natural', 'Primeiro encontro sobre NLP, abordando conceitos fundamentais como tokenização, stemming, lemmatização e análise morfológica. Discutimos as principais bibliotecas Python para NLP como NLTK, spaCy e como preparar textos para análise computacional.', 'dQw4w9WgXcQ', NULL, 85, 67, 1, '2025-08-12 16:00:00', '2025-08-12 16:00:00'),

(4, 3, 2, '2024-09-02 21:00:00', 'Vieses Algorítmicos e Fairness em IA', 'Discussão sobre como algoritmos podem perpetuar ou amplificar vieses sociais. Analisamos casos reais de discriminação algorítmica em sistemas de contratação, justiça criminal e aprovação de crédito. Exploramos técnicas para detectar e mitigar vieses em modelos de machine learning.', 'dQw4w9WgXcQ', NULL, 95, 124, 1, '2025-08-12 16:15:00', '2025-08-12 16:15:00'),

(5, 4, 2, '2024-09-09 21:00:00', 'Projeto: Sistema de Recomendação', 'Início do projeto prático de desenvolvimento de um sistema de recomendação. Definimos os requisitos, escolhemos o dataset (MovieLens) e planejamos a arquitetura da solução. Abordamos diferentes tipos de filtragem: colaborativa, baseada em conteúdo e híbrida.', 'dQw4w9WgXcQ', NULL, 120, 78, 1, '2025-08-12 16:30:00', '2025-08-12 16:30:00'),

(6, 1, 2, '2024-09-16 21:00:00', 'Deep Learning com PyTorch', 'Introdução ao framework PyTorch para deep learning. Comparamos com TensorFlow, exploramos a construção de redes neurais profundas, técnicas de regularização como dropout e batch normalization. Implementamos uma CNN para classificação de imagens.', 'dQw4w9WgXcQ', NULL, 110, 145, 1, '2025-08-12 16:45:00', '2025-08-12 16:45:00'),

(7, 2, 2, '2024-09-23 21:00:00', 'Modelos de Linguagem e Transformers', 'Exploramos a arquitetura Transformer que revolucionou o NLP. Discutimos attention mechanisms, BERT, GPT e como esses modelos mudaram o estado da arte em tarefas de linguagem natural. Implementamos um exemplo prático de fine-tuning.', 'dQw4w9WgXcQ', NULL, 100, 203, 1, '2025-08-12 17:00:00', '2025-08-12 17:00:00'),

(8, 3, 2, '2024-09-30 21:00:00', 'IA Responsável e Transparência', 'Como desenvolver sistemas de IA de forma responsável? Discutimos princípios de transparência, explicabilidade (XAI), accountability e como comunicar limitações de modelos para stakeholders não-técnicos. Analisamos frameworks de governança de IA.', 'dQw4w9WgXcQ', NULL, 85, 91, 1, '2025-08-12 17:15:00', '2025-08-12 17:15:00');

--
-- Inserindo usuário administrador padrão
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `tipo`, `ativo`, `created`, `updated`) VALUES
(1, 'Administrador MackAI', 'admin@mackai.com.br', 'admin', 1, '2025-08-12 12:00:00', '2025-08-12 12:00:00');
