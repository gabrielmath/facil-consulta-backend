# 🩺 Fácil Consulta - Backend (Laravel API)

Este repositório contém o backend do sistema **Fácil Consulta**, desenvolvido como parte de um teste técnico.  
O objetivo principal é disponibilizar uma **API** que simula um sistema de agendamento simplificado de consultas
médicas.

---

## 🎯 Finalidade do Projeto

A API foi desenvolvida para:

- 👩‍⚕️ Listar médicos com seus horários disponíveis;
- 📅 Permitir que pacientes agendem consultas em horários livres;
- 🔍 Disponibilizar endpoints para pacientes autenticados, trazendo:
    - Consultas **agendadas** (futuras);
    - Consultas **realizadas** (histórico).

O foco está em oferecer endpoints claros e bem estruturados, utilizando os recursos modernos do **Laravel 12**.

---

## ⚙️ Ambiente de Desenvolvimento Utilizado no Teste

- **Sistema operacional**: Ubuntu rodando no **WSL2**
- **Gerenciamento de containers**: [Docker](https://www.docker.com/)
  via [Laravel Sail](https://laravel.com/docs/12.x/sail)
- **Framework**: [Laravel 12](https://laravel.com/)
- **Banco de dados**: [MariaDB 11](https://mariadb.org/)
- **Cache (não foi preciso)**: [Redis](https://redis.io/)
- **Testes automatizados**: [Pest](https://pestphp.com/) + banco em memória `sqlite`

### Recursos utilizados no Laravel

- **Requests** para validação
- **Resources** para formatação de respostas
- **Rules personalizadas**
- **Observers** para eventos de modelos
- **Seeders e Factories** para popular o banco
- **Testes automatizados** com **Pest**

---

## 🚀 Como rodar o projeto

### 1. Clonar o repositório

```bash
git clone <url-do-repositorio>
cd facil-consulta-backend
```

2. Instalar dependências

Caso o Composer não esteja instalado localmente, é possível rodar via container:

```bash
docker run --rm --interactive --tty \
--volume $PWD:/app \
--user $(id -u):$(id -g) \
composer install
```

3. Configurar variáveis de ambiente

Copiar o arquivo de exemplo .env:

```bash
cp .env.example .env
```

Gerar a chave da aplicação:

```bash
./vendor/bin/sail artisan key:generate
```

4. Subir containers

```bash
./vendor/bin/sail up -d
```

5. Rodar migrations e seeders

```bash
./vendor/bin/sail artisan migrate --seed
```

🧪 Rodando os testes

```bash
./vendor/bin/sail pest
```

### Lembrete

Para facilitar o uso do comando, recomendo criar um `alias` para o mesmo:

```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

Após, execute o comando da seguinte forma:

```bash
sail up -d
```

