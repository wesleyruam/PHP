# Projeto Pedra, Papel e Tesoura em PHP

Este é um projeto simples em PHP onde você pode criar e gerenciar lutadores que participam de lutas no jogo Pedra, Papel e Tesoura.

## Arquivos Principais

1. **index.php**
   - Este arquivo exibe a lista de lutadores registrados.
   - Permite selecionar dois lutadores para iniciar uma luta.

2. **criarLutador.php**
   - Um formulário que coleta informações sobre os lutadores.
   - Os lutadores são registrados em um arquivo .json para persistência.

3. **proc.php**
   - Mostra informações sobre os dois lutadores selecionados.
   - Ao pressionar o botão "Lutar", os lutadores escolhem entre pedra, papel ou tesoura.
   - Atualiza as estatísticas de vitórias e empates dos lutadores com base no resultado da luta.

## Como Executar

1. Certifique-se de ter um servidor PHP instalado localmente.
2. Clone este repositório em seu ambiente de desenvolvimento.
3. Navegue até o diretório do projeto usando o terminal.
4. Execute o servidor PHP usando o comando `php -S localhost:8000`.
5. Abra o navegador e acesse `http://localhost:8000/index.php`.

## Melhorias Futuras

Este é um projeto inicial, e você mencionou que ainda está aprendendo PHP. Aqui estão algumas sugestões de melhorias futuras:

- **Validação de Entrada:** Implementar validação de entrada nos formulários para garantir dados consistentes.
- **Melhorar Estrutura do Código:** Refatorar o código para seguir boas práticas e padrões de codificação em PHP.
- **Estilo e Design:** Adicionar estilos e melhorar o design da interface do usuário.
- **Banco de Dados:** Considerar a possibilidade de migrar para um banco de dados para uma persistência mais robusta.



Link aonde encontrei a informação dos pesos:

https://www.infoescola.com/esportes/categorias-por-peso-em-esportes-de-luta/

Link com a lista de paises:


https://gist.github.com/kalinchernev/486393efcca01623b18d


Link com Tutorial de leitura e escrita de arquivo json:

https://www.nidup.io/blog/manipulate-json-files-in-php


Elementos CSS:

https://uiverse.io/
