# replace_all.ps1 — Corrige nomes e remove "Hugo Curso" em todos os .php
param(
  [string]$Root = "."
)

$ErrorActionPreference = "Stop"

# "RT CLINICA MEDICA" com acentos via escapes para evitar problemas de encoding no arquivo
$clinicName = "RT CL`u00CDNICA M`u00C9DICA"

# Lista de arquivos .php
$files = Get-ChildItem -Path $Root -Recurse -Filter *.php -File

foreach($f in $files){
  try {
    $content = Get-Content -Path $f.FullName -Raw -Encoding UTF8
  } catch {
    Write-Warning ("Nao foi possivel ler: {0} — {1}" -f $f.FullName, $_)
    continue
  }

  $new = $content

  # 1) SYSCLINICA -> RT CLINICA MEDICA (case-insensitive)
  $new = $new -replace '(?i)SYSCLINICA', $clinicName

  # 2) Remover "Hugo Curso" (com ou sem espaco extra, case-insensitive)
  $new = $new -replace '(?i)Hugo\s*Curso', ''

  if($new -ne $content){
    # backup .bak
    try {
      Copy-Item -Path $f.FullName -Destination ($f.FullName + ".bak") -Force
    } catch {
      Write-Warning ("Falha ao criar backup de {0}: {1}" -f $f.FullName, $_)
    }

    # salvar alteracoes
    Set-Content -Path $f.FullName -Value $new -Encoding UTF8
    Write-Host ("Atualizado: {0}" -f $f.FullName)
  }
}

Write-Host "Concluido."
