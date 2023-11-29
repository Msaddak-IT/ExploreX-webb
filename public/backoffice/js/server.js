const express = require('express');
const app = express();
const bodyParser = require('body-parser');
const path = require('path');

// Compteurs de likes et dislikes en mémoire
const offreCounts = {};

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Endpoint pour liker ou disliker une offre
app.post('/clientoffres', (req, res) => {
  const offreId = req.body.offreId;
  const action = req.body.action;

  if (!offreCounts[offreId]) {
    offreCounts[offreId] = { likeCount: 0, dislikeCount: 0 };
  }

  if (action === 'like') {
    offreCounts[offreId].likeCount++;
  } else if (action === 'dislike') {
    offreCounts[offreId].dislikeCount++;
  }

  res.json({
    success: true,
    likeCount: offreCounts[offreId].likeCount,
    dislikeCount: offreCounts[offreId].dislikeCount
  });
});

app.get('/offres/:offreId/counts', (req, res) => {
  const offreId = req.params.offreId;
  const counts = offreCounts[offreId] || { likeCount: 0, dislikeCount: 0 };

  res.json(counts);
});

app.use(express.static(path.join(__dirname, 'public')));

app.listen(8000, () => {
  console.log('Serveur écoutant sur le port 8000');
});
