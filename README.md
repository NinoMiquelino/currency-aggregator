## 👨‍💻 Autor

<div align="center">
  <img src="https://avatars.githubusercontent.com/ninomiquelino" width="100" height="100" style="border-radius: 50%">
  <br>
  <strong>Onivaldo Miquelino</strong>
  <br>
  <a href="https://github.com/ninomiquelino">@ninomiquelino</a>
</div>

---

# 💰 PHP Cache Layer: Currency Aggregator

![Made with PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![Frontend JavaScript](https://img.shields.io/badge/Frontend-JavaScript-F7DF1E?logo=javascript&logoColor=black)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-38B2AC?logo=tailwindcss&logoColor=white)
![License MIT](https://img.shields.io/badge/License-MIT-green)
![Status Stable](https://img.shields.io/badge/Status-Stable-success)
![Version 1.0.0](https://img.shields.io/badge/Version-1.0.0-blue)
![GitHub stars](https://img.shields.io/github/stars/NinoMiquelino/currency-aggregator?style=social)
![GitHub forks](https://img.shields.io/github/forks/NinoMiquelino/currency-aggregator?style=social)
![GitHub issues](https://img.shields.io/github/issues/NinoMiquelino/currency-aggregator)

Este projeto Full-Stack demonstra a importância e a implementação de uma camada de cache no lado do servidor (PHP). Ele simula um agregador de cotações de moedas que busca dados de uma API externa (AwesomeAPI), mas armazena a resposta em um arquivo JSON local por 5 minutos para otimizar o desempenho e reduzir a carga de chamadas externas.

---

## 🚀 Otimização e Cache

* **Cache de Arquivo:** O PHP usa funções nativas (`file_exists`, `filemtime`, `file_put_contents`) para verificar, ler e escrever o cache.
* **Política de Expiração (TTL):** O cache expira após **300 segundos (5 minutos)**. Se uma requisição chegar dentro desse período, o PHP serve o arquivo local JSON.
* **API Externa:** Utiliza a API pública da AwesomeAPI para obter cotações de Dólar (USD-BRL), Euro (EUR-BRL) e Bitcoin (BTC-BRL).
* **Feedback Visual:** O frontend JavaScript (Vanilla) mostra claramente se os dados vieram do "Cache" (rápido) ou da "API Externa" (lento/novo).

---

## 🧠 Tecnologias utilizadas

* **Backend:** PHP 7.4+ (Lógica de Cache e chamadas HTTP via `file_get_contents`).
* **Frontend:** HTML5, JavaScript Vanilla e `fetch` API.
* **Estilização:** Tailwind CSS (via CDN).

---

## 🧩 Estrutura do Projeto

```
currency-aggregator/
├── index.html
├── api.php
├── README.md
├── .gitignore
└── LICENSE
```
---

## ⚙️ Configuração e Instalação

### Pré-requisitos

1.  Um ambiente de servidor web com PHP.
2.  Permissão de escrita na pasta de cache.

### 1. Estrutura e Pasta de Cache

1.  Crie a estrutura de pastas.
2.  **Crie a pasta de cache:** `mkdir src/cache`
3.  **Defina as permissões:** Garanta que a pasta `src/cache` tenha permissão de escrita para o usuário do servidor web (ex: `chmod 755 src/cache/` em Linux/macOS).

### 2. Executar o Servidor

Utilize o servidor embutido do PHP para testes (a partir da raiz do projeto):

```bash
php -S localhost:8001
```
​- Acesse: O frontend estará disponível em http://localhost:8001/public/index.html.

---
​## 📝 Demonstração da Lógica de Cache
​Primeira Visita: Ao carregar a página e clicar em "Recarregar", a aplicação fará a chamada à API Externa. O status mostrará "API EXTERNA". Um arquivo currency_cache.json será criado em src/cache/.
​Visitas Consecutivas (dentro de 5 minutos): Clique em "Recarregar". O status mudará imediatamente para "CACHE". O PHP ignorou a chamada à API externa, lendo o arquivo local.
​Visita Após 5 Minutos: Após esperar mais de 5 minutos (ou a duração que você definiu em CACHE_DURATION_SECONDS), o próximo clique em "Recarregar" fará com que o PHP detecte que o arquivo expirou. O status voltará a mostrar "API EXTERNA" e um novo arquivo de cache será salvo.

---

## 🤝 Contribuições
Contribuições são sempre bem-vindas!  
Sinta-se à vontade para abrir uma [*issue*](https://github.com/NinoMiquelino/currency-aggregator/issues) com sugestões ou enviar um [*pull request*](https://github.com/NinoMiquelino/currency-aggregator/pulls) com melhorias.

---

## 💬 Contato
📧 [Entre em contato pelo LinkedIn](https://www.linkedin.com/in/onivaldomiquelino/)  
💻 Desenvolvido por **Onivaldo Miquelino**

---
