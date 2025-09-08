#!/usr/bin/env bash
# replace_all.sh — Executa substituições em todos os .php
set -euo pipefail

ROOT="${1:-.}"

# 1) Trocar SYSCLINICA -> RT CLÍNICA MÉDICA (case-insensitive)
# 2) Remover "Hugo Curso" (case-insensitive)
# Requer GNU sed (em macOS: brew install gnu-sed e use gsed)

find "$ROOT" -type f -name "*.php" | while read -r f; do
  # Substituição case-insensitive de SYSCLINICA
  sed -i 's/[Ss][Yy][Ss][Cc][Ll][Ii][Nn][Ii][Cc][Aa]/RT CLÍNICA MÉDICA/g' "$f"
  # Remoção case-insensitive de "Hugo Curso"
  sed -i 's/[Hh][Uu][Gg][Oo][ ]*[Cc][Uu][Rr][Ss][Oo]//g' "$f"
  echo "Atualizado: $f"
done

echo "Concluído."
