const express = require('express')
const app = express()
const cors = require('cors')
const path = require('node:path')

const PORT = 4000

app.use(cors())
app.use(express.static(path.join(__dirname, '')))

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'index.html'))
})

app.listen(PORT, () => {
    console.info(`Serveur démarré sur http://localhost:${PORT}`)
})
