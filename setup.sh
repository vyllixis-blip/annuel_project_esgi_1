#!/bin/bash

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m'

FORCE_INSTALL=false

for arg in "$@"; do
  case $arg in
    --reinstall|-r)
      FORCE_INSTALL=true
      ;;
    --clean|-c)
      echo -e "${YELLOW}Suppression de node_modules...${NC}"
      rm -rf node_modules
      FORCE_INSTALL=true
      ;;
    --help|-h)
      echo "Usage: ./setup.sh [options]"
      echo ""
      echo "Options:"
      echo "  (aucune)         Lancement rapide si les modules sont déjà installés"
      echo "  -r, --reinstall  Force la réinstallation des dépendances"
      echo "  -c, --clean      Supprime node_modules et réinstalle"
      echo "  -h, --help       Affiche ce message"
      exit 0
      ;;
    *)
      echo -e "${RED}Option inconnue : $arg${NC}"
      echo "Utilise --help pour voir les options disponibles."
      exit 1
      ;;
  esac
done

if [ "$FORCE_INSTALL" = false ] && [ -d "node_modules" ] && [ -f "package-lock.json" ]; then
  if [ "package.json" -nt "node_modules" ]; then
    echo -e "${YELLOW}package.json modifié, mise à jour des dépendances...${NC}"
    npm install
  else
    echo -e "${GREEN}Modules déjà installés — lancement direct.${NC}"
  fi
else
  echo -e "${BLUE}Installation des dépendances...${NC}"
  npm install
fi

echo -e "${GREEN}Lancement du serveur (nodemon)...${NC}"
npx nodemon server.js
