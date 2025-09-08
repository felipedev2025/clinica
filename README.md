# Sistema de Agendamento - RT Clínica Médica

Este projeto é um sistema em **PHP** desenvolvido para auxiliar na gestão de agendamentos clínicos, com telas modulares e integração em ambiente XAMPP.

## 🚀 Tecnologias
- PHP 8+
- MySQL
- XAMPP (ambiente de desenvolvimento local)

## ⚙️ Como rodar localmente
1. Instale o [XAMPP](https://www.apachefriends.org/).
2. Copie a pasta `clinica` para `C:\xampp\htdocs\`.
3. Inicie **Apache** e **MySQL** no XAMPP.
4. Importe o banco de dados (se aplicável).
5. Acesse no navegador: [http://localhost/clinica](http://localhost/clinica).

## 📌 Funcionalidades
- Cadastro e visualização de agendamentos.
- Tela de detalhes para consultas.
- Envio de informações via formulário.
- Estrutura modular com cabeçalho e rodapé.
- Scripts de automação para substituições em massa.

## 🗂 Estrutura de Arquivos
clinica/
│-- ajax/ # Scripts AJAX
│-- assets/ # Arquivos estáticos (CSS, JS, imagens)
│-- cron/ # Scripts de agendamento automático
│-- forms/ # Formulários do sistema
│-- sistema/ # Lógica do sistema
│-- .htaccess # Regras de servidor Apache
│-- agendamento.php # Tela de agendamentos
│-- cabecalho.php # Cabeçalho (layout)
│-- config.php # Configuração do sistema
│-- detalhes.php # Tela de detalhes
│-- enviar.php # Scripts de envio
│-- index.php # Página inicial
│-- rodape.php # Rodapé (layout)
│-- replace_all.ps1 # Script de substituição (Windows PowerShell)
│-- replace_all.sh # Script de substituição (Linux/Mac)
