#!/bin/bash

echo "Installation des dépendances..."
npm install express cors
npm install --save-dev nodemon

echo ""
echo "Lancement du serveur..."
npx nodemon server.js
