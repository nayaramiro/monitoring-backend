# Utilise l'image officielle Node.js (version 18 par exemple)
FROM node:18

# Crée et place dans le dossier /app
WORKDIR /app

# Copie package.json et package-lock.json (si tu as)
COPY package*.json ./

# Installe les dépendances
RUN npm install

# Copie le reste des fichiers (index.js, scripts, db, etc.)
COPY . .

# Expose le port sur lequel ton app tourne (par défaut 3000 ou autre)
EXPOSE 8080

# Commande pour lancer ton serveur Node.js
CMD ["node", "index.js"]
